<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Master\JenisLuaran;
use App\Models\Transaction\LaporanAkhir;
use App\Models\Transaction\LaporanKemajuan;
use App\Models\Transaction\Luaran;
use App\Models\Transaction\PeriodeLaporan;
use App\Models\Transaction\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Halaman laporan untuk 1 proposal (Penelitian atau PKM).
     */
    public function show(Request $request, Proposal $proposal)
    {
        $this->authorizeOwner($request, $proposal);
        abort_unless(in_array($proposal->status, ['disetujui', 'berjalan', 'selesai']),
            403, 'Laporan hanya tersedia setelah proposal disetujui.');

        $proposal->load(['skemaHibah', 'laporanKemajuan.periodeLaporan', 'laporanAkhir', 'luaran.jenisLuaran']);

        // Periode laporan kemajuan untuk skema ini di periode hibah aktif
        $periodeLaporan = PeriodeLaporan::where('periode_hibah_id', $proposal->periode_hibah_id)
            ->where('skema_jenis', $proposal->skemaHibah->jenis)
            ->orderBy('urutan')
            ->get();

        // Jenis luaran tersedia untuk skema ini
        $jenisLuaranList = JenisLuaran::where('skema_jenis', $proposal->skemaHibah->jenis)
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // Index laporan kemajuan by periode_laporan_id untuk lookup cepat
        $kemajuanByPeriode = $proposal->laporanKemajuan->keyBy('periode_laporan_id');
        $luaranByJenis = $proposal->luaran->keyBy('jenis_luaran_id');

        return view('dosen.laporan.show', compact(
            'proposal',
            'periodeLaporan',
            'jenisLuaranList',
            'kemajuanByPeriode',
            'luaranByJenis',
        ));
    }

    public function uploadKemajuan(Request $request, Proposal $proposal)
    {
        $this->authorizeOwner($request, $proposal);
        $this->ensureCanUpload($proposal);

        $data = $request->validate([
            'periode_laporan_id' => 'required|exists:periode_laporan_t,id',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // Pastikan periode_laporan ini cocok dengan skema jenis proposal
        $periode = PeriodeLaporan::findOrFail($data['periode_laporan_id']);
        abort_unless($periode->skema_jenis === $proposal->skemaHibah->jenis, 403, 'Periode laporan tidak sesuai skema.');

        $path = $request->file('file')->store('laporan/kemajuan', 'public');

        $existing = LaporanKemajuan::where('proposal_id', $proposal->id)
            ->where('periode_laporan_id', $periode->id)
            ->first();

        if ($existing) {
            if ($existing->file_path && Storage::disk('public')->exists($existing->file_path)) {
                Storage::disk('public')->delete($existing->file_path);
            }
            $existing->update([
                'file_path' => $path,
                'tgl_unggah' => now(),
                'status' => 'menunggu',
                'verifikator_id' => null,
                'catatan_verifikator' => null,
            ]);
        } else {
            LaporanKemajuan::create([
                'proposal_id' => $proposal->id,
                'periode_laporan_id' => $periode->id,
                'file_path' => $path,
                'status' => 'menunggu',
            ]);
        }

        return back()->with('success', "Laporan kemajuan {$periode->label} berhasil diunggah.");
    }

    public function uploadAkhir(Request $request, Proposal $proposal)
    {
        $this->authorizeOwner($request, $proposal);
        $this->ensureCanUpload($proposal);

        $request->validate(['file' => 'required|file|mimes:pdf,doc,docx|max:10240']);

        $path = $request->file('file')->store('laporan/akhir', 'public');

        $existing = LaporanAkhir::where('proposal_id', $proposal->id)->first();
        if ($existing) {
            if ($existing->file_path && Storage::disk('public')->exists($existing->file_path)) {
                Storage::disk('public')->delete($existing->file_path);
            }
            $existing->update([
                'file_path' => $path,
                'tgl_unggah' => now(),
                'status' => 'menunggu',
                'verifikator_id' => null,
                'catatan_verifikator' => null,
            ]);
        } else {
            LaporanAkhir::create([
                'proposal_id' => $proposal->id,
                'file_path' => $path,
                'status' => 'menunggu',
            ]);
        }

        return back()->with('success', 'Laporan akhir berhasil diunggah.');
    }

    public function uploadLuaran(Request $request, Proposal $proposal)
    {
        $this->authorizeOwner($request, $proposal);
        $this->ensureCanUpload($proposal);

        $data = $request->validate([
            'jenis_luaran_id' => 'required|exists:jenis_luaran_m,id',
            'file' => 'nullable|file|max:10240',
            'link_url' => 'nullable|url|max:500',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if (! $request->hasFile('file') && empty($data['link_url'])) {
            return back()->with('error', 'Sertakan file atau link luaran.');
        }

        $jenisLuaran = JenisLuaran::findOrFail($data['jenis_luaran_id']);
        abort_unless($jenisLuaran->skema_jenis === $proposal->skemaHibah->jenis, 403, 'Jenis luaran tidak sesuai skema.');

        $payload = [
            'proposal_id' => $proposal->id,
            'jenis_luaran_id' => $jenisLuaran->id,
            'link_url' => $data['link_url'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'tgl_unggah' => now(),
            'status' => 'menunggu',
            'verifikator_id' => null,
            'catatan_verifikator' => null,
        ];

        if ($request->hasFile('file')) {
            $payload['file_path'] = $request->file('file')->store('luaran', 'public');
        }

        $existing = Luaran::where('proposal_id', $proposal->id)
            ->where('jenis_luaran_id', $jenisLuaran->id)
            ->first();

        if ($existing) {
            if (isset($payload['file_path']) && $existing->file_path && Storage::disk('public')->exists($existing->file_path)) {
                Storage::disk('public')->delete($existing->file_path);
            }
            $existing->update($payload);
        } else {
            Luaran::create($payload);
        }

        return back()->with('success', "Luaran '{$jenisLuaran->nama}' berhasil diunggah.");
    }

    private function authorizeOwner(Request $request, Proposal $proposal): void
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $proposal->ketua_dosen_id === $dosen->id, 403);
    }

    private function ensureCanUpload(Proposal $proposal): void
    {
        abort_unless(in_array($proposal->status, ['disetujui', 'berjalan']),
            403, 'Laporan hanya bisa diunggah saat proposal berstatus disetujui atau berjalan.');
    }
}
