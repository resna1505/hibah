@extends('layouts.operator')

@section('title', 'Monitoring Reviewer')

@php $activeNav = 'reviewer.monitoring'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Monitoring Reviewer</h4>
            <p class="text-muted small mb-0">{{ $periodeAktif?->nama ?? 'Belum ada periode aktif' }}</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Reviewer</th>
                            <th>Fakultas</th>
                            <th class="text-center">Total Tugas</th>
                            <th class="text-center">Selesai</th>
                            <th class="text-center">Sedang</th>
                            <th class="text-center">Belum</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $d)
                            @php
                                $pct = $d->total_tugas > 0 ? round(($d->selesai / $d->total_tugas) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td class="small">{{ $d->fakultas?->kode }}</td>
                                <td class="text-center">{{ $d->total_tugas }}</td>
                                <td class="text-center text-success">{{ $d->selesai }}</td>
                                <td class="text-center text-warning">{{ $d->sedang }}</td>
                                <td class="text-center text-danger">{{ $d->belum }}</td>
                                <td style="min-width:160px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height:6px;">
                                            <div class="progress-bar bg-success" style="width:{{ $pct }}%;"></div>
                                        </div>
                                        <small class="text-muted">{{ $pct }}%</small>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada reviewer aktif.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
