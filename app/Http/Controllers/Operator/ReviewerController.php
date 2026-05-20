<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Dosen;
use App\Models\Master\Fakultas;
use App\Models\Transaction\PenugasanReviewer;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewerController extends Controller
{
    /**
     * Data Reviewer — list dosen, toggle flag is_reviewer.
     */
    public function dataIndex(Request $request)
    {
        $list = Dosen::with('fakultas', 'keahlian')
            ->when($request->search, fn($q, $s) => $q->where('nama_lengkap', 'like', "%{$s}%"))
            ->when($request->fakultas_id, fn($q, $id) => $q->where('fakultas_id', $id))
            ->when($request->filter === 'reviewer', fn($q) => $q->where('is_reviewer', true))
            ->when($request->filter === 'nonreviewer', fn($q) => $q->where('is_reviewer', false))
            ->orderBy('nama_lengkap')
            ->paginate(20)->withQueryString();

        return view('operator.reviewer.data', [
            'list'         => $list,
            'fakultasList' => Fakultas::orderBy('nama')->get(),
            'filters'      => $request->only(['search', 'fakultas_id', 'filter']),
        ]);
    }

    public function toggleReviewer(Request $request, Dosen $dosen)
    {
        $dosen->update(['is_reviewer' => ! $dosen->is_reviewer]);

        $msg = $dosen->is_reviewer
            ? "{$dosen->nama_lengkap} sekarang aktif sebagai Reviewer."
            : "{$dosen->nama_lengkap} dinonaktifkan sebagai Reviewer.";

        return back()->with('success', $msg);
    }

    /**
     * Penugasan Reviewer — list proposal yang sudah diverifikasi lengkap, belum ditugaskan 2 reviewer.
     */
    public function penugasanIndex(Request $request)
    {
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $list = Proposal::with(['ketua.fakultas', 'skemaHibah', 'penugasanReviewer.reviewer'])
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))
            ->whereIn('status', ['verifikasi', 'direview'])
            ->when($request->search, fn($q, $s) => $q->where('judul', 'like', "%{$s}%"))
            ->latest('tgl_submit')
            ->paginate(15)->withQueryString();

        return view('operator.reviewer.penugasan', [
            'list'         => $list,
            'periodeAktif' => $periodeAktif,
            'filters'      => $request->only(['search']),
        ]);
    }

    public function assignForm(Request $request, Proposal $proposal)
    {
        abort_unless(in_array($proposal->status, ['verifikasi', 'direview']),
            403, 'Status proposal tidak valid untuk penugasan reviewer.');

        $proposal->load('ketua', 'skemaHibah', 'penugasanReviewer.reviewer.keahlian');

        // Reviewer eligible: dosen is_reviewer=true, bukan ketua proposal, bukan anggota proposal
        $excludeIds = [$proposal->ketua_dosen_id];
        $excludeIds = array_merge($excludeIds, $proposal->anggota->pluck('dosen_id')->filter()->all());

        $reviewerTersedia = Dosen::with('fakultas', 'prodi', 'keahlian')
            ->where('is_reviewer', true)
            ->where('status_aktif_mengajar', true)
            ->whereNotIn('id', $excludeIds)
            ->orderBy('nama_lengkap')
            ->get();

        return view('operator.reviewer.assign', [
            'p'                => $proposal,
            'reviewerTersedia' => $reviewerTersedia,
            'currentAssignments' => $proposal->penugasanReviewer->keyBy('peran'),
        ]);
    }

    public function assignSubmit(Request $request, Proposal $proposal)
    {
        abort_unless(in_array($proposal->status, ['verifikasi', 'direview']),
            403, 'Status proposal tidak valid.');

        $data = $request->validate([
            'reviewer_1_id' => 'required|exists:dosen_m,id|different:reviewer_2_id',
            'reviewer_2_id' => 'required|exists:dosen_m,id|different:reviewer_1_id',
            'deadline'      => 'required|date|after:today',
        ]);

        // Pastikan reviewer bukan ketua/anggota
        $excludeIds = array_merge(
            [$proposal->ketua_dosen_id],
            $proposal->anggota->pluck('dosen_id')->filter()->all()
        );
        foreach (['reviewer_1_id', 'reviewer_2_id'] as $key) {
            if (in_array($data[$key], $excludeIds)) {
                return back()->withErrors([$key => 'Reviewer tidak boleh ketua/anggota proposal itu sendiri.']);
            }
        }

        DB::transaction(function () use ($data, $proposal, $request) {
            // Reset assignment lama
            $proposal->penugasanReviewer()->delete();

            PenugasanReviewer::create([
                'proposal_id'       => $proposal->id,
                'reviewer_dosen_id' => $data['reviewer_1_id'],
                'peran'             => 'reviewer_1',
                'deadline'          => $data['deadline'],
                'status'            => 'ditugaskan',
                'ditugaskan_oleh'   => $request->user()->id,
            ]);
            PenugasanReviewer::create([
                'proposal_id'       => $proposal->id,
                'reviewer_dosen_id' => $data['reviewer_2_id'],
                'peran'             => 'reviewer_2',
                'deadline'          => $data['deadline'],
                'status'            => 'ditugaskan',
                'ditugaskan_oleh'   => $request->user()->id,
            ]);

            $proposal->update(['status' => 'direview']);
        });

        return redirect()->route('operator.reviewer.penugasan')
            ->with('success', 'Reviewer berhasil ditugaskan. Status proposal: direview.');
    }

    /**
     * Monitoring Reviewer — list reviewer + statistik jumlah penugasan + progress.
     */
    public function monitoringIndex(Request $request)
    {
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $reviewers = Dosen::with('fakultas')
            ->where('is_reviewer', true)
            ->withCount([
                'penugasanReview as total_tugas' => fn($q) => $periodeAktif
                    ? $q->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))
                    : $q,
                'penugasanReview as selesai' => fn($q) => $q->where('status', 'selesai')->when(
                    $periodeAktif, fn($qq) => $qq->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))),
                'penugasanReview as sedang' => fn($q) => $q->where('status', 'sedang_review')->when(
                    $periodeAktif, fn($qq) => $qq->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))),
                'penugasanReview as belum' => fn($q) => $q->where('status', 'ditugaskan')->when(
                    $periodeAktif, fn($qq) => $qq->whereHas('proposal', fn($q2) => $q2->where('periode_hibah_id', $periodeAktif->id))),
            ])
            ->orderBy('nama_lengkap')
            ->paginate(20);

        return view('operator.reviewer.monitoring', [
            'list'         => $reviewers,
            'periodeAktif' => $periodeAktif,
        ]);
    }
}
