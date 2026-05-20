@extends('layouts.operator')

@section('title', 'Penugasan Reviewer')

@php $activeNav = 'reviewer.penugasan'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Penugasan Reviewer</h4>
            <p class="text-muted small mb-0">Proposal yang sudah diverifikasi lengkap dan siap di-assign ke reviewer</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label small">Cari Judul</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ri-filter-line"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul Proposal</th>
                            <th>Ketua</th>
                            <th>Skema</th>
                            <th>Status Penugasan</th>
                            <th>Reviewer Ditugaskan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            @php
                                $reviewerCount = $p->penugasanReviewer->count();
                            @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:300px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                <td>
                                    @if ($reviewerCount === 0)
                                        <span class="badge bg-warning-subtle text-warning">Belum Ditugaskan</span>
                                    @else
                                        <span class="badge bg-info-subtle text-info">Ditugaskan ({{ $reviewerCount }})</span>
                                    @endif
                                </td>
                                <td class="small">
                                    @foreach ($p->penugasanReviewer as $pr)
                                        <div>{{ str_replace('reviewer_', 'R', $pr->peran) }}: {{ $pr->reviewer?->nama_lengkap }} <span class="text-muted">({{ $pr->status }})</span></div>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('operator.reviewer.assign.form', $p) }}" class="btn btn-sm btn-primary">
                                        <i class="ri-user-add-line"></i> {{ $reviewerCount > 0 ? 'Ubah' : 'Tugaskan' }} Reviewer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada proposal yang siap ditugaskan reviewer.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
