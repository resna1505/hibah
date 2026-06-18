@extends('layouts.operator')

@section('title', 'Biodata Dosen')

@php $activeNav = 'akun-dosen'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Biodata Dosen</h4>
            <p class="text-muted small mb-0">Data profil & riwayat dosen (read-only).</p>
        </div>
        <a href="{{ route('operator.akun-dosen.index') }}" class="btn btn-sm btn-light"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>

    @if (! $dosen)
        <div class="alert alert-warning">Akun ini belum terhubung dengan profil dosen.</div>
    @else
        @if (! $dosen->prodi_id)
            <div class="alert alert-warning small d-flex align-items-center gap-2">
                <i class="ri-error-warning-line"></i>
                <span>Profil dosen belum dilengkapi. Data pribadi diisi sendiri oleh dosen melalui menu Profil setelah login.</span>
            </div>
        @endif

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
                        <div class="mb-2">
                            @if ($dosen->is_reviewer)<span class="badge bg-info-subtle text-info">Reviewer</span>@endif
                            @if ($dosen->is_ketua_eligible)<span class="badge bg-primary-subtle text-primary">Ketua Eligible</span>@endif
                            <span class="badge {{ $akun->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">{{ $akun->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}</span>
                        </div>
                        <table class="table table-sm mb-0 small">
                            <tr><td class="text-muted" width="35%">Username</td><td><code>{{ $akun->username }}</code></td></tr>
                            <tr><td class="text-muted">NIDN / NIDK</td><td>{{ $dosen->nidn ?? '-' }}{{ $dosen->nidk ? ' / ' . $dosen->nidk : '' }}</td></tr>
                            <tr><td class="text-muted">Jabatan Fungsional</td><td>{{ $dosen->jabatan_fungsional ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Pangkat / Golongan</td><td>{{ $dosen->pangkat_golongan ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Pendidikan Terakhir</td><td>{{ $dosen->pendidikan_terakhir ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Fakultas</td><td>{{ $dosen->fakultas?->nama ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Program Studi</td><td>{{ $dosen->prodi?->nama ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Email</td><td>{{ $akun->email ?? '-' }}</td></tr>
                            <tr><td class="text-muted">No HP</td><td>{{ $dosen->no_hp ?? '-' }}</td></tr>
                            <tr><td class="text-muted">ID Sinta / Scopus</td><td>{{ $dosen->sinta_id ?? '-' }} / {{ $dosen->scopus_id ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Google Scholar</td><td>{{ $dosen->google_scholar_id ?? '-' }}</td></tr>
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

        {{-- Riwayat Penelitian --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0">Riwayat Penelitian</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle small">
                        <thead class="table-light"><tr><th width="50">No</th><th width="80">Tahun</th><th>Judul</th><th width="160">Pendanaan</th><th width="120">Peran</th><th width="110">Status</th></tr></thead>
                        <tbody>
                            @forelse ($riwayatPenelitian as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->tahun }}</td>
                                    <td>{{ $r->judul }}</td>
                                    <td>{{ $r->sumber_pendanaan ?? '-' }}</td>
                                    <td>{{ $r->peran ?? '-' }}</td>
                                    <td>{{ $r->status ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada riwayat penelitian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Riwayat Pengabdian (PKM) --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0">Riwayat Pengabdian (PKM)</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle small">
                        <thead class="table-light"><tr><th width="50">No</th><th width="80">Tahun</th><th>Judul</th><th width="180">Mitra / Lokasi</th><th width="120">Peran</th><th width="110">Status</th></tr></thead>
                        <tbody>
                            @forelse ($riwayatPkm as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->tahun }}</td>
                                    <td>{{ $r->judul }}</td>
                                    <td>{{ trim(($r->mitra ?? '') . ($r->lokasi ? ' / ' . $r->lokasi : ''), ' /') ?: '-' }}</td>
                                    <td>{{ $r->peran ?? '-' }}</td>
                                    <td>{{ $r->status ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada riwayat pengabdian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Riwayat HKI --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0">Riwayat HKI</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle small">
                        <thead class="table-light"><tr><th width="50">No</th><th width="120">Jenis</th><th>Judul</th><th width="150">No. Sertifikat</th><th width="90">Tahun</th><th width="110">Status</th></tr></thead>
                        <tbody>
                            @forelse ($riwayatHki as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->jenis_hki }}</td>
                                    <td>{{ $r->judul }}</td>
                                    <td>{{ $r->no_sertifikat ?? $r->no_pendaftaran ?? '-' }}</td>
                                    <td>{{ $r->tahun_terbit ?? $r->tahun_pengajuan ?? '-' }}</td>
                                    <td>{{ $r->status_hki ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada riwayat HKI.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
