<?php

namespace App\Http\Controllers\Dosen\Pengabdian;

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
            ->whereHas('skemaHibah', fn($q) => $q->where('jenis', 'pkm'))
            ->latest()
            ->get();

        return view('dosen.pkm.index', compact('list'));
    }

    public function create(Request $request)
    {
        $dosen = $request->user()->dosen;
        $periode = PeriodeHibah::aktif()->first();

        if (! $periode) {
            return redirect()->route('dosen.pkm.index')->with('error', 'Belum ada periode hibah aktif.');
        }
        if (! $this->service->tahapanPengajuanAktif()) {
            return redirect()->route('dosen.pkm.index')->with('error', 'Tahapan pengajuan belum dibuka atau sudah berakhir.');
        }

        // Cek syarat ketua pengusul
        $issues = $this->service->checkKetuaEligibility($dosen);
        if (! empty($issues)) {
            return redirect()->route('dosen.pkm.index')
                ->with('error', 'Belum memenuhi syarat ketua pengusul: ' . implode(' ', $issues)
                    . ' Silakan lengkapi data di menu Profil.');
        }

        // Cek kuota: maksimal 2 keterlibatan PKM per periode per dosen (ketua + anggota).
        $skema = SkemaHibah::where('jenis', 'pkm')->where('is_active', true)->first();
        $jumlahExisting = Proposal::where('periode_hibah_id', $periode->id)
            ->where('skema_hibah_id', $skema->id)
            ->where(function ($q) use ($dosen) {
                $q->where('ketua_dosen_id', $dosen->id)
                  ->orWhereHas('anggota', fn($qq) => $qq->where('peran', 'anggota_dosen')->where('dosen_id', $dosen->id));
            })
            ->count();

        if ($jumlahExisting >= 2) {
            return redirect()->route('dosen.pkm.index')
                ->with('error', 'Kuota PKM Anda sudah penuh (maks 2 keterlibatan per periode sebagai ketua atau anggota). Tunggu periode berikutnya.');
        }

        return view('dosen.pkm.form', [
            'proposal'      => null,
            'skema'         => $skema,
            'periode'       => $periode,
            'dosenList'     => Dosen::where('id', '!=', $dosen->id)->orderBy('nama_lengkap')->get(['id', 'nama_lengkap']),
            'kategoriRab'   => KategoriRab::with('komponen')->orderBy('urutan')->get(),
            'bidangList'    => BidangStrategis::where('is_active', true)->orderBy('kode')->get(),
            'jenisLuaranList' => JenisLuaran::pkm()->where('is_active', true)->orderBy('urutan')->get(),
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
        $skema = SkemaHibah::where('jenis', 'pkm')->firstOrFail();

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

        return redirect()->route('dosen.pkm.edit', $proposal)
            ->with('success', 'Draft proposal PKM dibuat. Lengkapi semua bagian sebelum submit.');
    }

    public function edit(Request $request, Proposal $pkm)
    {
        $this->authorizeOwner($request, $pkm);

        if (! in_array($pkm->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor'])) {
            return redirect()->route('dosen.pkm.show', $pkm)
                ->with('error', 'Proposal pada status ini tidak dapat diedit.');
        }

        return view('dosen.pkm.form', [
            'proposal'      => $pkm,
            'skema'         => $pkm->skemaHibah,
            'periode'       => $pkm->periodeHibah,
            'dosenList'     => Dosen::where('id', '!=', $request->user()->dosen->id)->orderBy('nama_lengkap')->get(['id', 'nama_lengkap']),
            'kategoriRab'   => KategoriRab::with('komponen')->orderBy('urutan')->get(),
            'bidangList'    => BidangStrategis::where('is_active', true)->orderBy('kode')->get(),
            'jenisLuaranList' => JenisLuaran::pkm()->where('is_active', true)->orderBy('urutan')->get(),
            'anggotaDosen'  => $pkm->anggota()->where('peran', 'anggota_dosen')->with('dosen')->get(),
            'mahasiswa'     => $pkm->anggota()->where('peran', 'mahasiswa')->get(),
            'mitraList'     => $pkm->mitra,
            'rabItems'      => $pkm->rab()->orderBy('kategori_rab_id')->get(),
            'rencanaLuaran' => $pkm->rencanaLuaran()->orderBy('tahun_ke')->orderBy('urutan')->get(),
            'dokumenList'   => $pkm->dokumen()->latest()->get(),
        ]);
    }

    public function update(Request $request, Proposal $pkm)
    {
        $this->authorizeOwner($request, $pkm);
        abort_unless(in_array($pkm->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']),
            403, 'Proposal tidak dapat diupdate.');

        $data = $this->validateProposal($request, $pkm->skemaHibah);

        DB::transaction(function () use ($pkm, $data, $request) {
            $pkm->update($data['proposal']);
            $this->syncAnggota($pkm, $request);
            $this->syncMitra($pkm, $request);
            $this->syncRab($pkm, $request);
            $this->syncRencanaLuaran($pkm, $request);
        });

        return back()->with('success', 'Perubahan disimpan.');
    }

    public function submit(Request $request, Proposal $pkm)
    {
        $this->authorizeOwner($request, $pkm);
        abort_unless(in_array($pkm->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']),
            403, 'Status tidak valid untuk submit.');

        $errors = $this->service->validateForSubmit($pkm);
        if (! empty($errors)) {
            return back()->with('error', 'Belum bisa submit: ' . implode(' ', $errors));
        }

        $pkm->update([
            'status' => 'submitted',
            'tgl_submit' => now(),
            'total_anggaran' => $this->service->totalRab($pkm),
        ]);

        $pkm->refresh()->load('skemaHibah', 'periodeHibah');
        $this->service->generateNoRegistrasi($pkm);

        $this->notif->onProposalSubmitted($pkm->fresh()->load('skemaHibah', 'ketua'));

        return redirect()->route('dosen.pkm.show', $pkm)
            ->with('success', 'Proposal PKM berhasil disubmit. Operator akan memverifikasi.');
    }

    public function destroy(Request $request, Proposal $pkm)
    {
        $this->authorizeOwner($request, $pkm);
        abort_unless($pkm->status === 'draft', 403, 'Hanya draft yang bisa dihapus.');

        $pkm->delete();
        return redirect()->route('dosen.pkm.index')->with('success', 'Draft dihapus.');
    }

    public function show(Request $request, Proposal $pkm)
    {
        $this->authorizeOwner($request, $pkm);
        $pkm->load(['skemaHibah', 'periodeHibah', 'ketua.fakultas', 'ketua.prodi',
            'anggota.dosen', 'mitra', 'rab.kategori', 'rab.komponen', 'bidangStrategis',
            'rencanaLuaran.jenisLuaran', 'dokumen']);

        return view('dosen.pkm.show', [
            'p' => $pkm,
            'totalRab' => $this->service->totalRab($pkm),
        ]);
    }

    public function uploadDokumen(Request $request, Proposal $pkm)
    {
        $this->authorizeOwner($request, $pkm);
        abort_unless(in_array($pkm->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']), 403);

        $data = $request->validate([
            'jenis' => 'required|string|max:100',
            'file'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->store('proposal/' . $pkm->id . '/dokumen', 'public');

        ProposalDokumen::create([
            'proposal_id' => $pkm->id,
            'jenis'       => $data['jenis'],
            'nama_file'   => $file->getClientOriginalName(),
            'path'        => $path,
            'ukuran'      => $file->getSize(),
        ]);

        return back()->with('success', 'Dokumen pendukung berhasil diunggah.');
    }

    public function deleteDokumen(Request $request, Proposal $pkm, ProposalDokumen $dokumen)
    {
        $this->authorizeOwner($request, $pkm);
        abort_unless($dokumen->proposal_id === $pkm->id, 404);
        abort_unless(in_array($pkm->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']), 403);

        if ($dokumen->path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dokumen->path);
        }
        $dokumen->delete();

        return back()->with('success', 'Dokumen dihapus.');
    }

    public function pdf(Request $request, Proposal $pkm)
    {
        return $this->renderPdf($request, $pkm, 'pdf', 'Proposal_PKM');
    }

    public function pdfIdentitas(Request $request, Proposal $pkm)
    {
        return $this->renderPdf($request, $pkm, 'pdf-identitas', 'Identitas_PKM');
    }

    public function pdfSubstansi(Request $request, Proposal $pkm)
    {
        return $this->renderPdf($request, $pkm, 'pdf-substansi', 'Substansi_PKM');
    }

    public function pdfBiodata(Request $request, Proposal $pkm)
    {
        return $this->renderPdf($request, $pkm, '_shared.pdf-biodata', 'Biodata_PKM', shared: true);
    }

    public function pdfPernyataan(Request $request, Proposal $pkm)
    {
        return $this->renderPdf($request, $pkm, '_shared.pdf-pernyataan', 'Pernyataan_PKM', shared: true);
    }

    private function renderPdf(Request $request, Proposal $pkm, string $view, string $prefix, bool $shared = false)
    {
        $this->authorizeOwner($request, $pkm);
        $pkm->load(['skemaHibah', 'periodeHibah',
            'ketua.fakultas', 'ketua.prodi', 'ketua.user', 'ketua.keahlian',
            'anggota.dosen.prodi', 'anggota.dosen.fakultas', 'anggota.dosen.user', 'anggota.dosen.keahlian',
            'mitra', 'rab.kategori', 'rab.komponen', 'bidangStrategis',
            'rencanaLuaran.jenisLuaran', 'dokumen']);

        $viewName = $shared ? 'dosen.' . $view : 'dosen.pkm.' . $view;

        $pdf = Pdf::loadView($viewName, [
            'p' => $pkm,
            'totalRab' => $this->service->totalRab($pkm),
        ])->setPaper('a4');

        $filename = $prefix . '_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $pkm->judul) . '.pdf';
        return $pdf->download($filename);
    }

    // ============================================================

    private function authorizeOwner(Request $request, Proposal $proposal): void
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $proposal->ketua_dosen_id === $dosen->id, 403);
    }

    private function buildJadwalJson(array $data): ?array
    {
        $keterangan = (array) ($data['jadwal_keterangan'] ?? []);
        $start = (array) ($data['jadwal_start'] ?? []);
        $end = (array) ($data['jadwal_end'] ?? []);

        $rows = [];
        foreach ($keterangan as $i => $ket) {
            $ket = trim((string) $ket);
            $s = (int) ($start[$i] ?? 0);
            $e = (int) ($end[$i] ?? 0);
            if (! $ket && ! $s && ! $e) continue;
            if ($s && $e && $s > $e) { $tmp = $s; $s = $e; $e = $tmp; }
            $rows[] = ['keterangan' => $ket, 'start' => $s ?: 1, 'end' => $e ?: 1];
        }

        if (empty($rows) && empty($data['jadwal_bulan_mulai'])) return null;
        return [
            'bulan_mulai' => $data['jadwal_bulan_mulai'] ?? null,
            'rows'        => $rows,
        ];
    }

    private function validateProposal(Request $request, SkemaHibah $skema): array
    {
        $data = $request->validate([
            'judul'              => 'required|string|max:500',
            'ringkasan'          => 'nullable|string',
            'kata_kunci'         => 'nullable|string|max:300',
            'pendahuluan'        => 'nullable|string',
            'permasalahan_solusi'=> 'nullable|string',
            'metode'             => 'nullable|string',
            'metode_diagram'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hasil_diharapkan'   => 'nullable|array',
            'jadwal_bulan_mulai' => 'nullable|date_format:Y-m',
            'jadwal_keterangan'  => 'array',
            'jadwal_keterangan.*'=> 'nullable|string|max:300',
            'jadwal_start'       => 'array',
            'jadwal_start.*'     => 'nullable|integer|min:1|max:60',
            'jadwal_end'         => 'array',
            'jadwal_end.*'       => 'nullable|integer|min:1|max:60',
            'daftar_pustaka'     => 'nullable|string',
            'durasi_bulan'       => 'required|integer|min:1|max:' . $skema->max_durasi_bulan,
            'pernyataan_setuju'  => 'nullable|boolean',

            'anggota_dosen_id'        => 'array|max:2',
            'anggota_dosen_id.*'      => 'exists:dosen_m,id',
            'anggota_bidang_tugas'    => 'array',
            'mahasiswa_nama'          => 'array|max:2',
            'mahasiswa_nim'           => 'array',
            'mahasiswa_prodi'         => 'array',
            'mahasiswa_bidang_tugas'  => 'array',

            'mitra_nama'             => 'array',
            'mitra_pimpinan'         => 'array',
            'mitra_alamat'           => 'array',
            'mitra_permasalahan'     => 'array',

            'bidang_strategis_id'      => 'nullable|exists:bidang_strategis_m,id',
            'rumusan_masalah_bidang'   => 'nullable|string',
            'uraian_bidang'            => 'nullable|string',

            'rab_kategori_id'   => 'array',
            'rab_komponen_id'   => 'array',
            'rab_item'          => 'array',
            'rab_justifikasi'   => 'array',
            'rab_kuantitas'     => 'array',
            'rab_satuan'        => 'array',
            'rab_harga_satuan'  => 'array',

            'luaran_tahun_ke'       => 'array',
            'luaran_kategori'       => 'array',
            'luaran_jenis_id'       => 'array',
            'luaran_jenis_text'     => 'array',
            'luaran_status_target'  => 'array',
            'luaran_keterangan'     => 'array',
        ], [
            'anggota_dosen_id.max' => 'Anggota dosen maksimal 2 orang.',
            'mahasiswa_nama.max'   => 'Anggota mahasiswa maksimal 2 orang.',
        ]);

        $proposal = [
            'judul'              => $data['judul'],
            'ringkasan'          => $data['ringkasan'] ?? null,
            'kata_kunci'         => $data['kata_kunci'] ?? null,
            'pendahuluan'        => $data['pendahuluan'] ?? null,
            'permasalahan_solusi'=> $data['permasalahan_solusi'] ?? null,
            'metode'             => $data['metode'] ?? null,
            'hasil_diharapkan_json' => $data['hasil_diharapkan'] ?? null,
            'jadwal_json'        => $this->buildJadwalJson($data),
            'daftar_pustaka'     => $data['daftar_pustaka'] ?? null,
            'durasi_bulan'       => $data['durasi_bulan'],
            'pernyataan_setuju'  => (bool) ($data['pernyataan_setuju'] ?? false),
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

        foreach ((array) $request->input('anggota_dosen_id', []) as $i => $dosenId) {
            if (! $dosenId) continue;
            ProposalAnggota::create([
                'proposal_id'  => $proposal->id,
                'dosen_id'     => $dosenId,
                'peran'        => 'anggota_dosen',
                'bidang_tugas' => $request->input("anggota_bidang_tugas.$i"),
            ]);
        }

        foreach ((array) $request->input('mahasiswa_nama', []) as $i => $nama) {
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

    private function syncRab(Proposal $proposal, Request $request): void
    {
        $proposal->rab()->delete();

        foreach ((array) $request->input('rab_item', []) as $i => $item) {
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
