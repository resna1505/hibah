<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Transaction\JadwalTahapan;
use App\Models\Transaction\Notifikasi;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use Illuminate\Http\Request;

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
        ));
    }
}
