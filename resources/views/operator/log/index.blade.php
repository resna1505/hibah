@extends('layouts.operator')

@section('title', 'Log Aktivitas')

@php $activeNav = 'log'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Log Aktivitas</h4>
            <p class="text-muted small mb-0">Rekam jejak aktivitas pengguna di sistem (audit trail).</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small mb-1">Modul</label>
                    <select name="modul" class="form-select form-select-sm">
                        <option value="">-- Semua Modul --</option>
                        @foreach ($modulList as $m)
                            <option value="{{ $m }}" @selected($modul === $m)>{{ ucfirst(str_replace('_', ' ', $m)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small mb-1">Cari</label>
                    <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Aktivitas / deskripsi / NIK...">
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-primary"><i class="ri-search-line"></i> Filter</button>
                    @if ($modul || $q)<a href="{{ route('operator.log.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>@endif
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="160">Waktu</th>
                        <th width="150">Pengguna</th>
                        <th width="120">Modul</th>
                        <th width="130">Aktivitas</th>
                        <th>Deskripsi</th>
                        <th width="110">IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($log as $l)
                        <tr>
                            <td class="small text-muted">{{ $l->created_at?->translatedFormat('d M Y H:i') }}</td>
                            <td class="small">
                                @if ($l->user)
                                    <code>{{ $l->user->nik }}</code><br>
                                    <span class="text-muted">{{ ucfirst($l->user->role) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary-subtle text-dark">{{ str_replace('_', ' ', $l->modul) }}</span></td>
                            <td class="small">{{ str_replace('_', ' ', $l->aktivitas) }}</td>
                            <td class="small">{{ $l->deskripsi }}</td>
                            <td class="small text-muted">{{ $l->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada aktivitas tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($log->hasPages())
            <div class="card-footer bg-white">{{ $log->links() }}</div>
        @endif
    </div>
@endsection
