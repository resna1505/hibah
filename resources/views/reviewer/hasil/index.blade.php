@extends('layouts.reviewer')

@section('title', 'Hasil Review')

@php
    $activeNav = 'hasil';
    $rekomendasiBadge = [
        'disetujui'    => ['Disetujui', 'bg-success-subtle text-success'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'ditolak'      => ['Ditolak', 'bg-danger-subtle text-danger'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Hasil Review</h4>
            <p class="text-muted small mb-0">Daftar proposal yang sudah Anda nilai</p>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Disetujui</p><h4 class="text-success mb-0">{{ $stats['disetujui'] }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Revisi (Minor + Mayor)</p><h4 class="text-warning mb-0">{{ $stats['revisi_minor'] + $stats['revisi_mayor'] }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Ditolak</p><h4 class="text-danger mb-0">{{ $stats['ditolak'] }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Total Direview</p><h4 class="text-primary mb-0">{{ $stats['total'] }}</h4></div></div></div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>#</th><th>Judul Proposal</th><th>Kode</th><th>Skema</th><th class="text-end">Nilai Akhir</th><th>Rekomendasi</th><th>Tgl Selesai</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $pr)
                            @php
                                $rek = $pr->penilaian?->rekomendasi ?? '-';
                                [$lbl, $cls] = $rekomendasiBadge[$rek] ?? [$rek, 'bg-light text-muted'];
                            @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:260px;" title="{{ $pr->proposal->judul }}">{{ $pr->proposal->judul }}</td>
                                <td class="small"><code>{{ $pr->proposal->no_registrasi ?? '-' }}</code></td>
                                <td class="small">{{ $pr->proposal->skemaHibah?->nama }}</td>
                                <td class="text-end fw-bold">{{ number_format($pr->penilaian?->nilai_total ?? 0, 2) }}</td>
                                <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                <td class="small">{{ $pr->penilaian?->tgl_selesai?->format('d M Y') ?? '-' }}</td>
                                <td class="text-end"><a href="{{ route('reviewer.hasil.show', $pr) }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i> Lihat</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Anda belum menyelesaikan penilaian apapun.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
