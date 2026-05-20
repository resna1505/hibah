@extends('layouts.operator')

@section('title', 'Rekap Proposal')

@php $activeNav = 'rekap.proposal'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Rekap Proposal</h4>
            <p class="text-muted small mb-0">Rekapitulasi jumlah proposal berdasarkan fakultas dan status</p>
        </div>
    </div>

    {{-- Filter --}}
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
                    <label class="form-label small">Skema Hibah</label>
                    <select name="skema_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua Skema</option>
                        @foreach ($skemaList as $s)
                            <option value="{{ $s->id }}" @selected($skemaId == $s->id)>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7 text-end">
                    <a href="{{ route('operator.rekap.proposal.pdf', request()->query()) }}" class="btn btn-sm btn-danger"><i class="ri-file-pdf-line"></i> Export PDF</a>
                    <a href="{{ route('operator.rekap.proposal.csv', request()->query()) }}" class="btn btn-sm btn-success"><i class="ri-file-excel-line"></i> Export Excel/CSV</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Total Proposal</p><h3 class="mb-0 text-primary">{{ $totals['total'] }}</h3></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Disetujui</p><h3 class="mb-0 text-success">{{ $totals['disetujui'] }}</h3><small class="text-muted">{{ $totals['persen_disetujui'] }}%</small></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Revisi</p><h3 class="mb-0 text-warning">{{ $totals['revisi'] }}</h3></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Ditolak</p><h3 class="mb-0 text-danger">{{ $totals['ditolak'] }}</h3></div></div></div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><h6 class="mb-0">Rekap Proposal Tahun {{ $tahun }}</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>No</th><th>Fakultas</th><th class="text-center">Total</th><th class="text-center">Disetujui</th><th class="text-center">Revisi</th><th class="text-center">Ditolak</th><th>Persentase Disetujui</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $r['nama'] }}</td>
                                <td class="text-center">{{ $r['total'] }}</td>
                                <td class="text-center text-success">{{ $r['disetujui'] }}</td>
                                <td class="text-center text-warning">{{ $r['revisi'] }}</td>
                                <td class="text-center text-danger">{{ $r['ditolak'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height:8px;">
                                            <div class="progress-bar bg-success" style="width:{{ $r['persen_disetujui'] }}%;"></div>
                                        </div>
                                        <small class="text-muted" style="min-width:50px;">{{ $r['persen_disetujui'] }}%</small>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data proposal untuk filter ini.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td class="text-center">{{ $totals['total'] }}</td>
                            <td class="text-center text-success">{{ $totals['disetujui'] }}</td>
                            <td class="text-center text-warning">{{ $totals['revisi'] }}</td>
                            <td class="text-center text-danger">{{ $totals['ditolak'] }}</td>
                            <td>{{ $totals['persen_disetujui'] }}%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
