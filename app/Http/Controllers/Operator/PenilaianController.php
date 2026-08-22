<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Transaction\LogAktivitas;
use App\Models\Transaction\PenugasanReviewer;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Services\NotifikasiService;
use App\Services\PenilaianService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function __construct(private PenilaianService $service, private NotifikasiService $notif) {}

    /**
     * List proposal yang sudah/sedang direview untuk operator finalize.
     */
    public function index(Request $request)
    {
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $list = Proposal::with(['ketua.fakultas', 'skemaHibah', 'penugasanReviewer.penilaian'])
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))
            ->whereIn('status', ['direview', 'revisi_minor', 'revisi_mayor', 'disetujui', 'ditolak'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->search, fn($q, $s) => $q->where(function ($q2) use ($s) {
                $q2->where('judul', 'like', "%{$s}%")
                    ->orWhereHas('ketua', fn($q3) => $q3->where('nama_lengkap', 'like', "%{$s}%"));
            }))
            ->latest('tgl_submit')
            ->paginate(15)->withQueryString();

        // Statistik kategori nilai (untuk donut)
        $semuaProposalFinal = Proposal::whereHas('penugasanReviewer.penilaian')
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))
            ->with('penugasanReviewer.penilaian')
            ->get();

        $distribusi = ['sangat_baik' => 0, 'baik' => 0, 'cukup' => 0, 'kurang' => 0, 'sangat_kurang' => 0];
        $totalNilai = []; $totalProposal = 0;
        foreach ($semuaProposalFinal as $p) {
            $agg = $this->service->agregasi($p);
            if ($agg['jumlah_selesai'] === 0) continue;
            $totalProposal++;
            $totalNilai[] = $agg['rata_rata'];
            $key = match (true) {
                $agg['rata_rata'] >= 85 => 'sangat_baik',
                $agg['rata_rata'] >= 70 => 'baik',
                $agg['rata_rata'] >= 55 => 'cukup',
                $agg['rata_rata'] >= 40 => 'kurang',
                default                  => 'sangat_kurang',
            };
            $distribusi[$key]++;
        }

        $stats = [
            'total_dinilai' => $totalProposal,
            'rata_rata'     => count($totalNilai) > 0 ? round(array_sum($totalNilai) / count($totalNilai), 2) : 0,
            'tertinggi'     => count($totalNilai) > 0 ? max($totalNilai) : 0,
            'terendah'      => count($totalNilai) > 0 ? min($totalNilai) : 0,
            'distribusi'    => $distribusi,
        ];

        return view('operator.penilaian.index', compact('list', 'periodeAktif', 'stats'));
    }

    /**
     * Detail penilaian + form finalize.
     */
    public function show(Request $request, Proposal $proposal)
    {
        $proposal->load([
            'skemaHibah.kriteriaPenilaian',
            'periodeHibah',
            'ketua.fakultas',
            'ketua.prodi',
            'penugasanReviewer.reviewer',
            'penugasanReviewer.penilaian.detail.kriteria',
        ]);

        $agregasi = $this->service->agregasi($proposal);

        return view('operator.penilaian.show', [
            'p'        => $proposal,
            'agregasi' => $agregasi,
            'kategori' => $this->service->kategoriNilai($agregasi['rata_rata']),
        ]);
    }

    /**
     * Operator finalize keputusan akhir.
     */
    public function finalize(Request $request, Proposal $proposal)
    {
        abort_unless(in_array($proposal->status, ['direview', 'revisi_minor', 'revisi_mayor']),
            403, 'Status proposal tidak valid untuk finalisasi.');

        $data = $request->validate([
            'keputusan'  => 'required|in:disetujui,revisi_minor,revisi_mayor,ditolak',
            'catatan'    => 'required|string|max:2000',
        ]);

        $agregasi = $this->service->agregasi($proposal);
        if ($agregasi['jumlah_selesai'] === 0) {
            return back()->with('error', 'Belum ada reviewer yang menyelesaikan penilaian.');
        }

        DB::transaction(function () use ($data, $proposal, $request, $agregasi) {
            $proposal->update([
                'status' => $data['keputusan'],
                'total_anggaran' => $proposal->rab()->sum('sub_total'),
            ]);

            LogAktivitas::create([
                'user_id'    => $request->user()->id,
                'modul'      => 'penilaian',
                'aktivitas'  => 'finalisasi',
                'deskripsi'  => "Finalisasi proposal #{$proposal->id} '{$proposal->judul}' → status: {$data['keputusan']}"
                                . " (rata-rata nilai: {$agregasi['rata_rata']}). Catatan: {$data['catatan']}",
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);
        });

        $this->notif->onProposalFinalized($proposal->fresh()->load('skemaHibah', 'ketua'), $data['keputusan']);

        $msg = match ($data['keputusan']) {
            'disetujui'    => 'Proposal disetujui. Dosen dapat mulai melaksanakan kegiatan & upload laporan.',
            'revisi_minor' => 'Proposal harus revisi minor. Dosen dapat edit kembali.',
            'revisi_mayor' => 'Proposal harus revisi mayor. Dosen dapat edit kembali.',
            'ditolak'      => 'Proposal ditolak.',
        };

        return redirect()->route('operator.penilaian.show', $proposal)
            ->with('success', 'Keputusan tersimpan. ' . $msg);
    }

    /**
     * Buka kembali penilaian seorang reviewer yang sudah disubmit, agar ia bisa
     * memperbaikinya. Cukup mengembalikan status penugasan ke 'sedang_review':
     * seluruh halaman reviewer sudah mendukung status itu, dan penilaian lama
     * tetap tersimpan sehingga otomatis menjadi isian awal form.
     *
     * Penutupnya memakai mekanisme yang sudah ada — reviewer submit ulang
     * (status kembali 'selesai'), atau operator memfinalisasi proposal.
     */
    public function bukaPenilaian(Request $request, Proposal $proposal, PenugasanReviewer $penugasan)
    {
        abort_unless($penugasan->proposal_id === $proposal->id, 404);

        // Setelah difinalisasi, penilaian terkunci — keputusan sudah disampaikan ke dosen.
        if ($proposal->status !== 'direview') {
            return back()->with('error', 'Penilaian hanya dapat dibuka selama proposal masih dalam tahap review.');
        }

        if ($penugasan->status !== 'selesai') {
            return back()->with('error', 'Penilaian reviewer ini memang belum disubmit, jadi masih bisa diisi.');
        }

        $data = $request->validate([
            'alasan' => 'required|string|max:500',
        ], [
            'alasan.required' => 'Alasan pembukaan wajib diisi.',
        ]);

        $penugasan->load('reviewer', 'penilaian');
        $nilaiLama = $penugasan->penilaian?->nilai_total;

        DB::transaction(function () use ($penugasan, $proposal, $request, $data, $nilaiLama) {
            $penugasan->update(['status' => 'sedang_review']);

            LogAktivitas::create([
                'user_id'    => $request->user()->id,
                'modul'      => 'penilaian',
                'aktivitas'  => 'buka_penilaian',
                'deskripsi'  => "Membuka kembali penilaian {$penugasan->peran} ("
                                . ($penugasan->reviewer?->nama_lengkap ?? 'reviewer') . ") "
                                . "pada proposal #{$proposal->id} '{$proposal->judul}'. "
                                . 'Nilai sebelumnya: ' . ($nilaiLama !== null ? number_format($nilaiLama, 2) : '-')
                                . ". Alasan: {$data['alasan']}",
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);
        });

        if ($penugasan->reviewer) {
            $this->notif->onPenilaianDibukaKembali($proposal, $penugasan->reviewer, $data['alasan']);
        }

        $nama = $penugasan->reviewer?->nama_lengkap ?? 'Reviewer';

        return back()->with('success', "Penilaian {$nama} dibuka kembali. "
            . 'Nilainya tidak dihitung dalam rata-rata sampai ia submit ulang.');
    }
}
