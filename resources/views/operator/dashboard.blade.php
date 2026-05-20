@extends('layouts.operator')

@section('title', 'Dashboard Operator')

@php
    $activeNav = 'dashboard';
    $user = auth()->user();

    $statusBadge = [
        'draft'        => ['Draft', 'bg-secondary-subtle text-secondary'],
        'submitted'    => ['Submitted', 'bg-info-subtle text-info'],
        'verifikasi'   => ['Menunggu Verifikasi', 'bg-warning-subtle text-warning'],
        'dikembalikan' => ['Dikembalikan', 'bg-warning-subtle text-warning'],
        'direview'     => ['Sedang Direview', 'bg-info-subtle text-info'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'disetujui'    => ['Disetujui', 'bg-success-subtle text-success'],
        'ditolak'      => ['Ditolak', 'bg-danger-subtle text-danger'],
        'berjalan'     => ['Berjalan', 'bg-primary-subtle text-primary'],
        'selesai'      => ['Selesai', 'bg-success-subtle text-success'],
        'ditarik'      => ['Ditarik', 'bg-secondary-subtle text-secondary'],
    ];

    $tahapanStatusClass = [
        'belum_mulai' => 'bg-light text-muted',
        'berjalan'    => 'bg-warning text-dark',
        'selesai'     => 'bg-success text-white',
    ];

    $tahapanIcon = [
        'pengajuan'  => 'ri-file-text-line',
        'review'     => 'ri-team-line',
        'revisi'     => 'ri-edit-line',
        'penetapan'  => 'ri-checkbox-circle-line',
        'pengumuman' => 'ri-megaphone-line',
        'pelaksanaan'=> 'ri-briefcase-line',
    ];
@endphp

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">Dashboard</h4>
                <p class="text-muted mb-0">Selamat datang, Operator</p>
            </div>
            <div>
                @if ($periode)
                    <span class="badge bg-primary fs-6">Periode Aktif: {{ $periode->nama }}</span>
                @else
                    <span class="badge bg-warning text-dark fs-6">Belum ada periode aktif</span>
                @endif
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-sm bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center me-3" style="width:56px;height:56px;">
                            <i class="ri-file-text-line text-primary fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Proposal</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                            <p class="text-muted mb-0 small">Proposal Masuk</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-sm bg-success-subtle rounded-3 d-flex align-items-center justify-content-center me-3" style="width:56px;height:56px;">
                            <i class="ri-checkbox-circle-line text-success fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Disetujui</p>
                            <h3 class="mb-0">{{ $stats['disetujui'] }}</h3>
                            <p class="text-muted mb-0 small">
                                {{ $stats['total'] > 0 ? number_format($stats['disetujui'] / $stats['total'] * 100, 2) : '0' }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-sm bg-warning-subtle rounded-3 d-flex align-items-center justify-content-center me-3" style="width:56px;height:56px;">
                            <i class="ri-edit-line text-warning fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Revisi</p>
                            <h3 class="mb-0">{{ $stats['revisi'] }}</h3>
                            <p class="text-muted mb-0 small">
                                {{ $stats['total'] > 0 ? number_format($stats['revisi'] / $stats['total'] * 100, 2) : '0' }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar-sm bg-danger-subtle rounded-3 d-flex align-items-center justify-content-center me-3" style="width:56px;height:56px;">
                            <i class="ri-close-circle-line text-danger fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Ditolak</p>
                            <h3 class="mb-0">{{ $stats['ditolak'] }}</h3>
                            <p class="text-muted mb-0 small">
                                {{ $stats['total'] > 0 ? number_format($stats['ditolak'] / $stats['total'] * 100, 2) : '0' }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik Proposal (Line Chart) --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">Statistik Proposal</h6>
                <small class="text-muted">Tren 12 bulan terakhir</small>
            </div>
            <div class="card-body">
                <canvas id="chartProposal" style="max-height:280px;"></canvas>
            </div>
        </div>

        <div class="row g-3 mb-4">
            {{-- Proposal Terbaru --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Proposal Terbaru</h6>
                        <a href="{{ route('operator.proposal.index') }}" class="text-primary small">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul Proposal</th>
                                        <th>Ketua Peneliti</th>
                                        <th>Skema</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proposalTerbaru as $p)
                                        <tr>
                                            <td class="text-truncate" style="max-width:240px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                            <td class="small">{{ $p->ketua?->nama_lengkap ?? '-' }}</td>
                                            <td class="small">{{ $p->skemaHibah?->nama ?? '-' }}</td>
                                            <td class="small">{{ $p->tgl_submit?->format('d M Y') ?? '-' }}</td>
                                            <td>
                                                @php
                                                    [$label, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted'];
                                                @endphp
                                                <span class="badge {{ $cls }}">{{ $label }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada proposal masuk pada periode ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notifikasi --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Notifikasi</h6>
                        <a href="#" class="text-primary small">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @forelse ($notifikasi as $n)
                            <div class="d-flex mb-3">
                                <div class="me-3"><i class="ri-notification-3-line text-primary"></i></div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 small fw-medium">{{ $n->judul }}</p>
                                    <p class="text-muted small mb-0">{{ $n->pesan }}</p>
                                    <p class="text-muted small mb-0">{{ $n->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="ri-notification-off-line fs-1 d-block mb-2"></i>
                                Belum ada notifikasi.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Progress Tahapan Hibah --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Progress Tahapan Hibah</h6>
            </div>
            <div class="card-body">
                @if ($jadwalTahapan->isEmpty())
                    <div class="text-center text-muted py-4">Belum ada jadwal tahapan untuk periode ini.</div>
                @else
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        @foreach ($jadwalTahapan as $j)
                            @php
                                $kode = $j->tahapanHibah?->kode ?? '';
                                $icon = $tahapanIcon[$kode] ?? 'ri-calendar-line';
                                $statusKey = $j->status;
                                $cls = $tahapanStatusClass[$statusKey] ?? 'bg-light text-muted';
                            @endphp
                            <div class="text-center" style="flex:1; min-width:140px;">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 {{ $cls }}" style="width:64px;height:64px;">
                                    <i class="{{ $icon }} fs-3"></i>
                                </div>
                                <p class="fw-medium mb-1 small">{{ $j->tahapanHibah?->nama }}</p>
                                <p class="text-muted small mb-1">
                                    {{ $j->tgl_mulai?->format('d M') }} &mdash; {{ $j->tgl_selesai?->format('d M Y') }}
                                </p>
                                <span class="badge {{ $statusKey === 'selesai' ? 'bg-success-subtle text-success' : ($statusKey === 'berjalan' ? 'bg-warning-subtle text-warning' : 'bg-light text-muted') }}">
                                    {{ ucfirst(str_replace('_', ' ', $statusKey)) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartProposal');
    if (!ctx) return;

    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                { label: 'Masuk',     data: chartData.masuk,     borderColor: '#0d6efd', backgroundColor: 'rgba(13,110,253,0.08)', tension: 0.3, fill: true, borderWidth: 2 },
                { label: 'Disetujui', data: chartData.disetujui, borderColor: '#198754', backgroundColor: 'transparent', tension: 0.3, borderWidth: 2 },
                { label: 'Revisi',    data: chartData.revisi,    borderColor: '#ffc107', backgroundColor: 'transparent', tension: 0.3, borderWidth: 2 },
                { label: 'Ditolak',   data: chartData.ditolak,   borderColor: '#dc3545', backgroundColor: 'transparent', tension: 0.3, borderWidth: 2 },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false },
            },
            interaction: { mode: 'nearest', axis: 'x', intersect: false },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection
