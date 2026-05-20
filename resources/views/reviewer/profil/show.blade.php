@extends('layouts.reviewer')

@section('title', 'Profil Reviewer')

@php
    $activeNav = 'profil';

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
            <h4 class="mb-0">Profil Reviewer</h4>
            <p class="text-muted small mb-0">Biodata reviewer + statistik penilaian</p>
        </div>
        <a href="{{ route('dosen.profil.edit') }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i> Edit Profil</a>
    </div>

    {{-- Identitas + Keahlian --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-2 text-center">
                    @if ($dosen->foto_path)
                        <img src="{{ asset('storage/' . $dosen->foto_path) }}" class="rounded-circle border" width="120" height="120" style="object-fit:cover;">
                    @else
                        <div class="rounded-circle bg-light mx-auto d-flex align-items-center justify-content-center" style="width:120px;height:120px;">
                            <i class="ri-user-line fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <h4 class="mb-1">{{ $dosen->nama_lengkap }}</h4>
                    <span class="badge bg-primary-subtle text-primary mb-2">Reviewer Aktif</span>
                    <table class="table table-sm mb-0 small">
                        <tr><td class="text-muted" width="35%">NIDN</td><td>{{ $dosen->nidn ?? '-' }}</td></tr>
                        <tr><td class="text-muted">Fakultas</td><td>{{ $dosen->fakultas?->nama ?? '-' }}</td></tr>
                        <tr><td class="text-muted">Program Studi</td><td>{{ $dosen->prodi?->nama ?? '-' }}</td></tr>
                        <tr><td class="text-muted">Email</td><td>{{ $user->email ?? '-' }}</td></tr>
                        <tr><td class="text-muted">No HP</td><td>{{ $dosen->no_hp ?? '-' }}</td></tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-2">Bidang Keahlian</h6>
                    <div>
                        @forelse ($dosen->keahlian as $k)
                            <span class="badge bg-primary-subtle text-primary mb-1 me-1">{{ $k->nama }}</span>
                        @empty
                            <span class="text-muted small">Belum ada bidang keahlian terdaftar.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-primary-subtle rounded-3 p-3 me-3"><i class="ri-file-text-line fs-3 text-primary"></i></div>
                <div><p class="text-muted small mb-0">Total Review</p><h3 class="mb-0">{{ $stats['total'] }}</h3><small class="text-muted">Proposal</small></div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-success-subtle rounded-3 p-3 me-3"><i class="ri-checkbox-circle-line fs-3 text-success"></i></div>
                <div><p class="text-muted small mb-0">Disetujui</p><h3 class="text-success mb-0">{{ $stats['disetujui'] }}</h3><small class="text-muted">{{ $stats['persen_disetujui'] }}%</small></div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-warning-subtle rounded-3 p-3 me-3"><i class="ri-edit-line fs-3 text-warning"></i></div>
                <div><p class="text-muted small mb-0">Revisi</p><h3 class="text-warning mb-0">{{ $stats['revisi'] }}</h3><small class="text-muted">{{ $stats['persen_revisi'] }}%</small></div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
                <div class="bg-danger-subtle rounded-3 p-3 me-3"><i class="ri-close-circle-line fs-3 text-danger"></i></div>
                <div><p class="text-muted small mb-0">Ditolak</p><h3 class="text-danger mb-0">{{ $stats['ditolak'] }}</h3><small class="text-muted">{{ $stats['persen_ditolak'] }}%</small></div>
            </div></div>
        </div>
    </div>

    {{-- Riwayat Review --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Riwayat Review Terakhir</h6>
            <a href="{{ route('reviewer.hasil.index') }}" class="text-primary small">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>No</th><th>Judul Proposal</th><th>Skema</th><th>Tgl Review</th><th class="text-end">Nilai Akhir</th><th>Rekomendasi</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($riwayatReview as $i => $pr)
                            @php
                                $rek = $pr->penilaian?->rekomendasi ?? '-';
                                [$lbl, $cls] = $rekomendasiBadge[$rek] ?? [$rek, 'bg-light text-muted'];
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="text-truncate small" style="max-width:240px;">{{ $pr->proposal->judul }}</td>
                                <td class="small">{{ $pr->proposal->skemaHibah?->nama }}</td>
                                <td class="small">{{ $pr->penilaian?->tgl_selesai?->format('d M Y') ?? '-' }}</td>
                                <td class="text-end fw-bold">{{ number_format($pr->penilaian?->nilai_total ?? 0, 2) }}</td>
                                <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                <td class="text-end"><a href="{{ route('reviewer.hasil.show', $pr) }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i></a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada riwayat review.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
