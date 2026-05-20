<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PenugasanReviewer;
use App\Services\NotifikasiService;
use App\Services\PenilaianService;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function __construct(private PenilaianService $service, private NotifikasiService $notif) {}

    /**
     * Form penilaian: prefilled kalau sudah pernah disubmit (boleh revisi sebelum selesai).
     */
    public function form(Request $request, PenugasanReviewer $penugasan)
    {
        $this->authorizeReviewer($request, $penugasan);

        $penugasan->load([
            'proposal.skemaHibah.kriteriaPenilaian',
            'proposal.ketua.fakultas',
            'proposal.anggota.dosen',
            'proposal.mitra',
            'proposal.rab.kategori',
            'penilaian.detail',
        ]);

        $existingDetail = $penugasan->penilaian?->detail->keyBy('kriteria_id') ?? collect();

        // Set status sedang_review kalau masih ditugaskan
        if ($penugasan->status === 'ditugaskan') {
            $penugasan->update(['status' => 'sedang_review']);
        }

        return view('reviewer.penilaian.form', [
            'penugasan'      => $penugasan,
            'proposal'       => $penugasan->proposal,
            'kriteriaList'   => $penugasan->proposal->skemaHibah->kriteriaPenilaian()->orderBy('urutan')->get(),
            'existingDetail' => $existingDetail,
            'totalRab'       => (int) $penugasan->proposal->rab->sum('sub_total'),
        ]);
    }

    public function submit(Request $request, PenugasanReviewer $penugasan)
    {
        $this->authorizeReviewer($request, $penugasan);

        $data = $request->validate([
            'skor'              => 'required|array',
            'skor.*'            => 'required|integer|min:1|max:5',
            'catatan_kriteria'  => 'array',
            'catatan_kriteria.*'=> 'nullable|string|max:500',
            'rekomendasi'       => 'required|in:disetujui,revisi_minor,revisi_mayor,ditolak',
            'catatan_umum'      => 'required|string|max:500',
        ], [
            'skor.required'        => 'Semua kriteria wajib diberi skor.',
            'skor.*.required'      => 'Skor wajib diisi.',
            'skor.*.integer'       => 'Skor harus angka 1-5.',
            'skor.*.min'           => 'Skor minimal 1.',
            'skor.*.max'           => 'Skor maksimal 5.',
            'rekomendasi.required' => 'Rekomendasi wajib dipilih.',
            'catatan_umum.required'=> 'Catatan untuk peneliti wajib diisi.',
        ]);

        // Validasi kriteria_id valid untuk skema proposal
        $validKriteriaIds = $penugasan->proposal->skemaHibah->kriteriaPenilaian()->pluck('id')->all();
        foreach (array_keys($data['skor']) as $kid) {
            if (! in_array($kid, $validKriteriaIds)) {
                return back()->withErrors(['skor' => 'Kriteria tidak valid.']);
            }
        }
        // Pastikan semua kriteria diberi nilai
        if (count($data['skor']) !== count($validKriteriaIds)) {
            return back()->withErrors(['skor' => 'Semua kriteria penilaian harus diberi skor.']);
        }

        $rows = [];
        foreach ($data['skor'] as $kid => $skor) {
            $rows[] = [
                'kriteria_id' => $kid,
                'skor'        => $skor,
                'catatan'     => $data['catatan_kriteria'][$kid] ?? null,
            ];
        }

        $penilaian = $this->service->simpan($penugasan, $rows, $data['rekomendasi'], $data['catatan_umum']);

        $penugasan->load('proposal.skemaHibah', 'proposal.ketua', 'reviewer');
        $this->notif->onPenilaianSubmitted($penugasan->proposal, $penugasan->reviewer, (float) $penilaian->nilai_total);

        return redirect()->route('reviewer.hasil.index')
            ->with('success', 'Penilaian berhasil disimpan. Nilai akhir: ' . number_format($penilaian->nilai_total, 2));
    }

    private function authorizeReviewer(Request $request, PenugasanReviewer $penugasan): void
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $penugasan->reviewer_dosen_id === $dosen->id, 403,
            'Anda bukan reviewer yang ditugaskan untuk proposal ini.');
    }
}
