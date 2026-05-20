@extends('layouts.reviewer')

@section('title', 'Jadwal Review')

@php $activeNav = 'jadwal'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Jadwal Review</h4>
            <p class="text-muted small mb-0">{{ $periodeAktif?->nama ?? 'Belum ada periode aktif' }}</p>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Total Penugasan</p><h4 class="text-primary mb-0">{{ $stats['total'] }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Selesai</p><h4 class="text-success mb-0">{{ $stats['selesai'] }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Sedang Direview</p><h4 class="text-warning mb-0">{{ $stats['sedang'] }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Terlambat</p><h4 class="text-danger mb-0">{{ $stats['terlambat'] }}</h4></div></div></div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>#</th><th>Judul Proposal</th><th>Ketua</th><th>Skema</th><th>Tgl Penugasan</th><th>Deadline</th><th>Status</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $pr)
                            @php
                                $isLate = $pr->status !== 'selesai' && $pr->deadline->lt(now());
                                $isWarn = $pr->status !== 'selesai' && $pr->deadline->diffInDays(now()) <= 3 && ! $isLate;
                                $statusBadge = match ($pr->status) {
                                    'selesai'       => ['Selesai', 'bg-success-subtle text-success'],
                                    'sedang_review' => $isLate ? ['Terlambat', 'bg-danger-subtle text-danger'] : ($isWarn ? ['Deadline Dekat', 'bg-warning-subtle text-warning'] : ['Sedang Direview', 'bg-info-subtle text-info']),
                                    'ditugaskan'    => $isLate ? ['Terlambat', 'bg-danger-subtle text-danger'] : ($isWarn ? ['Deadline Dekat', 'bg-warning-subtle text-warning'] : ['Ditugaskan', 'bg-info-subtle text-info']),
                                    default         => [$pr->status, 'bg-light text-muted'],
                                };
                            @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:260px;" title="{{ $pr->proposal->judul }}">{{ $pr->proposal->judul }}</td>
                                <td class="small">{{ $pr->proposal->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $pr->proposal->skemaHibah?->nama }}</td>
                                <td class="small">{{ $pr->created_at->format('d M Y') }}</td>
                                <td class="small {{ $isLate ? 'text-danger fw-bold' : '' }}">{{ $pr->deadline->format('d M Y') }}@if ($isLate)<br><small>({{ $pr->deadline->diffForHumans() }})</small>@endif</td>
                                <td><span class="badge {{ $statusBadge[1] }}">{{ $statusBadge[0] }}</span></td>
                                <td class="text-end">
                                    @if ($pr->status === 'selesai')
                                        <a href="{{ route('reviewer.hasil.show', $pr) }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i></a>
                                    @else
                                        <a href="{{ route('reviewer.penilaian.form', $pr) }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i> Nilai</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada penugasan review.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
