@php
    $u = auth()->user();
    $dosen = $u->dosen;
    $active = $activeNav ?? 'dashboard';
    $is = fn($key) => $active === $key || str_starts_with($active, $key . '.');
@endphp

<nav class="navbar navbar-expand-lg bg-primary px-4 py-2 shadow-sm">
    <a class="navbar-brand text-white d-flex align-items-center gap-2" href="{{ route('dosen.dashboard') }}">
        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
            <i class="ri-government-line text-primary"></i>
        </div>
        <div>
            <div class="fw-bold lh-1" style="font-size:.9rem;">LPPM UNIVERSITAS BATAM</div>
            <small class="text-white-50" style="font-size:.65rem;">Hibah Internal</small>
        </div>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dosenMainNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="dosenMainNav">
        <ul class="navbar-nav ms-4 gap-2">
            <li class="nav-item">
                <a class="nav-link {{ $is('dashboard') ? 'text-white fw-bold' : 'text-white-50' }}"
                    href="{{ route('dosen.dashboard') }}">
                    <i class="ri-home-line me-1"></i>Dashboard
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ $is('penelitian') ? 'text-white fw-bold' : 'text-white-50' }}"
                    href="#" data-bs-toggle="dropdown">
                    <i class="ri-microscope-line me-1"></i>Penelitian
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('dosen.penelitian.index') }}"><i class="ri-add-line me-2"></i>Usulan Penelitian</a></li>
                    <li><small class="dropdown-item-text text-muted">Laporan diakses via Detail Proposal yang disetujui</small></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ $is('pengabdian') ? 'text-white fw-bold' : 'text-white-50' }}"
                    href="#" data-bs-toggle="dropdown">
                    <i class="ri-community-line me-1"></i>Pengabdian
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('dosen.pkm.index') }}"><i class="ri-add-line me-2"></i>Usulan PKM</a></li>
                    <li><small class="dropdown-item-text text-muted">Laporan diakses via Detail Proposal yang disetujui</small></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ $is('riwayat') ? 'text-white fw-bold' : 'text-white-50' }}"
                    href="#" data-bs-toggle="dropdown">
                    <i class="ri-history-line me-1"></i>Riwayat
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('dosen.riwayat.penelitian.index') }}">Riwayat Penelitian</a></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.riwayat.pkm.index') }}">Riwayat PKM</a></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.riwayat.hki.index') }}">Riwayat HKI</a></li>
                </ul>
            </li>
        </ul>

        @php
            $unread = \App\Models\Transaction\Notifikasi::where('user_id', $u->id)->whereNull('dibaca_at')->count();
        @endphp
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="{{ route('notifikasi.index') }}" class="text-white text-decoration-none position-relative me-2">
                <i class="ri-notification-3-line fs-5"></i>
                @if ($unread > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.6rem;">
                        {{ $unread > 9 ? '9+' : $unread }}
                    </span>
                @endif
            </a>
            @if ($dosen?->is_reviewer)
                <a href="{{ route('reviewer.dashboard') }}" class="btn btn-sm btn-warning">
                    <i class="ri-user-star-line me-1"></i>Mode Reviewer
                </a>
            @endif
            <div class="dropdown">
                <a class="text-white text-decoration-none dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" href="#">
                    @if ($dosen?->foto_path)
                        <img src="{{ asset('storage/' . $dosen->foto_path) }}" class="rounded-circle me-2" width="32" height="32" alt="" style="object-fit:cover;">
                    @else
                        <i class="ri-account-circle-line fs-3 me-2"></i>
                    @endif
                    <span class="small">{{ $dosen?->nama_lengkap ?? $u->nik }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('dosen.profil.edit') }}"><i class="ri-edit-line me-2"></i>Edit Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="ri-logout-box-line me-2"></i>Keluar</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
