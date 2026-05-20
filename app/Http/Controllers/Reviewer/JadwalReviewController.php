<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PenugasanReviewer;
use App\Models\Transaction\PeriodeHibah;
use Illuminate\Http\Request;

class JadwalReviewController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $list = PenugasanReviewer::with(['proposal.ketua', 'proposal.skemaHibah'])
            ->where('reviewer_dosen_id', $dosen->id)
            ->when($periodeAktif, fn($q) => $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id)))
            ->orderBy('deadline')
            ->paginate(15)->withQueryString();

        $today = now()->toDateString();
        $stats = [
            'total'    => PenugasanReviewer::where('reviewer_dosen_id', $dosen->id)
                ->when($periodeAktif, fn($q) => $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id)))->count(),
            'selesai'  => PenugasanReviewer::where('reviewer_dosen_id', $dosen->id)
                ->where('status', 'selesai')
                ->when($periodeAktif, fn($q) => $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id)))->count(),
            'sedang'   => PenugasanReviewer::where('reviewer_dosen_id', $dosen->id)
                ->whereIn('status', ['ditugaskan', 'sedang_review'])
                ->where('deadline', '>=', $today)
                ->when($periodeAktif, fn($q) => $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id)))->count(),
            'terlambat'=> PenugasanReviewer::where('reviewer_dosen_id', $dosen->id)
                ->whereIn('status', ['ditugaskan', 'sedang_review'])
                ->where('deadline', '<', $today)
                ->when($periodeAktif, fn($q) => $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id)))->count(),
        ];

        return view('reviewer.jadwal.index', compact('list', 'stats', 'periodeAktif', 'today'));
    }
}
