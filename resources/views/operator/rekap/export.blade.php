@extends('layouts.operator')

@section('title', 'Export Laporan')

@php $activeNav = 'rekap.export'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Export Laporan</h4>
            <p class="text-muted small mb-0">Pilih jenis laporan dan format export</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white"><h6 class="mb-0">Daftar Laporan Tersedia</h6></div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded bg-danger-subtle p-2"><i class="ri-file-text-line text-danger fs-3"></i></div>
                        <div>
                            <h6 class="mb-0">Rekap Proposal</h6>
                            <small class="text-muted">Rekapitulasi jumlah proposal berdasarkan status, fakultas, dan skema hibah</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('operator.rekap.proposal') }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i> Lihat</a>
                        <a href="{{ route('operator.rekap.proposal.pdf') }}" class="btn btn-sm btn-danger"><i class="ri-file-pdf-line"></i> PDF</a>
                        <a href="{{ route('operator.rekap.proposal.csv') }}" class="btn btn-sm btn-success"><i class="ri-file-excel-line"></i> Excel</a>
                    </div>
                </div>
                <div class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded bg-success-subtle p-2"><i class="ri-file-list-line text-success fs-3"></i></div>
                        <div>
                            <h6 class="mb-0">Rekap Hasil Review</h6>
                            <small class="text-muted">Rekapitulasi nilai review per proposal beserta agregasi dan kategori</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('operator.rekap.hasil') }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i> Lihat</a>
                        <a href="{{ route('operator.rekap.hasil.pdf') }}" class="btn btn-sm btn-danger"><i class="ri-file-pdf-line"></i> PDF</a>
                        <a href="{{ route('operator.rekap.hasil.csv') }}" class="btn btn-sm btn-success"><i class="ri-file-excel-line"></i> Excel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="ri-information-line me-1"></i>
        <strong>Format yang Tersedia:</strong>
        <span class="badge bg-danger ms-2"><i class="ri-file-pdf-line"></i> PDF (Portable Document Format)</span>
        <span class="badge bg-success ms-1"><i class="ri-file-excel-line"></i> Excel/CSV (UTF-8 BOM, Excel-friendly)</span>
        <br>
        <small class="text-muted mt-2 d-block">Pilih jenis laporan, klik "Lihat" untuk preview dengan filter, atau langsung klik PDF/Excel untuk download.</small>
    </div>
@endsection
