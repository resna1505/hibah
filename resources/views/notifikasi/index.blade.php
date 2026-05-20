@php
    $u = auth()->user();
    $layout = match ($u->role) {
        'operator' => 'layouts.operator',
        default    => ($u->dosen?->is_reviewer && request()->is('reviewer/*')) ? 'layouts.reviewer' : 'layouts.dosen',
    };
@endphp

@extends($layout)

@section('title', 'Notifikasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Notifikasi</h4>
            <p class="text-muted small mb-0">{{ $stats['total'] }} total, {{ $stats['belum_dibaca'] }} belum dibaca</p>
        </div>
        @if ($stats['belum_dibaca'] > 0)
            <form method="POST" action="{{ route('notifikasi.mark-all-read') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ri-check-double-line me-1"></i> Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $filter === 'semua' ? 'active' : '' }}" href="{{ route('notifikasi.index') }}">
                Semua <span class="badge bg-light text-dark ms-1">{{ $stats['total'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter === 'belum_dibaca' ? 'active' : '' }}" href="{{ route('notifikasi.index', ['filter' => 'belum_dibaca']) }}">
                Belum Dibaca <span class="badge bg-danger ms-1">{{ $stats['belum_dibaca'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter === 'sudah_dibaca' ? 'active' : '' }}" href="{{ route('notifikasi.index', ['filter' => 'sudah_dibaca']) }}">
                Sudah Dibaca <span class="badge bg-light text-dark ms-1">{{ $stats['sudah_dibaca'] }}</span>
            </a>
        </li>
    </ul>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse ($list as $n)
                    <a href="{{ route('notifikasi.read', $n) }}"
                        class="list-group-item list-group-item-action {{ $n->dibaca_at ? '' : 'bg-primary-subtle border-start border-primary border-4' }}">
                        <div class="d-flex align-items-start">
                            <div class="rounded-circle bg-light p-2 me-3" style="width:40px; height:40px; text-align:center;">
                                <i class="{{ $n->icon ?? 'ri-notification-3-line' }} text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1 {{ $n->dibaca_at ? '' : 'fw-bold' }}">{{ $n->judul }}</h6>
                                    <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 small text-muted">{{ $n->pesan }}</p>
                                @if (! $n->dibaca_at)
                                    <small class="text-primary"><i class="ri-circle-fill" style="font-size:0.5rem;"></i> Belum dibaca</small>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="ri-notification-off-line fs-1 d-block mb-2"></i>
                        Belum ada notifikasi.
                    </div>
                @endforelse
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
