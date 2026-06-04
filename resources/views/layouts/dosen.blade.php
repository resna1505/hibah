<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dosen') | Hibah Internal UNIBA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')

    <style>
        body { background:#f5f6fa; }
        .page-content { padding: 1.5rem 1.75rem; }
    </style>

    @livewireStyles
    @yield('styles')
</head>
<body class="d-flex flex-column" style="min-height:100vh;">
    @include('layouts._partials.dosen-navbar')

    <div class="page-content flex-grow-1">
        @include('layouts._partials.flash-messages')
        @yield('content')
    </div>

    <footer class="text-center text-muted small py-3 border-top bg-white">
        &copy; {{ date('Y') }} LPPM Universitas Batam. Semua hak dilindungi.
    </footer>

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
