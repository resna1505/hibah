<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $dosen = $user->dosen;

        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $proposalSaya = collect();
        if ($dosen && $periodeAktif) {
            $proposalSaya = Proposal::with('skemaHibah')
                ->where('ketua_dosen_id', $dosen->id)
                ->where('periode_hibah_id', $periodeAktif->id)
                ->latest('tgl_submit')
                ->get();
        }

        $riwayatStats = [
            'penelitian' => $dosen?->riwayatPenelitian()->count() ?? 0,
            'pkm'        => $dosen?->riwayatPkm()->count() ?? 0,
            'hki'        => $dosen?->riwayatHki()->count() ?? 0,
        ];

        return view('dosen.dashboard', compact(
            'user',
            'dosen',
            'periodeAktif',
            'proposalSaya',
            'riwayatStats',
        ));
    }
}
