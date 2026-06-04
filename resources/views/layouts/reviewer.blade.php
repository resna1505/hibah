<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Reviewer') | Hibah Internal UNIBA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')

    <style>
        body { background:#f5f6fa; }
        .hibah-sidebar .sidebar-link {
            display:flex; align-items:center; gap:.6rem;
            padding:.6rem .9rem;
            color: rgba(255,255,255,.75);
            text-decoration: none;
            border-radius: 6px;
            font-size: .9rem;
            margin-bottom: 2px;
        }
        .hibah-sidebar .sidebar-link:hover { background: rgba(255,255,255,.08); color:#fff; }
        .hibah-sidebar .sidebar-link.active { background: rgba(255,255,255,.15); color:#fff; font-weight:500; }
        .hibah-sidebar .sidebar-link i { width:18px; text-align:center; }

        .topbar { position: sticky; top: 0; z-index: 100; }
        .page-content { padding: 1.5rem 1.75rem; }
    </style>

    @livewireStyles
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <div class="hibah-sidebar-wrap d-none d-lg-block">
            @include('layouts._partials.sidebar-reviewer')
        </div>

        <div class="offcanvas offcanvas-start p-0" tabindex="-1" id="sidebarOffcanvas" style="width:260px;">
            <div class="offcanvas-body p-0">
                @include('layouts._partials.sidebar-reviewer')
            </div>
        </div>

        <main class="flex-grow-1 d-flex flex-column" style="min-height:100vh;">
            @include('layouts._partials.topbar-app')

            <div class="page-content flex-grow-1">
                @include('layouts._partials.flash-messages')
                @yield('content')
            </div>

            <footer class="text-center text-muted small py-3 border-top bg-white">
                &copy; {{ date('Y') }} LPPM Universitas Batam. Semua hak dilindungi.
            </footer>
        </main>
    </div>

    @include('layouts.vendor-scripts')
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
        });
    </script>
    @yield('scripts')
</body>
</html>
