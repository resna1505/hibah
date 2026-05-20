@php
    $user = auth()->user();
    $dosen = $user->dosen;
    $activeNav = $activeNav ?? 'dashboard';
@endphp

<nav class="navbar navbar-expand-lg bg-primary px-4 py-2">
    <div class="d-flex align-items-center text-white">
        <strong class="fs-5">LPPM UNIVERSITAS BATAM</strong>
        <span class="ms-2 text-white-50">Hibah Internal</span>
    </div>

    <ul class="navbar-nav flex-row ms-4 gap-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeNav === 'dashboard' ? 'text-white fw-bold' : 'text-white-50' }}"
                href="{{ route('dosen.dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ str_starts_with($activeNav, 'penelitian') ? 'text-white fw-bold' : 'text-white-50' }}"
                href="#" data-bs-toggle="dropdown">Penelitian</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Usulan Penelitian</a></li>
                <li><a class="dropdown-item" href="#">Laporan Penelitian</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ str_starts_with($activeNav, 'pengabdian') ? 'text-white fw-bold' : 'text-white-50' }}"
                href="#" data-bs-toggle="dropdown">Pengabdian</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Usulan PKM</a></li>
                <li><a class="dropdown-item" href="#">Laporan PKM</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ str_starts_with($activeNav, 'riwayat') ? 'text-white fw-bold' : 'text-white-50' }}"
                href="#" data-bs-toggle="dropdown">Riwayat</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('dosen.riwayat.penelitian.index') }}">Riwayat Penelitian</a></li>
                <li><a class="dropdown-item" href="{{ route('dosen.riwayat.pkm.index') }}">Riwayat PKM</a></li>
                <li><a class="dropdown-item" href="{{ route('dosen.riwayat.hki.index') }}">Riwayat HKI</a></li>
            </ul>
        </li>
    </ul>

    <div class="ms-auto d-flex align-items-center gap-3 text-white">
        <span class="badge bg-light text-primary">DOSEN</span>
        @if ($dosen?->is_reviewer)
            <a href="{{ route('reviewer.dashboard') }}" class="btn btn-sm btn-warning">Mode Reviewer</a>
        @endif
        <div class="dropdown">
            <a class="text-white text-decoration-none dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" href="#">
                @if ($dosen?->foto_path)
                    <img src="{{ asset('storage/' . $dosen->foto_path) }}" class="rounded-circle me-2" width="32" height="32" alt="foto">
                @else
                    <i class="ri-account-circle-line fs-3 me-2"></i>
                @endif
                <span class="small">{{ $dosen?->nama_lengkap ?? $user->nik }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('dosen.profil.edit') }}"><i class="ri-edit-line me-2"></i>Edit Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="ri-logout-box-line me-2"></i>Keluar</a></li>
            </ul>
        </div>
    </div>
</nav>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
        <i class="ri-checkbox-circle-line me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3 mb-0" role="alert">
        <i class="ri-error-warning-line me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
