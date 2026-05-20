@extends('layouts.operator')

@section('title', 'Penilaian Proposal')

@php
    $activeNav = 'penilaian';

    $statusBadge = [
        'direview'     => ['Sedang Direview', 'bg-info-subtle text-info'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'disetujui'    => ['Disetujui', 'bg-success-subtle text-success'],
        'ditolak'      => ['Ditolak', 'bg-danger-subtle text-danger'],
        'berjalan'     => ['Berjalan', 'bg-primary-subtle text-primary'],
        'selesai'      => ['Selesai', 'bg-success-subtle text-success'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Penilaian Proposal</h4>
            <p class="text-muted small mb-0">{{ $periodeAktif?->nama ?? 'Belum ada periode aktif' }} &middot; Finalize keputusan operator berdasarkan hasil review</p>
        </div>
    </div>

    {{-- Stats summary --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Total Dinilai</p><h4 class="mb-0 text-primary">{{ $stats['total_dinilai'] }}</h4><small class="text-muted">Proposal</small></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Rata-rata Skor</p><h4 class="mb-0 text-success">{{ number_format($stats['rata_rata'], 2) }}</h4><small class="text-muted">Skala 0-100</small></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Skor Tertinggi</p><h4 class="mb-0 text-warning">{{ number_format($stats['tertinggi'], 2) }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Skor Terendah</p><h4 class="mb-0 text-danger">{{ number_format($stats['terendah'], 2) }}</h4></div></div></div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small">Cari Judul / Ketua</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach (['direview', 'revisi_minor', 'revisi_mayor', 'disetujui', 'ditolak'] as $st)
                            <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ri-filter-line"></i> Filter</button>
                    <a href="{{ route('operator.penilaian.index') }}" class="btn btn-sm btn-light"><i class="ri-restart-line"></i></a>
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
                            <th>Judul</th>
                            <th>Ketua</th>
                            <th>Skema</th>
                            <th class="text-center">Reviewer<br><small class="text-muted">(Selesai/Total)</small></th>
                            <th class="text-end">Nilai Akhir</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            @php
                                $completed = $p->penugasanReviewer->filter(fn($pr) => $pr->penilaian !== null);
                                $rataRata = $completed->count() > 0
                                    ? $completed->map(fn($pr) => $pr->penilaian->nilai_total)->avg()
                                    : null;
                                [$lbl, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted'];
                            @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:260px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">{{ $completed->count() }} / {{ $p->penugasanReviewer->count() }}</span>
                                </td>
                                <td class="text-end fw-bold">
                                    @if ($rataRata !== null)
                                        {{ number_format($rataRata, 2) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('operator.penilaian.show', $p) }}" class="btn btn-sm btn-primary">
                                        <i class="ri-eye-line"></i> {{ $p->status === 'direview' ? 'Finalize' : 'Detail' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada proposal yang sedang/sudah direview.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>

    @if ($stats['total_dinilai'] > 0)
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white"><h6 class="mb-0">Distribusi Kategori Nilai</h6></div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <canvas id="chartDistribusi" style="max-height:280px;"></canvas>
                    </div>
                    <div class="col-md-7">
                        <table class="table table-sm mb-0">
                            <tr><td><span class="badge bg-primary me-2">&nbsp;</span> Sangat Baik (≥85)</td><td class="text-end"><strong>{{ $stats['distribusi']['sangat_baik'] }}</strong> proposal</td></tr>
                            <tr><td><span class="badge bg-success me-2">&nbsp;</span> Baik (70-84)</td><td class="text-end"><strong>{{ $stats['distribusi']['baik'] }}</strong> proposal</td></tr>
                            <tr><td><span class="badge bg-info me-2">&nbsp;</span> Cukup (55-69)</td><td class="text-end"><strong>{{ $stats['distribusi']['cukup'] }}</strong> proposal</td></tr>
                            <tr><td><span class="badge bg-warning me-2">&nbsp;</span> Kurang (40-54)</td><td class="text-end"><strong>{{ $stats['distribusi']['kurang'] }}</strong> proposal</td></tr>
                            <tr><td><span class="badge bg-danger me-2">&nbsp;</span> Sangat Kurang (&lt;40)</td><td class="text-end"><strong>{{ $stats['distribusi']['sangat_kurang'] }}</strong> proposal</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
@if ($stats['total_dinilai'] > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartDistribusi');
    if (!ctx) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Sangat Baik (≥85)', 'Baik (70-84)', 'Cukup (55-69)', 'Kurang (40-54)', 'Sangat Kurang (<40)'],
            datasets: [{
                data: [
                    {{ $stats['distribusi']['sangat_baik'] }},
                    {{ $stats['distribusi']['baik'] }},
                    {{ $stats['distribusi']['cukup'] }},
                    {{ $stats['distribusi']['kurang'] }},
                    {{ $stats['distribusi']['sangat_kurang'] }},
                ],
                backgroundColor: ['#0d6efd', '#198754', '#0dcaf0', '#ffc107', '#dc3545'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endif
@endsection
