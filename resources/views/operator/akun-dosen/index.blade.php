@extends('layouts.operator')

@section('title', 'Akun Dosen')

@php $activeNav = 'akun-dosen'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Akun Login Dosen</h4>
            <p class="text-muted small mb-0">Buat akun login (NIDN + username + password). Data pribadi lengkap diisi sendiri oleh dosen setelah login.</p>
        </div>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mTambah">
            <i class="ri-user-add-line"></i> Buat Akun Dosen
        </button>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-danger small">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari NIDN / nama / email...">
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-primary"><i class="ri-search-line"></i> Cari</button>
                    @if ($q)<a href="{{ route('operator.akun-dosen.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>@endif
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="160">NIDN</th>
                        <th>Nama</th>
                        <th width="180">Email</th>
                        <th width="100">Profil</th>
                        <th width="90">Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($akun as $u)
                        <tr>
                            <td><code>{{ $u->dosen?->nidn ?? $u->nik }}</code></td>
                            <td>
                                {{ $u->dosen?->nama_lengkap ?? '-' }}
                                @if ($u->dosen?->is_reviewer)<span class="badge bg-info-subtle text-info ms-1">Reviewer</span>@endif
                            </td>
                            <td class="small text-muted">{{ $u->email ?? '-' }}</td>
                            <td>
                                @if ($u->dosen && $u->dosen->prodi_id)
                                    <span class="badge bg-success-subtle text-success">Lengkap</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Belum</span>
                                @endif
                            </td>
                            <td>
                                @if ($u->is_active)
                                    <span class="badge bg-success-subtle text-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mReset{{ $u->id }}" title="Reset password">
                                    <i class="ri-lock-password-line"></i>
                                </button>
                                <form method="POST" action="{{ route('operator.akun-dosen.toggle', $u) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm {{ $u->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="ri-{{ $u->is_active ? 'pause' : 'play' }}-circle-line"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal reset password --}}
                        <div class="modal fade" id="mReset{{ $u->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('operator.akun-dosen.reset-password', $u) }}" class="modal-content">
                                    @csrf @method('PATCH')
                                    <div class="modal-header"><h6 class="modal-title">Reset Password — {{ $u->username }} (NIDN: {{ $u->dosen?->nidn ?? $u->nik }})</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-2"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control" required minlength="6"></div>
                                        <div class="mb-2"><label class="form-label">Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control" required minlength="6"></div>
                                    </div>
                                    <div class="modal-footer"><button class="btn btn-primary">Reset</button></div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada akun dosen.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($akun->hasPages())
            <div class="card-footer bg-white">{{ $akun->links() }}</div>
        @endif
    </div>

    {{-- Modal tambah akun --}}
    <div class="modal fade" id="mTambah" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('operator.akun-dosen.store') }}" class="modal-content">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Buat Akun Login Dosen</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">NIDN <span class="text-danger">*</span></label><input type="text" name="nidn" class="form-control" required value="{{ old('nidn') }}" maxlength="20"><small class="text-muted">Nomor Induk Dosen Nasional (tidak dipakai login).</small></div>
                    <div class="mb-2"><label class="form-label">Username <span class="text-danger">*</span></label><input type="text" name="username" class="form-control" required value="{{ old('username') }}" pattern="[A-Za-z0-9_\-]+"><small class="text-muted">Dipakai untuk login. Huruf/angka/_/-.</small></div>
                    <div class="mb-2"><label class="form-label">Nama Lengkap <span class="text-danger">*</span></label><input type="text" name="nama" class="form-control" required value="{{ old('nama') }}"></div>
                    <div class="mb-2"><label class="form-label">Email <span class="text-muted small">(opsional)</span></label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
                    <div class="mb-2"><label class="form-label">Password <span class="text-danger">*</span></label><input type="password" name="password" class="form-control" required minlength="6"></div>
                    <div class="mb-2"><label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label><input type="password" name="password_confirmation" class="form-control" required minlength="6"></div>
                    <div class="alert alert-info small mb-0"><i class="ri-information-line"></i> Data pribadi (NIDN, fakultas, prodi, dll) akan diisi sendiri oleh dosen setelah login pertama melalui menu Profil.</div>
                </div>
                <div class="modal-footer"><button class="btn btn-primary">Buat Akun</button></div>
            </form>
        </div>
    </div>
@endsection
