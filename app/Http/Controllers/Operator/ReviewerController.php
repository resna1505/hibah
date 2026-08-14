<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Dosen;
use App\Models\Master\Fakultas;
use App\Models\Master\Keahlian;
use App\Models\Master\Prodi;
use App\Models\Transaction\PenugasanReviewer;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Models\User;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class ReviewerController extends Controller
{
    public function __construct(private NotifikasiService $notif) {}

    /**
     * Data Reviewer — list dosen, toggle flag is_reviewer.
     */
    public function dataIndex(Request $request)
    {
        $list = Dosen::with('fakultas', 'keahlian')
            ->when($request->search, fn($q, $s) => $q->where('nama_lengkap', 'like', "%{$s}%"))
            ->when($request->fakultas_id, fn($q, $id) => $q->where('fakultas_id', $id))
            ->when($request->filter === 'reviewer', fn($q) => $q->where('is_reviewer', true))
            ->when($request->filter === 'nonreviewer', fn($q) => $q->where('is_reviewer', false))
            ->orderBy('nama_lengkap')
            ->paginate(20)->withQueryString();

        return view('operator.reviewer.data', [
            'list'         => $list,
            'fakultasList' => Fakultas::orderBy('nama')->get(),
            'filters'      => $request->only(['search', 'fakultas_id', 'filter']),
        ]);
    }

    /**
     * Form tambah reviewer baru (sekaligus create dosen baru).
     */
    public function createForm(Request $request)
    {
        return view('operator.reviewer.create', [
            'fakultasList' => Fakultas::orderBy('nama')->get(),
            'prodiList'    => Prodi::orderBy('nama')->get(['id', 'fakultas_id', 'nama']),
            'keahlianList' => Keahlian::orderBy('nama')->get(),
        ]);
    }

    /**
     * Simpan dosen baru sebagai reviewer (set is_reviewer=true).
     */
    public function storeNew(Request $request)
    {
        $data = $request->validate([
            'nik'                 => 'required|string|max:30|unique:users_m,nik',
            'email'               => 'required|email|max:255|unique:users_m,email',
            'password'            => ['required', 'confirmed', Password::min(6)],
            'nama_lengkap'        => 'required|string|max:200',
            'nidn'                => 'nullable|string|max:20|unique:dosen_m,nidn',
            'fakultas_id'         => 'required|exists:fakultas_m,id',
            'prodi_id'            => 'required|exists:prodi_m,id',
            'jabatan_fungsional'  => 'nullable|in:Tenaga Pengajar,Asisten Ahli,Lektor,Lektor Kepala,Profesor',
            'pendidikan_terakhir' => 'nullable|in:S1,S2,S3',
            'no_hp'               => 'nullable|string|max:25',
            'keahlian_ids'        => 'array',
            'keahlian_ids.*'      => 'exists:keahlian_m,id',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'nik'       => $data['nik'],
                'email'     => $data['email'],
                'password'  => $data['password'],
                'role'      => 'dosen',
                'is_active' => true,
            ]);

            $dosen = Dosen::create([
                'user_id'             => $user->id,
                'fakultas_id'         => $data['fakultas_id'],
                'prodi_id'            => $data['prodi_id'],
                'nama_lengkap'        => $data['nama_lengkap'],
                'nidn'                => $data['nidn'] ?? null,
                'jabatan_fungsional'  => $data['jabatan_fungsional'] ?? null,
                'pendidikan_terakhir' => $data['pendidikan_terakhir'] ?? null,
                'no_hp'               => $data['no_hp'] ?? null,
                'status_aktif_mengajar' => true,
                'is_reviewer'         => true, // langsung set sebagai reviewer
            ]);

            if (! empty($data['keahlian_ids'])) {
                $dosen->keahlian()->sync($data['keahlian_ids']);
            }
        });

        return redirect()->route('operator.reviewer.data')
            ->with('success', "Reviewer baru '{$data['nama_lengkap']}' berhasil ditambahkan.");
    }

    public function toggleReviewer(Request $request, Dosen $dosen)
    {
        $dosen->update(['is_reviewer' => ! $dosen->is_reviewer]);

        $msg = $dosen->is_reviewer
            ? "{$dosen->nama_lengkap} sekarang aktif sebagai Reviewer."
            : "{$dosen->nama_lengkap} dinonaktifkan sebagai Reviewer.";

        return back()->with('success', $msg);
    }

    /**
     * Penugasan Reviewer — list proposal yang sudah diverifikasi lengkap, belum ditugaskan 2 reviewer.
     */
    public function penugasanIndex(Request $request)
    {
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $list = Proposal::with(['ketua.fakultas', 'skemaHibah', 'penugasanReviewer.reviewer'])
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))
            ->whereIn('status', ['verifikasi', 'direview'])
            ->when($request->search, fn($q, $s) => $q->where('judul', 'like', "%{$s}%"))
            ->latest('tgl_submit')
            ->paginate(15)->withQueryString();

        return view('operator.reviewer.penugasan', [
            'list'         => $list,
            'periodeAktif' => $periodeAktif,
            'filters'      => $request->only(['search']),
        ]);
    }

    public function assignForm(Request $request, Proposal $proposal)
    {
        abort_unless(in_array($proposal->status, ['verifikasi', 'direview']),
            403, 'Status proposal tidak valid untuk penugasan reviewer.');

        $proposal->load('ketua', 'skemaHibah', 'penugasanReviewer.reviewer.keahlian');

        // Reviewer eligible: dosen is_reviewer=true, bukan ketua proposal, bukan anggota proposal
        $excludeIds = [$proposal->ketua_dosen_id];
        $excludeIds = array_merge($excludeIds, $proposal->anggota->pluck('dosen_id')->filter()->all());

        $reviewerTersedia = Dosen::with('fakultas', 'prodi', 'keahlian')
            ->where('is_reviewer', true)
            ->whereNotIn('id', $excludeIds)
            ->orderBy('nama_lengkap')
            ->get();

        return view('operator.reviewer.assign', [
            'p'                => $proposal,
            'reviewerTersedia' => $reviewerTersedia,
            'currentAssignments' => $proposal->penugasanReviewer->keyBy('peran'),
        ]);
    }

    public function assignSubmit(Request $request, Proposal $proposal)
    {
        abort_unless(in_array($proposal->status, ['verifikasi', 'direview']),
            403, 'Status proposal tidak valid.');

        $data = $request->validate([
            'reviewer_1_id' => 'required|exists:dosen_m,id',
            'reviewer_2_id' => 'nullable|exists:dosen_m,id|different:reviewer_1_id',
            'deadline'      => 'required|date|after:today',
        ], [
            'reviewer_2_id.different' => 'Reviewer 2 tidak boleh sama dengan Reviewer 1.',
        ]);

        // Pastikan reviewer bukan ketua/anggota
        $excludeIds = array_merge(
            [$proposal->ketua_dosen_id],
            $proposal->anggota->pluck('dosen_id')->filter()->all()
        );
        foreach (['reviewer_1_id', 'reviewer_2_id'] as $key) {
            if (! empty($data[$key]) && in_array($data[$key], $excludeIds)) {
                return back()->withErrors([$key => 'Reviewer tidak boleh ketua/anggota proposal itu sendiri.']);
            }
        }

        $diinginkan = array_filter([
            'reviewer_1' => $data['reviewer_1_id'],
            'reviewer_2' => $data['reviewer_2_id'] ?? null,
        ]);

        // Penugasan yang benar-benar baru dibuat — hanya mereka yang perlu dinotifikasi,
        // agar reviewer lama tidak dikirimi ulang saat operator sekadar menambah rekan.
        $baru = [];

        DB::transaction(function () use ($data, $proposal, $request, $diinginkan, &$baru) {
            $terpasang = $proposal->penugasanReviewer()->get()->keyBy('peran');

            // Tahap 1 — cabut penugasan yang tidak lagi sesuai: perannya dikosongkan,
            // atau reviewernya diganti orang. Penilaian ikut terhapus (cascade) memang
            // karena itu penilaian milik reviewer yang dicabut.
            // Dijalankan terpisah sebelum tahap 2 supaya penukaran Reviewer 1 <-> 2
            // tidak menabrak unique (proposal_id, reviewer_dosen_id).
            foreach ($terpasang as $peran => $penugasan) {
                if (($diinginkan[$peran] ?? null) != $penugasan->reviewer_dosen_id) {
                    $penugasan->delete();
                    $terpasang->forget($peran);
                }
            }

            // Tahap 2 — reviewer yang tetap cukup diperbarui deadline-nya. Penugasan
            // TIDAK dibuat ulang, sehingga penilaian yang sudah masuk tetap aman.
            foreach ($diinginkan as $peran => $dosenId) {
                if ($penugasan = $terpasang->get($peran)) {
                    $penugasan->update(['deadline' => $data['deadline']]);
                    continue;
                }

                PenugasanReviewer::create([
                    'proposal_id'       => $proposal->id,
                    'reviewer_dosen_id' => $dosenId,
                    'peran'             => $peran,
                    'deadline'          => $data['deadline'],
                    'status'            => 'ditugaskan',
                    'ditugaskan_oleh'   => $request->user()->id,
                ]);

                $baru[$peran] = $dosenId;
            }

            $proposal->update(['status' => 'direview']);
        });

        foreach ($baru as $peran => $dosenId) {
            if ($reviewer = Dosen::find($dosenId)) {
                $this->notif->onReviewerAssigned($proposal, $reviewer, $peran, $data['deadline']);
            }
        }

        $jumlah = count($diinginkan);

        return redirect()->route('operator.reviewer.penugasan')
            ->with('success', "Penugasan disimpan: {$jumlah} reviewer. Status proposal: direview.");
    }

    /**
     * Monitoring Reviewer — list reviewer + statistik jumlah penugasan + progress.
     */
    public function monitoringIndex(Request $request)
    {
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $reviewers = Dosen::with('fakultas')
            ->where('is_reviewer', true)
            ->withCount([
                'penugasanReview as total_tugas' => fn($q) => $periodeAktif
                    ? $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))
                    : $q,
                'penugasanReview as selesai' => fn($q) => $q->where('status', 'selesai')->when(
                    $periodeAktif, fn($qq) => $qq->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))),
                'penugasanReview as sedang' => fn($q) => $q->where('status', 'sedang_review')->when(
                    $periodeAktif, fn($qq) => $qq->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))),
                'penugasanReview as belum' => fn($q) => $q->where('status', 'ditugaskan')->when(
                    $periodeAktif, fn($qq) => $qq->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))),
            ])
            ->orderBy('nama_lengkap')
            ->paginate(20);

        return view('operator.reviewer.monitoring', [
            'list'         => $reviewers,
            'periodeAktif' => $periodeAktif,
        ]);
    }
}
