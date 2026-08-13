<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PenugasanReviewer;
use App\Services\PenilaianService;
use Illuminate\Http\Request;

class HasilReviewController extends Controller
{
    public function __construct(private PenilaianService $service) {}

    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;

        $list = PenugasanReviewer::with(['proposal', 'proposal.skemaHibah', 'penilaian'])
            ->where('reviewer_dosen_id', $dosen->id)
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->paginate(15)->withQueryString();

        // Statistik ringkasan
        $statQuery = PenugasanReviewer::where('reviewer_dosen_id', $dosen->id)->where('status', 'selesai');
        $stats = [
            'disetujui'    => (clone $statQuery)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'disetujui'))->count(),
            'revisi_minor' => (clone $statQuery)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'revisi_minor'))->count(),
            'revisi_mayor' => (clone $statQuery)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'revisi_mayor'))->count(),
            'ditolak'      => (clone $statQuery)->whereHas('penilaian', fn($q) => $q->where('rekomendasi', 'ditolak'))->count(),
        ];
        $stats['total'] = array_sum($stats);

        return view('reviewer.hasil.index', compact('list', 'stats'));
    }

    public function show(Request $request, PenugasanReviewer $penugasan)
    {
        $dosen = $request->user()->dosen;
        abort_unless($penugasan->reviewer_dosen_id === $dosen->id, 403);

        $penugasan->load([
            'proposal.skemaHibah',
            'penilaian.detail.kriteria',
        ]);

        return view('reviewer.hasil.show', [
            'penugasan' => $penugasan,
            'kategori'  => $this->service->kategoriNilai((float) ($penugasan->penilaian?->nilai_total ?? 0)),
        ]);
    }
}
