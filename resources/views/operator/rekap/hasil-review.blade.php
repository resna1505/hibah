@extends('layouts.operator')

@section('title', 'Rekap Hasil Review')

@php
    $activeNav = 'rekap.hasil';

    $kategoriColor = [
        'Sangat Baik'   => 'bg-primary-subtle text-primary',
        'Baik'          => 'bg-success-subtle text-success',
        'Cukup'         => 'bg-info-subtle text-info',
        'Kurang'        => 'bg-warning-subtle text-warning',
        'Sangat Kurang' => 'bg-danger-subtle text-danger',
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Rekap Hasil Review</h4>
            <p class="text-muted small mb-0">Rekapitulasi nilai review per proposal</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small">Tahun</label>
                    <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach ($tahunList as $t)
                            <option value="{{ $t }}" @selected($tahun == $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Skema</label>
                    <select name="skema_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua Skema</option>
                        @foreach ($skemaList as $s)
                            <option value="{{ $s->id }}" @selected($skemaId == $s->id)>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7 text-end">
                    <a href="{{ route('operator.rekap.hasil.pdf', request()->query()) }}" class="btn btn-sm btn-danger"><i class="ri-file-pdf-line"></i> Export PDF</a>
                    <a href="{{ route('operator.rekap.hasil.csv', request()->query()) }}" class="btn btn-sm btn-success"><i class="ri-file-excel-line"></i> Export Excel/CSV</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Total Proposal</p><h3 class="mb-0 text-primary">{{ $stats['total'] }}</h3></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Rata-rata Skor</p><h3 class="mb-0 text-success">{{ number_format($stats['rata_rata'], 2) }}</h3><small class="text-muted">(skala 0-100)</small></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Skor Tertinggi</p><h3 class="mb-0 text-warning">{{ number_format($stats['tertinggi'], 2) }}</h3></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Skor Terendah</p><h3 class="mb-0 text-danger">{{ number_format($stats['terendah'], 2) }}</h3></div></div></div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><h6 class="mb-0">Daftar Hasil Review</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>No</th><th>Judul</th><th>Ketua</th><th>Fakultas</th><th>Skema</th><th class="text-center">R1</th><th class="text-center">R2</th><th class="text-end">Rata-rata</th><th>Kategori</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $i => $r)
                            @php
                                $kcls = $kategoriColor[$r['kategori']] ?? 'bg-light text-muted';
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="text-truncate small" style="max-width:240px;" title="{{ $r['judul'] }}">{{ $r['judul'] }}</td>
                                <td class="small">{{ $r['ketua'] }}</td>
                                <td class="small">{{ $r['fakultas'] }}</td>
                                <td class="small">{{ $r['skema'] }}</td>
                                <td class="text-center small">{{ $r['nilai_r1'] ?? '-' }}</td>
                                <td class="text-center small">{{ $r['nilai_r2'] ?? '-' }}</td>
                                <td class="text-end fw-bold">{{ $r['rata_rata'] !== null ? number_format($r['rata_rata'], 2) : '-' }}</td>
                                <td><span class="badge {{ $kcls }}">{{ $r['kategori'] }}</span></td>
                                <td><x-status-badge :status="$r['status']" tooltip /></td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center text-muted py-4">Belum ada proposal yang dinilai untuk filter ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
