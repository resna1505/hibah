@extends('layouts.reviewer')

@section('title', 'Dashboard Reviewer')

@php $activeNav = 'dashboard'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Dashboard Reviewer</h4>
            <p class="text-muted small mb-0">Halo, {{ $dosen?->nama_lengkap }}{{ $periodeAktif ? ' — ' . $periodeAktif->nama : '' }}</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-primary-subtle rounded-3 p-3 me-3"><i class="ri-file-text-line fs-3 text-primary"></i></div>
                <div><p class="text-muted small mb-0">Total Tugas</p><h3 class="mb-0">{{ $stats['total'] }}</h3></div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-warning-subtle rounded-3 p-3 me-3"><i class="ri-time-line fs-3 text-warning"></i></div>
                <div><p class="text-muted small mb-0">Harus Direview</p><h3 class="mb-0">{{ $stats['harus'] }}</h3></div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-success-subtle rounded-3 p-3 me-3"><i class="ri-checkbox-circle-line fs-3 text-success"></i></div>
                <div><p class="text-muted small mb-0">Selesai</p><h3 class="mb-0">{{ $stats['selesai'] }}</h3></div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-danger-subtle rounded-3 p-3 me-3"><i class="ri-alarm-warning-line fs-3 text-danger"></i></div>
                <div><p class="text-muted small mb-0">Terlambat</p><h3 class="mb-0">{{ $stats['terlambat'] }}</h3></div>
            </div></div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Proposal yang Harus Direview</h6>
                    <a href="{{ route('reviewer.proposal.index') }}" class="text-primary small">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr><th>Judul Proposal</th><th>Ketua</th><th>Tgl Penugasan</th><th>Deadline</th><th class="text-end">Aksi</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($proposalHarusReview as $pr)
                                @php $isLate = $pr->deadline->lt(now()); @endphp
                                <tr>
                                    <td class="text-truncate" style="max-width:240px;" title="{{ $pr->proposal->judul }}">{{ $pr->proposal->judul }}</td>
                                    <td class="small">{{ $pr->proposal->ketua?->nama_lengkap }}</td>
                                    <td class="small">{{ $pr->created_at->format('d M Y') }}</td>
                                    <td class="small {{ $isLate ? 'text-danger' : 'text-muted' }}">
                                        {{ $pr->deadline->format('d M Y') }}
                                        @if ($isLate)<br><span class="badge bg-danger">Terlambat</span>@endif
                                    </td>
                                    <td class="text-end"><a href="{{ route('reviewer.penilaian.form', $pr) }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i> Nilai</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">
                                    <i class="ri-checkbox-circle-line fs-1 d-block mb-2"></i>
                                    Semua tugas review sudah selesai. Bagus!
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Profil Reviewer</h6></div>
                <div class="card-body small">
                    <p class="mb-1"><strong>{{ $dosen?->nama_lengkap }}</strong></p>
                    <p class="text-muted mb-2">{{ $dosen?->fakultas?->nama }}</p>
                    <hr>
                    <p class="mb-1"><strong>NIDN:</strong> {{ $dosen?->nidn ?? '-' }}</p>
                    <p class="mb-1"><strong>Sinta Score:</strong> {{ $dosen?->sinta_score ?? 0 }}</p>
                    <p class="mb-2"><strong>Bidang Keahlian:</strong></p>
                    @forelse ($dosen?->keahlian ?? [] as $k)
                        <span class="badge bg-primary-subtle text-primary me-1 mb-1">{{ $k->nama }}</span>
                    @empty
                        <span class="text-muted">-</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
