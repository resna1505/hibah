@php
    $u = auth()->user();
    $dosen = $u->dosen ?? null;
    $unreadCount = \App\Models\Transaction\Notifikasi::where('user_id', $u->id)->whereNull('dibaca_at')->count();
@endphp

<header class="topbar bg-white border-bottom px-4 py-2 d-flex align-items-center justify-content-between">
    <button class="btn btn-sm btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
        <i class="ri-menu-line"></i>
    </button>

    <div class="flex-grow-1 d-none d-md-block"></div>

    <div class="d-flex align-items-center gap-3">
        {{-- Bell --}}
        <a href="{{ route('notifikasi.index') }}" class="btn btn-light position-relative text-decoration-none">
            <i class="ri-notification-3-line fs-5"></i>
            @if ($unreadCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.65rem;">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        </a>

        {{-- User dropdown --}}
        <div class="dropdown">
            <a class="text-decoration-none dropdown-toggle d-flex align-items-center text-dark" data-bs-toggle="dropdown" href="#" role="button">
                @if ($dosen?->foto_path)
                    <img src="{{ asset('storage/' . $dosen->foto_path) }}" class="rounded-circle me-2" width="32" height="32" alt="foto" style="object-fit:cover;">
                @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;">
                        <i class="ri-user-line text-muted"></i>
                    </div>
                @endif
                <div class="text-start d-none d-sm-block">
                    <div class="small fw-medium">{{ $dosen?->nama_lengkap ?? $u->username ?? $u->nik }}</div>
                    <div class="text-muted" style="font-size:.7rem;">{{ ucfirst($u->role) }}</div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                @if ($u->role === 'dosen')
                    <li><a class="dropdown-item" href="{{ route('dosen.profil.edit') }}"><i class="ri-edit-line me-2"></i>Edit Profil</a></li>
                    @if ($dosen?->is_reviewer)
                        <li><a class="dropdown-item" href="{{ route('reviewer.dashboard') }}"><i class="ri-user-star-line me-2"></i>Mode Reviewer</a></li>
                    @endif
                @endif
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="ri-logout-box-line me-2"></i>Keluar</a></li>
            </ul>
        </div>
    </div>
</header>
