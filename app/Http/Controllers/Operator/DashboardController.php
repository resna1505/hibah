<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Transaction\JadwalTahapan;
use App\Models\Transaction\Notifikasi;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = PeriodeHibah::aktif()->latest('tahun')->first();

        $stats = [
            'total' => 0,
            'disetujui' => 0,
            'revisi' => 0,
            'ditolak' => 0,
            'dalam_proses' => 0,
        ];

        $proposalTerbaru = collect();
        $jadwalTahapan = collect();
        $chartData = ['labels' => [], 'masuk' => [], 'disetujui' => [], 'revisi' => [], 'ditolak' => []];

        if ($periode) {
            $baseQuery = Proposal::where('periode_hibah_id', $periode->id);

            $stats['total'] = (clone $baseQuery)->count();
            $stats['disetujui'] = (clone $baseQuery)
                ->whereIn('status', ['disetujui', 'berjalan', 'selesai'])->count();
            $stats['revisi'] = (clone $baseQuery)
                ->whereIn('status', ['revisi_minor', 'revisi_mayor', 'dikembalikan'])->count();
            $stats['ditolak'] = (clone $baseQuery)
                ->where('status', 'ditolak')->count();
            $stats['dalam_proses'] = (clone $baseQuery)
                ->whereIn('status', ['submitted', 'verifikasi', 'direview'])->count();

            $proposalTerbaru = Proposal::with(['ketua', 'skemaHibah'])
                ->where('periode_hibah_id', $periode->id)
                ->whereNotNull('tgl_submit')
                ->latest('tgl_submit')
                ->take(5)
                ->get();

            $jadwalTahapan = JadwalTahapan::with('tahapanHibah')
                ->where('periode_hibah_id', $periode->id)
                ->get()
                ->sortBy('tahapanHibah.urutan')
                ->values();

            // Chart: count proposal per bulan (12 bulan terakhir)
            $chartData = $this->buildChartData($periode->id);
        }

        $notifikasi = Notifikasi::where('user_id', $request->user()->id)
            ->latest()
            ->take(5)
            ->get();

        return view('operator.dashboard', compact(
            'periode',
            'stats',
            'proposalTerbaru',
            'jadwalTahapan',
            'notifikasi',
            'chartData',
        ));
    }

    /**
     * Bangun data chart: count per bulan untuk 4 series (Masuk/Disetujui/Revisi/Ditolak).
     * Range: 12 bulan ke belakang dari sekarang.
     */
    private function buildChartData(int $periodeId): array
    {
        $start = now()->copy()->subMonths(11)->startOfMonth();
        $end   = now()->copy()->endOfMonth();

        $rows = Proposal::where('periode_hibah_id', $periodeId)
            ->whereNotNull('tgl_submit')
            ->whereBetween('tgl_submit', [$start, $end])
            ->selectRaw("DATE_FORMAT(tgl_submit, '%Y-%m') as ym, status, COUNT(*) as c")
            ->groupBy('ym', 'status')
            ->get();

        // Build skeleton 12 bulan
        $labels = [];
        $masuk = [];
        $disetujui = [];
        $revisi = [];
        $ditolak = [];

        $bulanShort = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $bulanShort[$month->month - 1] . ' ' . substr($month->year, -2);

            $matched = $rows->where('ym', $key);
            $masuk[]     = (int) $matched->sum('c');
            $disetujui[] = (int) $matched->whereIn('status', ['disetujui', 'berjalan', 'selesai'])->sum('c');
            $revisi[]    = (int) $matched->whereIn('status', ['revisi_minor', 'revisi_mayor', 'dikembalikan'])->sum('c');
            $ditolak[]   = (int) $matched->where('status', 'ditolak')->sum('c');
        }

        return compact('labels', 'masuk', 'disetujui', 'revisi', 'ditolak');
    }
}
