@extends('layouts.reviewer')

@section('title', 'Detail Hasil Review')

@php
    $activeNav = 'hasil';
    $p = $penugasan->proposal;
    $pen = $penugasan->penilaian;

    $rekomendasiBadge = [
        'disetujui'    => ['Disetujui', 'bg-success-subtle text-success'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'ditolak'      => ['Ditolak', 'bg-danger-subtle text-danger'],
    ];
    [$lbl, $cls] = $rekomendasiBadge[$pen?->rekomendasi ?? '-'] ?? ['-', 'bg-light text-muted'];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Hasil Review</h4>
            <p class="text-muted small mb-0">{{ $p->judul }}</p>
        </div>
        <a href="{{ route('reviewer.hasil.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Penilaian per Komponen</h6></div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light"><tr><th>Komponen</th><th class="text-center">Bobot (%)</th><th class="text-center">Skor</th><th class="text-end">Nilai</th></tr></thead>
                        <tbody>
                            @foreach ($pen?->detail ?? [] as $d)
                                @php $nilai = ($d->skor / 5) * $d->kriteria->bobot_persen; @endphp
                                <tr>
                                    <td>{{ $d->kriteria->nama }}@if ($d->catatan)<br><small class="text-muted fst-italic">"{{ $d->catatan }}"</small>@endif</td>
                                    <td class="text-center">{{ $d->kriteria->bobot_persen }}</td>
                                    <td class="text-center"><span class="badge bg-primary">{{ $d->skor }}</span></td>
                                    <td class="text-end">{{ number_format($nilai, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot><tr class="fw-bold table-light"><td colspan="3" class="text-end">TOTAL NILAI:</td><td class="text-end fs-5 text-primary">{{ number_format($pen?->nilai_total ?? 0, 2) }}</td></tr></tfoot>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-white"><h6 class="mb-0">Catatan untuk Peneliti</h6></div>
                <div class="card-body">
                    <p class="small mb-0" style="white-space:pre-wrap;">{{ $pen?->catatan_umum }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Ringkasan</h6></div>
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Nilai</p>
                    <h2 class="text-success mb-0">{{ number_format($pen?->nilai_total ?? 0, 2) }}<small class="text-muted fs-6"> / 100</small></h2>
                    <p class="text-muted small">Kategori: <strong>{{ $kategori }}</strong></p>

                    <hr>
                    <p class="text-muted small mb-1">Rekomendasi</p>
                    <span class="badge {{ $cls }} fs-6">{{ $lbl }}</span>

                    <hr>
                    <p class="text-muted small mb-1">Tanggal Selesai</p>
                    <p class="mb-0">{{ $pen?->tgl_selesai?->format('d M Y H:i') ?? '-' }}</p>

                    <hr>
                    <p class="text-muted small mb-1">Peran</p>
                    <p class="mb-0">{{ ucfirst(str_replace('reviewer_', 'Reviewer ', $penugasan->peran)) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
