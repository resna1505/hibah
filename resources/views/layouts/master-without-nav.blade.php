<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Hybrix - Laravel 12 Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Hybrix Laravel Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
     <meta name="keywords" content="hybrix,hybrix laravel,admin,dashboard,vite,livewire,livewire admin,laravel vite">
     
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    <!-- include head css -->
    @include('layouts.head-css')

    @livewireStyles
</head>

<body>

    @yield('content')

    <!-- vendor-scripts -->
    @include('layouts.vendor-scripts')

    @livewireScripts
</body>

</html>

