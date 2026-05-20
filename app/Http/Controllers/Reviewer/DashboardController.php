<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PenugasanReviewer;
use App\Models\Transaction\PeriodeHibah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $dosen = $user->dosen;
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();
        $today = now()->toDateString();

        $base = PenugasanReviewer::where('reviewer_dosen_id', $dosen->id)
            ->when($periodeAktif, fn($q) => $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id)));

        $stats = [
            'total'    => (clone $base)->count(),
            'harus'    => (clone $base)->whereIn('status', ['ditugaskan', 'sedang_review'])->count(),
            'selesai'  => (clone $base)->where('status', 'selesai')->count(),
            'terlambat'=> (clone $base)->whereIn('status', ['ditugaskan', 'sedang_review'])->where('deadline', '<', $today)->count(),
        ];

        $proposalHarusReview = PenugasanReviewer::with(['proposal.ketua'])
            ->where('reviewer_dosen_id', $dosen->id)
            ->whereIn('status', ['ditugaskan', 'sedang_review'])
            ->orderBy('deadline')
            ->take(6)
            ->get();

        return view('reviewer.dashboard', compact(
            'user', 'dosen', 'periodeAktif', 'stats', 'proposalHarusReview', 'today',
        ));
    }
}
