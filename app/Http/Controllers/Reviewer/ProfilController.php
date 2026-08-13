<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PenugasanReviewer;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $dosen = $user->dosen->load('fakultas', 'prodi', 'keahlian');

        $base = PenugasanReviewer::where('reviewer_dosen_id', $dosen->id)->where('status', 'selesai');

        $totalReview = (clone $base)->count();
        $stats = [
            'total'        => $totalReview,
            'disetujui'    => (clone $base)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'disetujui'))->count(),
            'revisi_minor' => (clone $base)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'revisi_minor'))->count(),
            'revisi_mayor' => (clone $base)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'revisi_mayor'))->count(),
            'ditolak'      => (clone $base)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'ditolak'))->count(),
        ];
        $stats['revisi'] = $stats['revisi_minor'] + $stats['revisi_mayor'];

        $stats['persen_disetujui'] = $totalReview > 0 ? round($stats['disetujui'] / $totalReview * 100, 2) : 0;
        $stats['persen_revisi']    = $totalReview > 0 ? round($stats['revisi'] / $totalReview * 100, 2) : 0;
        $stats['persen_ditolak']   = $totalReview > 0 ? round($stats['ditolak'] / $totalReview * 100, 2) : 0;

        $riwayatReview = PenugasanReviewer::with(['proposal', 'proposal.skemaHibah', 'penilaian'])
            ->where('reviewer_dosen_id', $dosen->id)
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->take(10)
            ->get();

        return view('reviewer.profil.show', compact('user', 'dosen', 'stats', 'riwayatReview'));
    }
}
