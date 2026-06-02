<?php

namespace App\Http\Controllers\Dosen\Penelitian;

use App\Http\Controllers\Controller;
use App\Models\Master\BidangStrategis;
use App\Models\Master\Dosen;
use App\Models\Master\JenisLuaran;
use App\Models\Master\KategoriRab;
use App\Models\Master\KomponenRab;
use App\Models\Master\SkemaHibah;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Models\Transaction\ProposalAnggota;
use App\Models\Transaction\ProposalDokumen;
use App\Models\Transaction\ProposalMitra;
use App\Models\Transaction\ProposalRab;
use App\Models\Transaction\RencanaLuaran;
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

        // Cek kuota: maksimal 2 keterlibatan Penelitian per periode per dosen (ketua + anggota).
        $skemaPenelitian = SkemaHibah::where('jenis', 'penelitian')->where('is_active', true)->first();
        $jumlahExisting = Proposal::where('periode_hibah_id', $periode->id)
            ->where('skema_hibah_id', $skemaPenelitian->id)
            ->where(function ($q) use ($dosen) {
                $q->where('ketua_dosen_id', $dosen->id)
                  ->orWhereHas('anggota', fn($qq) => $qq->where('peran', 'anggota_dosen')->where('dosen_id', $dosen->id));
            })
            ->count();

        if ($jumlahExisting >= 2) {
            return redirect()->route('dosen.penelitian.index')
                ->with('error', 'Kuota Penelitian Anda sudah penuh (maks 2 keterlibatan per periode sebagai ketua atau anggota). Tunggu periode berikutnya.');
        }

        return view('dosen.penelitian.form', [
            'proposal'      => null,
            'skema'         => $skemaPenelitian,
            'periode'       => $periode,
            'dosenList'     => Dosen::where('id', '!=', $dosen->id)->orderBy('nama_lengkap')->get(['id', 'nama_lengkap']),
            'kategoriRab'   => KategoriRab::with('komponen')->orderBy('urutan')->get(),
            'bidangList'    => BidangStrategis::where('is_active', true)->orderBy('kode')->get(),
            'jenisLuaranList' => JenisLuaran::penelitian()->where('is_active', true)->orderBy('urutan')->get(),
            'anggotaDosen'  => collect(),
            'mahasiswa'     => collect(),
            'mitraList'     => collect(),
            'rabItems'      => collect(),
            'rencanaLuaran' => collect(),
            'dokumenList'   => collect(),
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
            $this->syncMitra($proposal, $request);
            $this->syncRab($proposal, $request);
            $this->syncRencanaLuaran($proposal, $request);

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
            'kategoriRab'   => KategoriRab::with('komponen')->orderBy('urutan')->get(),
            'bidangList'    => BidangStrategis::where('is_active', true)->orderBy('kode')->get(),
            'jenisLuaranList' => JenisLuaran::penelitian()->where('is_active', true)->orderBy('urutan')->get(),
            'anggotaDosen'  => $penelitian->anggota()->where('peran', 'anggota_dosen')->with('dosen')->get(),
            'mahasiswa'     => $penelitian->anggota()->where('peran', 'mahasiswa')->get(),
            'mitraList'     => $penelitian->mitra,
            'rabItems'      => $penelitian->rab()->orderBy('kategori_rab_id')->get(),
            'rencanaLuaran' => $penelitian->rencanaLuaran()->orderBy('tahun_ke')->orderBy('urutan')->get(),
            'dokumenList'   => $penelitian->dokumen()->latest()->get(),
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
            $this->syncMitra($penelitian, $request);
            $this->syncRab($penelitian, $request);
            $this->syncRencanaLuaran($penelitian, $request);
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

        $penelitian->refresh()->load('skemaHibah', 'periodeHibah');
        $this->service->generateNoRegistrasi($penelitian);

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
            'anggota.dosen', 'mitra', 'rab.kategori', 'rab.komponen', 'bidangStrategis',
            'rencanaLuaran.jenisLuaran', 'dokumen']);

        return view('dosen.penelitian.show', [
            'p' => $penelitian,
            'totalRab' => $this->service->totalRab($penelitian),
            'service' => $this->service,
        ]);
    }

    public function uploadDokumen(Request $request, Proposal $penelitian)
    {
        $this->authorizeOwner($request, $penelitian);
        abort_unless(in_array($penelitian->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']), 403);

        $data = $request->validate([
            'jenis' => 'required|string|max:100',
            'file'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->store('proposal/' . $penelitian->id . '/dokumen', 'public');

        ProposalDokumen::create([
            'proposal_id' => $penelitian->id,
            'jenis'       => $data['jenis'],
            'nama_file'   => $file->getClientOriginalName(),
            'path'        => $path,
            'ukuran'      => $file->getSize(),
        ]);

        return back()->with('success', 'Dokumen pendukung berhasil diunggah.');
    }

    public function deleteDokumen(Request $request, Proposal $penelitian, ProposalDokumen $dokumen)
    {
        $this->authorizeOwner($request, $penelitian);
        abort_unless($dokumen->proposal_id === $penelitian->id, 404);
        abort_unless(in_array($penelitian->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']), 403);

        if ($dokumen->path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dokumen->path);
        }
        $dokumen->delete();

        return back()->with('success', 'Dokumen dihapus.');
    }

    public function pdf(Request $request, Proposal $penelitian)
    {
        return $this->renderPdf($request, $penelitian, 'pdf', 'Proposal_Penelitian');
    }

    public function pdfIdentitas(Request $request, Proposal $penelitian)
    {
        return $this->renderPdf($request, $penelitian, 'pdf-identitas', 'Identitas_Penelitian');
    }

    public function pdfSubstansi(Request $request, Proposal $penelitian)
    {
        return $this->renderPdf($request, $penelitian, 'pdf-substansi', 'Substansi_Penelitian');
    }

    public function pdfBiodata(Request $request, Proposal $penelitian)
    {
        return $this->renderPdf($request, $penelitian, '_shared.pdf-biodata', 'Biodata_Penelitian', shared: true);
    }

    public function pdfPernyataan(Request $request, Proposal $penelitian)
    {
        return $this->renderPdf($request, $penelitian, '_shared.pdf-pernyataan', 'Pernyataan_Penelitian', shared: true);
    }

    private function renderPdf(Request $request, Proposal $penelitian, string $view, string $prefix, bool $shared = false)
    {
        $this->authorizeOwner($request, $penelitian);

        $penelitian->load(['skemaHibah', 'periodeHibah',
            'ketua.fakultas', 'ketua.prodi', 'ketua.user', 'ketua.keahlian',
            'anggota.dosen.prodi', 'anggota.dosen.fakultas', 'anggota.dosen.user', 'anggota.dosen.keahlian',
            'mitra', 'rab.kategori', 'rab.komponen', 'bidangStrategis',
            'rencanaLuaran.jenisLuaran', 'dokumen']);

        $viewName = $shared ? 'dosen.' . $view : 'dosen.penelitian.' . $view;

        $pdf = Pdf::loadView($viewName, [
            'p' => $penelitian,
            'totalRab' => $this->service->totalRab($penelitian),
        ])->setPaper('a4');

        $filename = $prefix . '_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $penelitian->judul) . '.pdf';

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

            // Bidang Strategis
            'bidang_strategis_id'      => 'nullable|exists:bidang_strategis_m,id',
            'rumusan_masalah_bidang'   => 'nullable|string',
            'uraian_bidang'            => 'nullable|string',

            // Anggota
            'anggota_dosen_id'        => 'array',
            'anggota_dosen_id.*'      => 'exists:dosen_m,id',
            'anggota_bidang_tugas'    => 'array',
            'mahasiswa_nama'          => 'array',
            'mahasiswa_nim'           => 'array',
            'mahasiswa_prodi'         => 'array',
            'mahasiswa_bidang_tugas'  => 'array',

            // Mitra (opsional untuk Penelitian)
            'mitra_nama'              => 'array',
            'mitra_pimpinan'          => 'array',
            'mitra_alamat'            => 'array',
            'mitra_permasalahan'      => 'array',

            // RAB
            'rab_kategori_id'   => 'array',
            'rab_komponen_id'   => 'array',
            'rab_item'          => 'array',
            'rab_justifikasi'   => 'array',
            'rab_kuantitas'     => 'array',
            'rab_satuan'        => 'array',
            'rab_harga_satuan'  => 'array',

            // Rencana Luaran (5 kolom)
            'luaran_tahun_ke'       => 'array',
            'luaran_kategori'       => 'array',
            'luaran_jenis_id'       => 'array',
            'luaran_jenis_text'     => 'array',
            'luaran_status_target'  => 'array',
            'luaran_keterangan'     => 'array',
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
            'bidang_strategis_id'    => $data['bidang_strategis_id'] ?? null,
            'rumusan_masalah_bidang' => $data['rumusan_masalah_bidang'] ?? null,
            'uraian_bidang'          => $data['uraian_bidang'] ?? null,
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
                'komponen_rab_id' => $request->input("rab_komponen_id.$i") ?: null,
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

    private function syncMitra(Proposal $proposal, Request $request): void
    {
        $proposal->mitra()->delete();

        foreach ((array) $request->input('mitra_nama', []) as $i => $nama) {
            if (! trim($nama ?? '')) continue;
            ProposalMitra::create([
                'proposal_id'        => $proposal->id,
                'nama_mitra'         => $nama,
                'pimpinan_mitra'     => $request->input("mitra_pimpinan.$i"),
                'alamat_mitra'       => $request->input("mitra_alamat.$i"),
                'permasalahan_mitra' => $request->input("mitra_permasalahan.$i"),
            ]);
        }
    }

    private function syncRencanaLuaran(Proposal $proposal, Request $request): void
    {
        $proposal->rencanaLuaran()->delete();

        $tahunArr = (array) $request->input('luaran_tahun_ke', []);
        foreach ($tahunArr as $i => $tahun) {
            $jenisId = $request->input("luaran_jenis_id.$i");
            $jenisText = $request->input("luaran_jenis_text.$i");
            $statusTarget = $request->input("luaran_status_target.$i");
            $keterangan = $request->input("luaran_keterangan.$i");

            if (! $jenisId && ! trim((string) $jenisText) && ! trim((string) $statusTarget) && ! trim((string) $keterangan)) {
                continue;
            }

            RencanaLuaran::create([
                'proposal_id'        => $proposal->id,
                'tahun_ke'           => (int) ($tahun ?: 1),
                'kategori'           => $request->input("luaran_kategori.$i", 'wajib'),
                'jenis_luaran_id'    => $jenisId ?: null,
                'jenis_luaran_text'  => $jenisText ?: null,
                'status_target'      => $statusTarget ?: null,
                'keterangan'         => $keterangan ?: null,
                'urutan'             => $i,
            ]);
        }
    }
}
