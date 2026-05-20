@php
    $active = $activeNav ?? '';

    // Helper: check active by prefix
    $is = fn($key) => str_starts_with($active, $key);

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
        <a href="{{ route('operator.dashboard') }}" class="{{ $linkClass('dashboard') }}">
            <i class="ri-home-line"></i><span>Dashboard</span>
        </a>

        <a href="#proposalMenu" data-bs-toggle="collapse" role="button"
            class="sidebar-link {{ $is('proposal') ? 'active' : '' }}">
            <i class="ri-file-text-line"></i><span class="flex-grow-1">Proposal Hibah</span>
            <i class="ri-arrow-down-s-line"></i>
        </a>
        <div class="collapse {{ $is('proposal') ? 'show' : '' }}" id="proposalMenu">
            <a href="{{ route('operator.proposal.index') }}" class="{{ $linkClass('proposal.data') }} ms-3">Data Proposal</a>
            <a href="{{ route('operator.proposal.index', ['status' => 'submitted']) }}" class="{{ $linkClass('proposal.verifikasi') }} ms-3">Verifikasi Proposal</a>
        </div>

        <a href="#reviewerMenu" data-bs-toggle="collapse" role="button"
            class="sidebar-link {{ $is('reviewer') ? 'active' : '' }}">
            <i class="ri-team-line"></i><span class="flex-grow-1">Reviewer</span>
            <i class="ri-arrow-down-s-line"></i>
        </a>
        <div class="collapse {{ $is('reviewer') ? 'show' : '' }}" id="reviewerMenu">
            <a href="{{ route('operator.reviewer.data') }}" class="{{ $linkClass('reviewer.data') }} ms-3">Data Reviewer</a>
            <a href="{{ route('operator.reviewer.penugasan') }}" class="{{ $linkClass('reviewer.penugasan') }} ms-3">Penugasan Reviewer</a>
            <a href="{{ route('operator.reviewer.monitoring') }}" class="{{ $linkClass('reviewer.monitoring') }} ms-3">Monitoring Reviewer</a>
        </div>

        <a href="{{ route('operator.penilaian.index') }}" class="{{ $linkClass('penilaian') }}">
            <i class="ri-checkbox-circle-line"></i><span>Penilaian</span>
        </a>
        <a href="{{ route('operator.jadwal.index') }}" class="{{ $linkClass('jadwal') }}">
            <i class="ri-calendar-line"></i><span>Jadwal</span>
        </a>
        <a href="{{ route('operator.laporan.index') }}" class="{{ $linkClass('laporan') }}">
            <i class="ri-file-list-3-line"></i><span>Verifikasi Laporan</span>
        </a>
        <a href="{{ route('operator.profil.edit') }}" class="{{ $linkClass('profil') }}">
            <i class="ri-user-line"></i><span>Profil Operator</span>
        </a>
    </nav>

    <div class="p-2 border-top border-white border-opacity-10">
        <a href="{{ route('logout') }}" class="sidebar-link text-white-50">
            <i class="ri-logout-box-line"></i><span>Keluar</span>
        </a>
    </div>
</aside>
