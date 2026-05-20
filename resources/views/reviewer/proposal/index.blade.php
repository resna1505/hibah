@extends('layouts.reviewer')

@section('title', 'Proposal Hibah')

@php
    $activeNav = 'proposal';

    $statusBadge = [
        'draft' => ['Draft', 'bg-secondary-subtle text-secondary'],
        'submitted' => ['Menunggu Verifikasi', 'bg-info-subtle text-info'],
        'verifikasi' => ['Terverifikasi', 'bg-info-subtle text-info'],
        'dikembalikan' => ['Dikembalikan', 'bg-warning-subtle text-warning'],
        'direview' => ['Sedang Direview', 'bg-info-subtle text-info'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'disetujui' => ['Disetujui', 'bg-success-subtle text-success'],
        'ditolak' => ['Ditolak', 'bg-danger-subtle text-danger'],
        'berjalan' => ['Berjalan', 'bg-primary-subtle text-primary'],
        'selesai' => ['Selesai', 'bg-success-subtle text-success'],
    ];

    $tabs = [
        'ditugaskan'      => ['Ditugaskan ke Saya', 'ri-user-star-line'],
        'menunggu_review' => ['Menunggu Review', 'ri-time-line'],
        'selesai_review'  => ['Sudah Direview', 'ri-checkbox-circle-line'],
        'semua'           => ['Semua Proposal', 'ri-file-list-3-line'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Proposal Hibah</h4>
            <p class="text-muted small mb-0">{{ $periodeAktif?->nama ?? 'Belum ada periode aktif' }}</p>
        </div>
    </div>

    <ul class="nav nav-tabs mb-3">
        @foreach ($tabs as $key => [$label, $icon])
            <li class="nav-item">
                <a class="nav-link {{ $tab === $key ? 'active' : '' }}" href="{{ route('reviewer.proposal.index', ['tab' => $key]) }}">
                    <i class="{{ $icon }} me-1"></i>{{ $label }}
                    <span class="badge bg-light text-dark ms-1">{{ $tabCounts[$key] ?? 0 }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="col-md-6">
                    <label class="form-label small">Cari Judul / Ketua</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
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
                        <tr><th>#</th><th>Judul</th><th>Ketua</th><th>Fakultas</th><th>Skema</th><th>Status</th><th>Penugasan</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            @php
                                $myPen = $p->penugasanReviewer->first();
                                [$lbl, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted'];
                            @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:240px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $p->ketua?->fakultas?->kode }}</td>
                                <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                <td class="small">
                                    @if ($myPen)
                                        {{ ucfirst(str_replace('reviewer_', 'Reviewer ', $myPen->peran)) }}
                                        <br><span class="text-muted">Deadline: {{ $myPen->deadline->format('d M Y') }}</span>
                                        @if ($myPen->status === 'selesai')
                                            <br><span class="badge bg-success-subtle text-success">Selesai Nilai</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('reviewer.proposal.show', $p) }}" class="btn btn-outline-primary" title="Lihat"><i class="ri-eye-line"></i></a>
                                        @if ($myPen)
                                            <a href="{{ route('reviewer.proposal.pdf', $p) }}" class="btn btn-outline-secondary" title="Unduh PDF"><i class="ri-download-line"></i></a>
                                        @endif
                                        @if ($myPen && in_array($myPen->status, ['ditugaskan', 'sedang_review']))
                                            <a href="{{ route('reviewer.penilaian.form', $myPen) }}" class="btn btn-primary"><i class="ri-edit-line"></i> Nilai</a>
                                        @elseif ($myPen?->status === 'selesai')
                                            <a href="{{ route('reviewer.hasil.show', $myPen) }}" class="btn btn-success"><i class="ri-file-text-line"></i> Hasil</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada proposal di tab ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
