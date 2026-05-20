<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Fakultas;
use App\Models\Master\SkemaHibah;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use App\Models\Transaction\VerifikasiProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $periodeAktif = PeriodeHibah::aktif()->latest('tahun')->first();

        $query = Proposal::with(['ketua.fakultas', 'skemaHibah', 'periodeHibah'])
            ->when($periodeAktif, fn($q) => $q->where('periode_hibah_id', $periodeAktif->id))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->skema_id, fn($q, $id) => $q->where('skema_hibah_id', $id))
            ->when($request->fakultas_id, fn($q, $id) => $q->whereHas('ketua', fn($q2) => $q2->where('fakultas_id', $id)))
            ->when($request->search, fn($q, $s) => $q->where(function ($q2) use ($s) {
                $q2->where('judul', 'like', "%{$s}%")
                    ->orWhereHas('ketua', fn($q3) => $q3->where('nama_lengkap', 'like', "%{$s}%"));
            }))
            ->latest('tgl_submit');

        $list = $query->paginate(15)->withQueryString();

        $stats = [];
        if ($periodeAktif) {
            $statusCount = Proposal::where('periode_hibah_id', $periodeAktif->id)
                ->selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status');
            $stats = [
                'total'      => $statusCount->sum(),
                'submitted'  => $statusCount->get('submitted', 0),
                'verifikasi' => $statusCount->get('verifikasi', 0),
                'direview'   => $statusCount->get('direview', 0),
                'disetujui'  => $statusCount->get('disetujui', 0),
                'ditolak'    => $statusCount->get('ditolak', 0),
                'revisi'     => $statusCount->get('revisi_minor', 0) + $statusCount->get('revisi_mayor', 0),
            ];
        }

        return view('operator.proposal.index', [
            'list'         => $list,
            'periodeAktif' => $periodeAktif,
            'stats'        => $stats,
            'skemaList'    => SkemaHibah::orderBy('nama')->get(),
            'fakultasList' => Fakultas::orderBy('nama')->get(),
            'filters'      => $request->only(['status', 'skema_id', 'fakultas_id', 'search']),
        ]);
    }

    public function show(Request $request, Proposal $proposal)
    {
        $proposal->load(['skemaHibah', 'periodeHibah', 'ketua.fakultas', 'ketua.prodi',
            'anggota.dosen', 'mitra', 'rab.kategori',
            'verifikasi.operator',
            'penugasanReviewer.reviewer', 'penugasanReviewer.penilaian.detail.kriteria']);

        return view('operator.proposal.show', [
            'p'       => $proposal,
            'totalRab'=> (int) $proposal->rab->sum('sub_total'),
        ]);
    }

    public function verifikasiForm(Request $request, Proposal $proposal)
    {
        $proposal->load(['skemaHibah', 'ketua.fakultas', 'ketua.prodi', 'anggota.dosen', 'mitra', 'rab.kategori']);

        abort_unless(in_array($proposal->status, ['submitted', 'verifikasi', 'dikembalikan']),
            403, 'Status proposal tidak valid untuk diverifikasi.');

        return view('operator.proposal.verifikasi', [
            'p'        => $proposal,
            'totalRab' => (int) $proposal->rab->sum('sub_total'),
            'lastVerif'=> $proposal->verifikasi->sortByDesc('id')->first(),
        ]);
    }

    public function submitVerifikasi(Request $request, Proposal $proposal)
    {
        abort_unless(in_array($proposal->status, ['submitted', 'verifikasi', 'dikembalikan']),
            403, 'Status proposal tidak valid untuk diverifikasi.');

        $data = $request->validate([
            'keputusan' => 'required|in:lengkap,dikembalikan,ditolak',
            'catatan'   => 'required|string|max:2000',
        ]);

        DB::transaction(function () use ($data, $proposal, $request) {
            VerifikasiProposal::create([
                'proposal_id'   => $proposal->id,
                'operator_id'   => $request->user()->id,
                'status'        => $data['keputusan'],
                'catatan'       => $data['catatan'],
                'tgl_verifikasi'=> now(),
            ]);

            $newStatus = match ($data['keputusan']) {
                'lengkap'      => 'verifikasi',    // siap untuk penugasan reviewer
                'dikembalikan' => 'dikembalikan',  // kembali ke dosen untuk diperbaiki
                'ditolak'      => 'ditolak',
            };

            $proposal->update(['status' => $newStatus]);
        });

        return redirect()->route('operator.proposal.index')
            ->with('success', 'Verifikasi tersimpan. Status proposal: ' . $data['keputusan']);
    }
}
