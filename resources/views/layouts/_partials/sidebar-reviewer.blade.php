@php
    $active = $activeNav ?? '';

    $linkClass = function (string $key) use ($active) {
        return $active === $key ? 'sidebar-link active' : 'sidebar-link';
    };
@endphp

<aside class="hibah-sidebar bg-primary text-white p-0 d-flex flex-column" style="width:260px; min-height:100vh;">
    {{-- Brand --}}
    <div class="px-3 py-3 border-bottom border-white border-opacity-10 d-flex align-items-center gap-2">
        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
            <i class="ri-government-line text-primary fs-4"></i>
        </div>
        <div>
            <div class="fw-bold lh-1">UNIVERSITAS BATAM</div>
            <small class="text-white-50">Hibah Internal</small>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="flex-grow-1 overflow-auto p-2">
        <div class="text-white-50 small text-uppercase px-3 mt-2 mb-1">Menu Reviewer</div>

        <a href="{{ route('reviewer.dashboard') }}" class="{{ $linkClass('dashboard') }}">
            <i class="ri-home-line"></i><span>Dashboard</span>
        </a>
        <a href="#" class="{{ $linkClass('proposal') }}">
            <i class="ri-file-text-line"></i><span>Proposal Hibah</span>
        </a>
        <a href="#" class="{{ $linkClass('penilaian') }}">
            <i class="ri-clipboard-line"></i><span>Penilaian Proposal</span>
        </a>
        <a href="#" class="{{ $linkClass('hasil') }}">
            <i class="ri-file-list-3-line"></i><span>Hasil Review</span>
        </a>
        <a href="#" class="{{ $linkClass('jadwal') }}">
            <i class="ri-calendar-line"></i><span>Jadwal Review</span>
        </a>
        <a href="#" class="{{ $linkClass('profil') }}">
            <i class="ri-user-line"></i><span>Profil Reviewer</span>
        </a>

        <div class="border-top border-white border-opacity-10 my-3"></div>

        <a href="{{ route('dosen.dashboard') }}" class="sidebar-link text-warning-emphasis">
            <i class="ri-arrow-left-line"></i><span>Mode Dosen</span>
        </a>
    </nav>

    <div class="p-2 border-top border-white border-opacity-10">
        <a href="{{ route('logout') }}" class="sidebar-link text-white-50">
            <i class="ri-logout-box-line"></i><span>Keluar</span>
        </a>
    </div>
</aside>
