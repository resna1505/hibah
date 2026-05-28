<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Services\ProposalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Download PDF proposal — reviewer yang ditugaskan boleh akses.
     */
    public function pdf(Request $request, Proposal $proposal)
    {
        $dosen = $request->user()->dosen;
        $isAssigned = $proposal->penugasanReviewer()
            ->where('reviewer_dosen_id', $dosen->id)
            ->exists();
        abort_unless($isAssigned, 403, 'Anda bukan reviewer yang ditugaskan untuk proposal ini.');

        $proposal->load(['skemaHibah', 'periodeHibah', 'ketua.fakultas', 'ketua.prodi',
            'anggota.dosen.prodi', 'mitra', 'rab.kategori', 'rab.komponen',
            'bidangStrategis', 'rencanaLuaran.jenisLuaran', 'dokumen']);

        $view = $proposal->skemaHibah?->jenis === 'pkm' ? 'dosen.pkm.pdf' : 'dosen.penelitian.pdf';
        $jenis = $proposal->skemaHibah?->jenis === 'pkm' ? 'PKM' : 'Penelitian';
        $totalRab = (int) $proposal->rab->sum('sub_total');

        $pdf = Pdf::loadView($view, ['p' => $proposal, 'totalRab' => $totalRab])->setPaper('a4');
        $filename = "Proposal_{$jenis}_" . preg_replace('/[^A-Za-z0-9_-]/', '_', $proposal->judul) . '.pdf';
        return $pdf->download($filename);
    }

    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();
        $tab = $request->tab ?? 'ditugaskan';

        $base = Proposal::with(['ketua.fakultas', 'skemaHibah', 'penugasanReviewer' => fn($q) => $q->where('reviewer_dosen_id', $dosen->id)])
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))
            ->when($request->search, fn($q, $s) => $q->where(function ($q2) use ($s) {
                $q2->where('judul', 'like', "%{$s}%")
                    ->orWhereHas('ketua', fn($q3) => $q3->where('nama_lengkap', 'like', "%{$s}%"));
            }));

        $list = match ($tab) {
            'ditugaskan'      => (clone $base)->whereHas('penugasanReviewer', fn($q) => $q->where('reviewer_dosen_id', $dosen->id)),
            'menunggu_review' => (clone $base)->whereHas('penugasanReviewer', fn($q) => $q->where('reviewer_dosen_id', $dosen->id)
                ->whereIn('status', ['ditugaskan', 'sedang_review'])),
            'selesai_review'  => (clone $base)->whereHas('penugasanReviewer', fn($q) => $q->where('reviewer_dosen_id', $dosen->id)
                ->where('status', 'selesai')),
            'semua'           => $base,
            default           => (clone $base)->whereHas('penugasanReviewer', fn($q) => $q->where('reviewer_dosen_id', $dosen->id)),
        };

        $list = $list->latest('tgl_submit')->paginate(15)->withQueryString();

        // Count per tab
        $myAssignmentsQuery = Proposal::whereHas('penugasanReviewer', fn($q) => $q->where('reviewer_dosen_id', $dosen->id))
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id));

        $tabCounts = [
            'ditugaskan'      => (clone $myAssignmentsQuery)->count(),
            'menunggu_review' => (clone $myAssignmentsQuery)->whereHas('penugasanReviewer', fn($q) => $q->where('reviewer_dosen_id', $dosen->id)
                ->whereIn('status', ['ditugaskan', 'sedang_review']))->count(),
            'selesai_review'  => (clone $myAssignmentsQuery)->whereHas('penugasanReviewer', fn($q) => $q->where('reviewer_dosen_id', $dosen->id)
                ->where('status', 'selesai'))->count(),
            'semua'           => Proposal::when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))->count(),
        ];

        return view('reviewer.proposal.index', compact('list', 'tab', 'tabCounts', 'periodeAktif'));
    }

    public function show(Request $request, Proposal $proposal)
    {
        $dosen = $request->user()->dosen;

        // Reviewer bisa lihat semua proposal (transparansi), tapi action nilai hanya kalau ditugaskan
        $proposal->load(['skemaHibah', 'periodeHibah', 'ketua.fakultas', 'ketua.prodi',
            'anggota.dosen', 'mitra', 'rab.kategori', 'rab.komponen',
            'bidangStrategis', 'rencanaLuaran.jenisLuaran', 'dokumen',
            'penugasanReviewer' => fn($q) => $q->where('reviewer_dosen_id', $dosen->id)->with('penilaian.detail.kriteria')]);

        $myPenugasan = $proposal->penugasanReviewer->first(); // assignment khusus reviewer ini

        return view('reviewer.proposal.show', [
            'p'           => $proposal,
            'totalRab'    => (int) $proposal->rab->sum('sub_total'),
            'myPenugasan' => $myPenugasan,
        ]);
    }
}
