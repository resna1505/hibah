<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Fakultas;
use App\Models\Master\SkemaHibah;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Services\PenilaianService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapController extends Controller
{
    public function __construct(private PenilaianService $service) {}

    /**
     * Rekap Proposal: total per fakultas × status.
     */
    public function proposal(Request $request)
    {
        $tahun = (int) ($request->tahun ?? PeriodeHibah::aktif()->latest('tahun')->value('tahun'));
        $skemaId = $request->skema_id;

        $periode = PeriodeHibah::where('tahun', $tahun)->first();

        $data = $this->aggregateProposal($periode?->id, $skemaId);

        return view('operator.rekap.proposal', [
            'rows'       => $data['rows'],
            'totals'     => $data['totals'],
            'tahun'      => $tahun,
            'periode'    => $periode,
            'skemaId'    => $skemaId,
            'tahunList'  => PeriodeHibah::orderByDesc('tahun')->pluck('tahun')->all(),
            'skemaList'  => SkemaHibah::orderBy('nama')->get(),
        ]);
    }

    /**
     * Rekap Hasil Review: list proposal + nilai per reviewer + nilai akhir + kategori.
     */
    public function hasilReview(Request $request)
    {
        $tahun = (int) ($request->tahun ?? PeriodeHibah::aktif()->latest('tahun')->value('tahun'));
        $skemaId = $request->skema_id;

        $periode = PeriodeHibah::where('tahun', $tahun)->first();

        $rows = $this->aggregateHasilReview($periode?->id, $skemaId);

        $stats = $this->statsHasilReview($rows);

        return view('operator.rekap.hasil-review', [
            'rows'      => $rows,
            'stats'     => $stats,
            'tahun'     => $tahun,
            'periode'   => $periode,
            'skemaId'   => $skemaId,
            'tahunList' => PeriodeHibah::orderByDesc('tahun')->pluck('tahun')->all(),
            'skemaList' => SkemaHibah::orderBy('nama')->get(),
        ]);
    }

    /**
     * Export PDF Rekap Proposal.
     */
    public function exportProposalPdf(Request $request)
    {
        $tahun = (int) ($request->tahun ?? PeriodeHibah::aktif()->latest('tahun')->value('tahun'));
        $skemaId = $request->skema_id;
        $periode = PeriodeHibah::where('tahun', $tahun)->first();
        $data = $this->aggregateProposal($periode?->id, $skemaId);

        $pdf = Pdf::loadView('operator.rekap.pdf.proposal', [
            'rows'    => $data['rows'],
            'totals'  => $data['totals'],
            'tahun'   => $tahun,
            'periode' => $periode,
            'skema'   => $skemaId ? SkemaHibah::find($skemaId) : null,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("Rekap_Proposal_{$tahun}.pdf");
    }

    /**
     * Export CSV Rekap Proposal.
     */
    public function exportProposalCsv(Request $request)
    {
        $tahun = (int) ($request->tahun ?? PeriodeHibah::aktif()->latest('tahun')->value('tahun'));
        $skemaId = $request->skema_id;
        $periode = PeriodeHibah::where('tahun', $tahun)->first();
        $data = $this->aggregateProposal($periode?->id, $skemaId);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=Rekap_Proposal_{$tahun}.csv",
        ];

        return new StreamedResponse(function () use ($data) {
            $out = fopen('php://output', 'w');
            // BOM untuk Excel detect UTF-8
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, escape: '', fields: ['No', 'Fakultas', 'Total Proposal', 'Disetujui', 'Revisi', 'Ditolak', 'Persentase Disetujui (%)']);
            foreach ($data['rows'] as $i => $r) {
                fputcsv($out, escape: '', fields: [
                    $i + 1,
                    $r['nama'],
                    $r['total'],
                    $r['disetujui'],
                    $r['revisi'],
                    $r['ditolak'],
                    $r['persen_disetujui'],
                ]);
            }
            $t = $data['totals'];
            fputcsv($out, escape: '', fields: ['', 'TOTAL', $t['total'], $t['disetujui'], $t['revisi'], $t['ditolak'], $t['persen_disetujui']]);
            fclose($out);
        }, 200, $headers);
    }

    public function exportHasilReviewPdf(Request $request)
    {
        $tahun = (int) ($request->tahun ?? PeriodeHibah::aktif()->latest('tahun')->value('tahun'));
        $skemaId = $request->skema_id;
        $periode = PeriodeHibah::where('tahun', $tahun)->first();
        $rows = $this->aggregateHasilReview($periode?->id, $skemaId);
        $stats = $this->statsHasilReview($rows);

        $pdf = Pdf::loadView('operator.rekap.pdf.hasil-review', [
            'rows'    => $rows,
            'stats'   => $stats,
            'tahun'   => $tahun,
            'periode' => $periode,
            'skema'   => $skemaId ? SkemaHibah::find($skemaId) : null,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("Rekap_Hasil_Review_{$tahun}.pdf");
    }

    public function exportHasilReviewCsv(Request $request)
    {
        $tahun = (int) ($request->tahun ?? PeriodeHibah::aktif()->latest('tahun')->value('tahun'));
        $skemaId = $request->skema_id;
        $periode = PeriodeHibah::where('tahun', $tahun)->first();
        $rows = $this->aggregateHasilReview($periode?->id, $skemaId);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=Rekap_Hasil_Review_{$tahun}.csv",
        ];

        return new StreamedResponse(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, escape: '', fields: ['No', 'Judul', 'Ketua', 'Fakultas', 'Skema', 'Nilai Reviewer 1', 'Nilai Reviewer 2', 'Rata-rata', 'Kategori', 'Status']);
            foreach ($rows as $i => $r) {
                fputcsv($out, escape: '', fields: [
                    $i + 1,
                    $r['judul'],
                    $r['ketua'],
                    $r['fakultas'],
                    $r['skema'],
                    $r['nilai_r1'] ?? '-',
                    $r['nilai_r2'] ?? '-',
                    $r['rata_rata'] !== null ? number_format($r['rata_rata'], 2) : '-',
                    $r['kategori'],
                    $r['status'],
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    // ============================================================
    // HELPERS
    // ============================================================

    private function aggregateProposal(?int $periodeId, ?int $skemaId): array
    {
        $rows = [];
        $totals = ['total' => 0, 'disetujui' => 0, 'revisi' => 0, 'ditolak' => 0, 'persen_disetujui' => 0];

        $fakultasList = Fakultas::orderBy('nama')->get();
        foreach ($fakultasList as $f) {
            $base = Proposal::whereHas('ketua', fn($q) => $q->where('fakultas_id', $f->id))
                ->when($periodeId, fn($q) => $q->where('periode_hibah_id', $periodeId))
                ->when($skemaId, fn($q, $sid) => $q->where('skema_hibah_id', $sid));

            $total = (clone $base)->count();
            if ($total === 0) continue;

            $disetujui = (clone $base)->whereIn('status', ['disetujui', 'berjalan', 'selesai'])->count();
            $revisi    = (clone $base)->whereIn('status', ['revisi_minor', 'revisi_mayor', 'dikembalikan'])->count();
            $ditolak   = (clone $base)->where('status', 'ditolak')->count();
            $persen    = $total > 0 ? round($disetujui / $total * 100, 2) : 0;

            $rows[] = [
                'fakultas_id' => $f->id, 'kode' => $f->kode, 'nama' => $f->nama,
                'total' => $total, 'disetujui' => $disetujui, 'revisi' => $revisi, 'ditolak' => $ditolak,
                'persen_disetujui' => $persen,
            ];

            $totals['total']     += $total;
            $totals['disetujui'] += $disetujui;
            $totals['revisi']    += $revisi;
            $totals['ditolak']   += $ditolak;
        }
        $totals['persen_disetujui'] = $totals['total'] > 0
            ? round($totals['disetujui'] / $totals['total'] * 100, 2) : 0;

        return compact('rows', 'totals');
    }

    private function aggregateHasilReview(?int $periodeId, ?int $skemaId): array
    {
        $proposals = Proposal::with(['ketua.fakultas', 'skemaHibah', 'penugasanReviewer.penilaian'])
            ->when($periodeId, fn($q) => $q->where('periode_hibah_id', $periodeId))
            ->when($skemaId, fn($q, $sid) => $q->where('skema_hibah_id', $sid))
            ->whereHas('penugasanReviewer.penilaian')
            ->latest('tgl_submit')
            ->get();

        $rows = [];
        foreach ($proposals as $p) {
            $penilaian = $p->penugasanReviewer
                ->sortBy('peran')
                ->map(fn($pr) => $pr->penilaian)
                ->filter()
                ->values();

            $nilaiR1 = $penilaian[0]->nilai_total ?? null;
            $nilaiR2 = $penilaian[1]->nilai_total ?? null;
            $nilaiRata = $penilaian->count() > 0 ? round($penilaian->avg('nilai_total'), 2) : null;

            $rows[] = [
                'id'         => $p->id,
                'judul'      => $p->judul,
                'ketua'      => $p->ketua?->nama_lengkap,
                'fakultas'   => $p->ketua?->fakultas?->kode ?? '-',
                'skema'      => $p->skemaHibah?->nama,
                'nilai_r1'   => $nilaiR1 !== null ? number_format($nilaiR1, 2) : null,
                'nilai_r2'   => $nilaiR2 !== null ? number_format($nilaiR2, 2) : null,
                'rata_rata'  => $nilaiRata,
                'kategori'   => $nilaiRata !== null ? $this->service->kategoriNilai($nilaiRata) : '-',
                'status'     => $p->status,
            ];
        }

        return $rows;
    }

    private function statsHasilReview(array $rows): array
    {
        $nilaiList = array_filter(array_column($rows, 'rata_rata'));
        return [
            'total'      => count($rows),
            'rata_rata'  => count($nilaiList) > 0 ? round(array_sum($nilaiList) / count($nilaiList), 2) : 0,
            'tertinggi'  => count($nilaiList) > 0 ? max($nilaiList) : 0,
            'terendah'   => count($nilaiList) > 0 ? min($nilaiList) : 0,
        ];
    }
}
