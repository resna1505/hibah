<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Transaction\LaporanAkhir;
use App\Models\Transaction\LaporanKemajuan;
use App\Models\Transaction\Luaran;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;

class VerifikasiLaporanController extends Controller
{
    public function __construct(private NotifikasiService $notif) {}

    /**
     * List proposal yang berstatus disetujui/berjalan/selesai
     * dengan ringkasan jumlah laporan menunggu verifikasi.
     */
    public function index(Request $request)
    {
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $list = Proposal::with(['ketua.fakultas', 'skemaHibah',
                'laporanKemajuan', 'laporanAkhir', 'luaran'])
            ->whereIn('status', ['disetujui', 'berjalan', 'selesai'])
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))
            ->when($request->search, fn($q, $s) => $q->where(function ($q2) use ($s) {
                $q2->where('judul', 'like', "%{$s}%")
                    ->orWhereHas('ketua', fn($q3) => $q3->where('nama_lengkap', 'like', "%{$s}%"));
            }))
            ->latest('updated_at')
            ->paginate(15)->withQueryString();

        // Stats global
        $stats = [
            'menunggu_kemajuan' => LaporanKemajuan::where('status', 'menunggu')
                ->whereHas('proposal', fn($q) => $periodeAktif ? $q->where('periode_hibah_id', $periodeAktif->id) : $q)->count(),
            'menunggu_akhir'    => LaporanAkhir::where('status', 'menunggu')
                ->whereHas('proposal', fn($q) => $periodeAktif ? $q->where('periode_hibah_id', $periodeAktif->id) : $q)->count(),
            'menunggu_luaran'   => Luaran::where('status', 'menunggu')
                ->whereHas('proposal', fn($q) => $periodeAktif ? $q->where('periode_hibah_id', $periodeAktif->id) : $q)->count(),
        ];
        $stats['total_menunggu'] = $stats['menunggu_kemajuan'] + $stats['menunggu_akhir'] + $stats['menunggu_luaran'];

        return view('operator.laporan.index', compact('list', 'periodeAktif', 'stats'));
    }

    public function show(Request $request, Proposal $proposal)
    {
        abort_unless(in_array($proposal->status, ['disetujui', 'berjalan', 'selesai']),
            403, 'Proposal harus berstatus disetujui untuk verifikasi laporan.');

        $proposal->load([
            'skemaHibah', 'periodeHibah', 'ketua.fakultas',
            'laporanKemajuan.periodeLaporan',
            'laporanKemajuan.verifikator',
            'laporanAkhir.verifikator',
            'luaran.jenisLuaran', 'luaran.verifikator',
        ]);

        return view('operator.laporan.show', [
            'p' => $proposal,
        ]);
    }

    public function verifikasiKemajuan(Request $request, LaporanKemajuan $laporan)
    {
        $data = $request->validate([
            'status'  => 'required|in:terverifikasi,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $laporan->update([
            'status'              => $data['status'],
            'catatan_verifikator' => $data['catatan'] ?? null,
            'verifikator_id'      => $request->user()->id,
        ]);

        $this->notif->onLaporanVerified($laporan->proposal->load('skemaHibah', 'ketua'), 'Kemajuan ' . $laporan->periodeLaporan?->label, $data['status']);

        return back()->with('success', "Laporan kemajuan {$laporan->periodeLaporan?->label} → {$data['status']}.");
    }

    public function verifikasiAkhir(Request $request, LaporanAkhir $laporanAkhir)
    {
        $data = $request->validate([
            'status'  => 'required|in:terverifikasi,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $laporanAkhir->update([
            'status'              => $data['status'],
            'catatan_verifikator' => $data['catatan'] ?? null,
            'verifikator_id'      => $request->user()->id,
        ]);

        // Auto-update status proposal kalau laporan akhir terverifikasi
        if ($data['status'] === 'terverifikasi') {
            $proposal = $laporanAkhir->proposal;
            if (in_array($proposal->status, ['disetujui', 'berjalan'])) {
                $proposal->update(['status' => 'selesai']);
            }
        }

        $this->notif->onLaporanVerified($laporanAkhir->proposal->load('skemaHibah', 'ketua'), 'Akhir', $data['status']);

        return back()->with('success', "Laporan akhir → {$data['status']}.");
    }

    public function verifikasiLuaran(Request $request, Luaran $luaran)
    {
        $data = $request->validate([
            'status'  => 'required|in:terverifikasi,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $luaran->update([
            'status'              => $data['status'],
            'catatan_verifikator' => $data['catatan'] ?? null,
            'verifikator_id'      => $request->user()->id,
        ]);

        $this->notif->onLaporanVerified($luaran->proposal->load('skemaHibah', 'ketua'), "Luaran ({$luaran->jenisLuaran?->nama})", $data['status']);

        return back()->with('success', "Luaran {$luaran->jenisLuaran?->nama} → {$data['status']}.");
    }
}
