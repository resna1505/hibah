@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')

@php $activeNav = 'dashboard'; @endphp

@php
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
@endphp

@section('content')
        {{-- Welcome banner --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body bg-primary text-white rounded">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="small mb-1">{{ now()->translatedFormat('d F Y') }}</p>
                        <h4 class="mb-0">Selamat Datang, {{ $dosen?->nama_lengkap ?? 'Dosen' }}!</h4>
                        <p class="mb-0 text-white-50">
                            @if ($periodeAktif)
                                Periode aktif: <strong>{{ $periodeAktif->nama }}</strong>
                            @else
                                Belum ada periode hibah aktif.
                            @endif
                        </p>
                    </div>
                    <div class="col-auto">
                        <i class="ri-user-star-line fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            {{-- Profil Saya --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Profil Saya</h6>
                        <a href="{{ route('dosen.profil.edit') }}" class="btn btn-sm btn-outline-primary">
                            <i class="ri-edit-line"></i> Edit
                        </a>
                    </div>
                    <div class="card-body text-center">
                        @if ($dosen?->foto_path)
                            <img src="{{ asset('storage/' . $dosen->foto_path) }}" alt="" class="rounded-circle mb-3" width="96" height="96" style="object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:96px;height:96px;">
                                <i class="ri-user-line fs-1 text-muted"></i>
                            </div>
                        @endif
                        <h5 class="mb-1">{{ $dosen?->nama_lengkap ?? '-' }}</h5>
                        <p class="text-muted small mb-1">{{ $dosen?->prodi?->nama ?? '-' }}</p>
                        <p class="text-muted small mb-2">Universitas Batam</p>
                        @if ($dosen?->status_aktif_mengajar)
                            <span class="badge bg-success-subtle text-success mb-3">Aktif Mengajar</span>
                        @endif
                        <hr>
                        <div class="row text-center">
                            <div class="col-4">
                                <p class="text-muted small mb-0">Sinta Score</p>
                                <h5 class="text-primary mb-0">{{ $dosen?->sinta_score ?? 0 }}</h5>
                            </div>
                            <div class="col-4">
                                <p class="text-muted small mb-0">Pendidikan</p>
                                <h5 class="mb-0">{{ $dosen?->pendidikan_terakhir ?? '-' }}</h5>
                            </div>
                            <div class="col-4">
                                <p class="text-muted small mb-0">Jabatan</p>
                                <h6 class="mb-0">{{ $dosen?->jabatan_fungsional ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Usulan + Stats --}}
            <div class="col-lg-8">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="avatar-sm bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                                    <i class="ri-file-text-line text-primary fs-4"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Riwayat Penelitian</p>
                                    <h4 class="mb-0">{{ $riwayatStats['penelitian'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="avatar-sm bg-success-subtle rounded-3 d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                                    <i class="ri-community-line text-success fs-4"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Riwayat PKM</p>
                                    <h4 class="mb-0">{{ $riwayatStats['pkm'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="avatar-sm bg-warning-subtle rounded-3 d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                                    <i class="ri-award-line text-warning fs-4"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Riwayat HKI</p>
                                    <h4 class="mb-0">{{ $riwayatStats['hki'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Usulan Saya pada Periode Aktif</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Skema</th>
                                        <th>Anggaran</th>
                                        <th>Tanggal Submit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proposalSaya as $p)
                                        <tr>
                                            <td class="text-truncate" style="max-width:260px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                            <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                            <td class="small">Rp {{ number_format($p->total_anggaran, 0, ',', '.') }}</td>
                                            <td class="small">{{ $p->tgl_submit?->format('d M Y') ?? '-' }}</td>
                                            <td>
                                                @php [$label, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted']; @endphp
                                                <span class="badge {{ $cls }}">{{ $label }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                Anda belum mengajukan proposal pada periode ini.
                                                <br>
                                                <a href="#" class="btn btn-sm btn-primary mt-2">Ajukan Proposal Penelitian</a>
                                                <a href="#" class="btn btn-sm btn-success mt-2">Ajukan PKM</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
