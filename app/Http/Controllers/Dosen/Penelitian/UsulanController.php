<?php

namespace App\Http\Controllers\Dosen\Penelitian;

use App\Http\Controllers\Controller;
use App\Models\Master\Dosen;
use App\Models\Master\KategoriRab;
use App\Models\Master\SkemaHibah;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Models\Transaction\ProposalAnggota;
use App\Models\Transaction\ProposalRab;
use App\Services\NotifikasiService;
use App\Services\ProposalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsulanController extends Controller
{
    public function __construct(private ProposalService $service, private NotifikasiService $notif) {}

    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen, 403);

        $list = Proposal::with(['skemaHibah', 'periodeHibah'])
            ->where('ketua_dosen_id', $dosen->id)
            ->whereHas('skemaHibah', fn($q) => $q->where('jenis', 'penelitian'))
            ->latest()
            ->get();

        return view('dosen.penelitian.index', compact('list'));
    }

    public function create(Request $request)
    {
        $dosen = $request->user()->dosen;
        $periode = PeriodeHibah::aktif()->first();

        if (! $periode) {
            return redirect()->route('dosen.penelitian.index')
                ->with('error', 'Belum ada periode hibah aktif.');
        }

        if (! $this->service->tahapanPengajuanAktif()) {
            return redirect()->route('dosen.penelitian.index')
                ->with('error', 'Tahapan pengajuan belum dibuka atau sudah berakhir.');
        }

        // Cek sudah ada usulan Penelitian aktif?
        $skemaPenelitian = SkemaHibah::where('jenis', 'penelitian')->where('is_active', true)->first();
        $existing = Proposal::where('periode_hibah_id', $periode->id)
            ->where('ketua_dosen_id', $dosen->id)
            ->where('skema_hibah_id', $skemaPenelitian->id)
            ->first();

        if ($existing) {
            return redirect()->route('dosen.penelitian.edit', $existing)
                ->with('success', 'Anda sudah memiliki usulan Penelitian pada periode ini. Lanjut edit.');
        }

        return view('dosen.penelitian.form', [
            'proposal'      => null,
            'skema'         => $skemaPenelitian,
            'periode'       => $periode,
            'dosenList'     => Dosen::where('id', '!=', $dosen->id)->orderBy('nama_lengkap')->get(['id', 'nama_lengkap']),
            'kategoriRab'   => KategoriRab::orderBy('urutan')->get(),
            'anggotaDosen'  => collect(),
            'mahasiswa'     => collect(),
            'rabItems'      => collect(),
        ]);
    }

    public function store(Request $request)
    {
        $dosen = $request->user()->dosen;
        $periode = PeriodeHibah::aktif()->firstOrFail();
        $skema = SkemaHibah::where('jenis', 'penelitian')->firstOrFail();

        abort_unless($this->service->tahapanPengajuanAktif(), 403, 'Tahapan pengajuan ditutup.');

        $data = $this->validateProposal($request, $skema);

        $proposal = DB::transaction(function () use ($data, $dosen, $periode, $skema, $request) {
            $proposal = Proposal::create(array_merge($data['proposal'], [
                'periode_hibah_id' => $periode->id,
                'skema_hibah_id'   => $skema->id,
                'ketua_dosen_id'   => $dosen->id,
                'status'           => 'draft',
            ]));

            $this->syncAnggota($proposal, $request);
            $this->syncRab($proposal, $request);

            return $proposal;
        });

        return redirect()->route('dosen.penelitian.edit', $proposal)
            ->with('success', 'Draft proposal dibuat. Lengkapi semua bagian sebelum submit.');
    }

    public function edit(Request $request, Proposal $penelitian)
    {
        $this->authorizeOwner($request, $penelitian);

        if (! in_array($penelitian->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor'])) {
            return redirect()->route('dosen.penelitian.show', $penelitian)
                ->with('error', 'Proposal pada status ini tidak dapat diedit.');
        }

        return view('dosen.penelitian.form', [
            'proposal'      => $penelitian,
            'skema'         => $penelitian->skemaHibah,
            'periode'       => $penelitian->periodeHibah,
            'dosenList'     => Dosen::where('id', '!=', $request->user()->dosen->id)->orderBy('nama_lengkap')->get(['id', 'nama_lengkap']),
            'kategoriRab'   => KategoriRab::orderBy('urutan')->get(),
            'anggotaDosen'  => $penelitian->anggota()->where('peran', 'anggota_dosen')->with('dosen')->get(),
            'mahasiswa'     => $penelitian->anggota()->where('peran', 'mahasiswa')->get(),
            'rabItems'      => $penelitian->rab()->orderBy('kategori_rab_id')->get(),
        ]);
    }

    public function update(Request $request, Proposal $penelitian)
    {
        $this->authorizeOwner($request, $penelitian);

        abort_unless(in_array($penelitian->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']),
            403, 'Proposal tidak dapat diupdate.');

        $data = $this->validateProposal($request, $penelitian->skemaHibah);

        DB::transaction(function () use ($penelitian, $data, $request) {
            $penelitian->update($data['proposal']);
            $this->syncAnggota($penelitian, $request);
            $this->syncRab($penelitian, $request);
        });

        return back()->with('success', 'Perubahan disimpan.');
    }

    public function submit(Request $request, Proposal $penelitian)
    {
        $this->authorizeOwner($request, $penelitian);

        abort_unless(in_array($penelitian->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']),
            403, 'Status tidak valid untuk submit.');

        $errors = $this->service->validateForSubmit($penelitian);
        if (! empty($errors)) {
            return back()->with('error', 'Belum bisa submit: ' . implode(' ', $errors));
        }

        $penelitian->update([
            'status' => 'submitted',
            'tgl_submit' => now(),
            'total_anggaran' => $this->service->totalRab($penelitian),
        ]);

        $this->notif->onProposalSubmitted($penelitian->fresh()->load('skemaHibah', 'ketua'));

        return redirect()->route('dosen.penelitian.show', $penelitian)
            ->with('success', 'Proposal berhasil disubmit. Operator akan memverifikasi.');
    }

    public function destroy(Request $request, Proposal $penelitian)
    {
        $this->authorizeOwner($request, $penelitian);
        abort_unless($penelitian->status === 'draft', 403, 'Hanya draft yang bisa dihapus.');

        $penelitian->delete();

        return redirect()->route('dosen.penelitian.index')->with('success', 'Draft dihapus.');
    }

    public function show(Request $request, Proposal $penelitian)
    {
        $this->authorizeOwner($request, $penelitian);

        $penelitian->load(['skemaHibah', 'periodeHibah', 'ketua.fakultas', 'ketua.prodi',
            'anggota.dosen', 'rab.kategori']);

        return view('dosen.penelitian.show', [
            'p' => $penelitian,
            'totalRab' => $this->service->totalRab($penelitian),
            'service' => $this->service,
        ]);
    }

    public function pdf(Request $request, Proposal $penelitian)
    {
        $this->authorizeOwner($request, $penelitian);

        $penelitian->load(['skemaHibah', 'periodeHibah', 'ketua.fakultas', 'ketua.prodi',
            'anggota.dosen.prodi', 'rab.kategori']);

        $pdf = Pdf::loadView('dosen.penelitian.pdf', [
            'p' => $penelitian,
            'totalRab' => $this->service->totalRab($penelitian),
        ])->setPaper('a4');

        $filename = 'Proposal_Penelitian_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $penelitian->judul) . '.pdf';

        return $pdf->download($filename);
    }

    // ============================================================
    // HELPERS
    // ============================================================

    private function authorizeOwner(Request $request, Proposal $proposal): void
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $proposal->ketua_dosen_id === $dosen->id, 403);
    }

    private function validateProposal(Request $request, SkemaHibah $skema): array
    {
        $data = $request->validate([
            'judul'              => 'required|string|max:500',
            'ringkasan'          => 'nullable|string',
            'kata_kunci'         => 'nullable|string|max:300',
            'pendahuluan'        => 'nullable|string',
            'metode'             => 'nullable|string',
            'metode_diagram'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hasil_diharapkan'   => 'nullable|array',
            'jadwal_text'        => 'nullable|string',
            'daftar_pustaka'     => 'nullable|string',
            'durasi_bulan'       => 'required|integer|min:1|max:' . $skema->max_durasi_bulan,
            'pernyataan_setuju'  => 'nullable|boolean',

            // Anggota
            'anggota_dosen_id'        => 'array',
            'anggota_dosen_id.*'      => 'exists:dosen_m,id',
            'anggota_bidang_tugas'    => 'array',
            'mahasiswa_nama'          => 'array',
            'mahasiswa_nim'           => 'array',
            'mahasiswa_prodi'         => 'array',
            'mahasiswa_bidang_tugas'  => 'array',

            // RAB
            'rab_kategori_id'   => 'array',
            'rab_item'          => 'array',
            'rab_justifikasi'   => 'array',
            'rab_kuantitas'     => 'array',
            'rab_satuan'        => 'array',
            'rab_harga_satuan'  => 'array',
        ]);

        $proposal = [
            'judul'             => $data['judul'],
            'ringkasan'         => $data['ringkasan'] ?? null,
            'kata_kunci'        => $data['kata_kunci'] ?? null,
            'pendahuluan'       => $data['pendahuluan'] ?? null,
            'metode'            => $data['metode'] ?? null,
            'hasil_diharapkan_json' => $data['hasil_diharapkan'] ?? null,
            'jadwal_json'       => $data['jadwal_text'] ? ['text' => $data['jadwal_text']] : null,
            'daftar_pustaka'    => $data['daftar_pustaka'] ?? null,
            'durasi_bulan'      => $data['durasi_bulan'],
            'pernyataan_setuju' => (bool) ($data['pernyataan_setuju'] ?? false),
        ];

        if ($request->hasFile('metode_diagram')) {
            $proposal['metode_diagram_path'] = $request->file('metode_diagram')->store('proposal/diagram', 'public');
        }

        return ['proposal' => $proposal];
    }

    private function syncAnggota(Proposal $proposal, Request $request): void
    {
        $proposal->anggota()->delete();

        // Anggota dosen
        foreach ((array) $request->input('anggota_dosen_id', []) as $i => $dosenId) {
            if (! $dosenId) continue;
            ProposalAnggota::create([
                'proposal_id'   => $proposal->id,
                'dosen_id'      => $dosenId,
                'peran'         => 'anggota_dosen',
                'bidang_tugas'  => $request->input("anggota_bidang_tugas.$i"),
            ]);
        }

        // Mahasiswa
        $mhsNama = (array) $request->input('mahasiswa_nama', []);
        foreach ($mhsNama as $i => $nama) {
            if (! trim($nama ?? '')) continue;
            ProposalAnggota::create([
                'proposal_id'    => $proposal->id,
                'nama_mahasiswa' => $nama,
                'nim'            => $request->input("mahasiswa_nim.$i"),
                'program_studi'  => $request->input("mahasiswa_prodi.$i"),
                'bidang_tugas'   => $request->input("mahasiswa_bidang_tugas.$i"),
                'peran'          => 'mahasiswa',
            ]);
        }
    }

    private function syncRab(Proposal $proposal, Request $request): void
    {
        $proposal->rab()->delete();

        $items = (array) $request->input('rab_item', []);
        foreach ($items as $i => $item) {
            if (! trim($item ?? '')) continue;
            $qty = (float) $request->input("rab_kuantitas.$i", 1);
            $harga = (int) $request->input("rab_harga_satuan.$i", 0);

            ProposalRab::create([
                'proposal_id'     => $proposal->id,
                'kategori_rab_id' => (int) $request->input("rab_kategori_id.$i"),
                'item'            => $item,
                'justifikasi'     => $request->input("rab_justifikasi.$i"),
                'kuantitas'       => $qty,
                'satuan'          => $request->input("rab_satuan.$i"),
                'harga_satuan'    => $harga,
                'sub_total'       => (int) round($qty * $harga),
            ]);
        }

        $proposal->update(['total_anggaran' => $proposal->rab()->sum('sub_total')]);
    }
}
