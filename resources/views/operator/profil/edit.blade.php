@extends('layouts.operator')

@section('title', 'Profil Operator')

@php $activeNav = 'profil'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Profil Operator</h4>
            <p class="text-muted small mb-0">Kelola akun dan password operator</p>
        </div>
    </div>

    <div class="row g-3">
        {{-- Info akun --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary-subtle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:96px;height:96px;">
                        <i class="ri-user-settings-line fs-1 text-primary"></i>
                    </div>
                    <h5 class="mb-1">{{ $user->username }}</h5>
                    <p class="text-muted small mb-2">{{ $user->email ?? '-' }}</p>
                    <span class="badge bg-primary mb-3">{{ strtoupper($user->role) }}</span>
                    <hr>
                    <table class="table table-sm mb-0 small">
                        <tr><td class="text-muted text-start">NIK</td><td class="text-start"><strong>{{ $user->nik }}</strong></td></tr>
                        <tr><td class="text-muted text-start">Status</td><td class="text-start">
                            @if ($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td></tr>
                        <tr><td class="text-muted text-start">Bergabung</td><td class="text-start">{{ $user->created_at->format('d M Y') }}</td></tr>
                        <tr><td class="text-muted text-start">Login Terakhir</td><td class="text-start">{{ $user->last_login_at?->format('d M Y H:i') ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Edit profil + password --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-edit-line me-2"></i>Edit Profil</h6></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('operator.profil.update') }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">NIK <span class="text-muted small">(tidak dapat diubah)</span></label>
                                <input type="text" class="form-control" value="{{ $user->nik }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" required class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username', $user->username) }}">
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-lock-password-line me-2"></i>Ubah Password</h6></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('operator.profil.password') }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" required class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password" required minlength="6" class="form-control @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Min 6 karakter.</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" required class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-warning"><i class="ri-lock-password-line me-1"></i> Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-history-line me-2"></i>Riwayat Aktivitas Terbaru</h6></div>
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light"><tr><th>#</th><th>Modul</th><th>Aktivitas</th><th>Deskripsi</th><th>Waktu</th></tr></thead>
                        <tbody>
                            @forelse ($recentActivity as $i => $log)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="small"><span class="badge bg-info-subtle text-info">{{ ucfirst($log->modul) }}</span></td>
                                    <td class="small">{{ $log->aktivitas }}</td>
                                    <td class="text-truncate small" style="max-width:300px;" title="{{ $log->deskripsi }}">{{ $log->deskripsi }}</td>
                                    <td class="small">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada aktivitas tercatat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
