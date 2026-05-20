@extends('layouts.master')
@section('title')
    @lang('translation.widgets')
@endsection
@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Hybrix
        @endslot
        @slot('title')
            Widgets
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <h5 class="text-decoration-underline mb-3 pb-1">Tile Boxs</h5>
        </div>
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Total Earnings</p>
                            <h4 class="fs-22 fw-semibold mb-3">$<span class="counter-value" data-target="745.35">0</span>
                            </h4>
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="text-success fs-12 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +18.30 %
                                </h5>
                                <p class="text-muted mb-0">than last week</p>
                            </div>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-dollar-circle text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="animation-effect-6 text-success opacity-25">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="animation-effect-4 text-success opacity-25">
                    <i class="bi bi-currency-pound"></i>
                </div>
                <div class="animation-effect-3 text-success opacity-25">
                    <i class="bi bi-currency-euro"></i>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-shopping-bag text-info"></i>
                            </span>
                        </div>
                        <div class="text-end flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Orders</p>
                            <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" data-target="698.36">0</span>k
                            </h4>
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <h5 class="text-danger fs-12 mb-0">
                                    <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -2.74 %
                                </h5>
                                <p class="text-muted mb-0">than last week</p>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="animation-effect-6 text-info opacity-25 left">
                    <i class="bi bi-handbag"></i>
                </div>
                <div class="animation-effect-4 text-info opacity-25 left">
                    <i class="bi bi-shop"></i>
                </div>
                <div class="animation-effect-3 text-info opacity-25 left">
                    <i class="bi bi-bag-check"></i>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Customers</p>
                            <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" data-target="195.38">0</span>M
                            </h4>
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="text-success fs-12 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                </h5>
                                <p class="text-muted mb-0">than last week</p>
                            </div>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-user-circle text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="animation-effect-6 text-warning opacity-25">
                    <i class="bi bi-person"></i>
                </div>
                <div class="animation-effect-4 text-warning opacity-25">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="animation-effect-3 text-warning opacity-25">
                    <i class="bi bi-people"></i>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                <i class="bx bx-wallet text-primary"></i>
                            </span>
                        </div>
                        <div class="text-end flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">MY BALANCE</p>
                            <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" data-target="190.73">0</span>k
                            </h4>
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <h5 class="text-danger fs-12 mb-0">
                                    <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -2.74 %
                                </h5>
                                <p class="text-muted mb-0">than last week</p>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="animation-effect-6 text-info opacity-25 left">
                    <i class="bi bi-handbag"></i>
                </div>
                <div class="animation-effect-4 text-info opacity-25 left">
                    <i class="bi bi-shop"></i>
                </div>
                <div class="animation-effect-3 text-info opacity-25 left">
                    <i class="bi bi-bag-check"></i>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0 fs-13">Total Earnings</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold mb-4">$<span class="counter-value"
                                    data-target="559.25">0</span>k</h4>
                            <a href="" class="text-decoration-underline">View net earnings</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-dollar-circle text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate bg-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-white-50 mb-0 fs-13">Orders</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-warning fs-14 mb-0">
                                <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold mb-4 text-white"><span class="counter-value"
                                    data-target="36894">0</span></h4>
                            <a href="" class="text-decoration-underline text-white-50">View all orders</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded fs-3">
                                <i class="bx bx-shopping-bag text-white"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0 fs-13">Customers</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold mb-4"><span class="counter-value" data-target="183.35">0</span>M
                            </h4>
                            <a href="" class="text-decoration-underline">See details</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-user-circle text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0 fs-13">My Balance</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-muted fs-14 mb-0">
                                +0.00 %
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold mb-4">$<span class="counter-value"
                                    data-target="190.73">0</span>k</h4>
                            <a href="" class="text-decoration-underline">Withdraw money</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                <i class="bx bx-wallet text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div> <!-- end row-->

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success card-height-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary text-white rounded-2 fs-2">
                                <i class="bx bx-shopping-bag"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-medium text-white-75 mb-3 fs-13">Total Sales</p>
                            <h4 class="fs-4 mb-3 text-white"><span class="counter-value" data-target="2045">0</span></h4>
                            <p class="text-white-75 mb-0">From 1930 last year</p>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <span class="badge text-dark-emphasis bg-light-subtle fs-12"><i
                                    class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>6.11 %<span></span></span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div> <!-- end col-->

        <div class="col-xl-3 col-md-6">
            <div class="card card-height-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-2 fs-2">
                                <i class="bx bxs-user-account"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3 fs-13">Number of Users</p>
                            <h4 class="fs-4 mb-3"><span class="counter-value" data-target="7522">0</span></h4>
                            <p class="text-muted mb-0">From 9530 last year</p>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <span class="badge text-danger  bg-danger-subtle fs-12"><i
                                    class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>10.35 %<span></span></span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div> <!-- end col-->

        <div class="col-xl-3 col-md-6">
            <div class="card card-height-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-danger-subtle text-danger rounded-2 fs-2">
                                <i class="bx bxs-badge-dollar"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3 fs-13">Total Revenue</p>
                            <h4 class="fs-4 mb-3">$<span class="counter-value" data-target="2845.05">0</span></h4>
                            <p class="text-muted mb-0">From $1,750.04 last year</p>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <span class="badge text-success  bg-success-subtle fs-12"><i
                                    class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>22.96 %<span></span></span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div> <!-- end col-->

        <div class="col-xl-3 col-md-6">
            <div class="card card-height-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded-2 fs-2">
                                <i class="bx bx-store-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3 fs-13">Number of Stores</p>
                            <h4 class="fs-4 mb-3"><span class="counter-value" data-target="405">0</span>k</h4>
                            <p class="text-muted mb-0">From 308 last year</p>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <span class="badge text-success  bg-success-subtle fs-12"><i
                                    class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>16.31 %<span></span></span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div> <!-- end col-->
    </div> <!-- end row-->

    <div class="row">
        <div class="col-12">
            <h5 class="text-decoration-underline mb-3 mt-2 pb-3">Other Widgets</h5>
        </div>
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card bg-info-subtle text-info border-0">
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-sm">
                            <h5 class="card-title fs-17">Need More Sales?</h5>
                            <p class="mb-0">Upgrade to pro for added benefits.</p>
                        </div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-info btn-label rounded-pill"><i
                                    class="ri-markup-line label-icon align-middle rounded-pill fs-16 me-2"></i> Go Pro
                                Now</button>
                        </div>
                    </div>
                    <div class="position-absolute top-0 start-50 mt-2 opacity-25">
                        <i class="bi bi-shop display-4"></i>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="col-lg-6 col-12">
            <div class="card card-primary border-0">
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-sm">
                            <h5 class="card-title fs-17">Need More Sales?</h5>
                            <p class="mb-0">Upgrade to pro for added benefits.</p>
                        </div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-darken-primary btn-label rounded-pill"><i
                                    class="ri-markup-line label-icon align-middle rounded-pill fs-16 me-2"></i> Go Pro
                                Now</button>
                        </div>
                    </div>
                    <div class="position-absolute top-0 start-50 mt-2 opacity-25">
                        <i class="bi bi-shop display-4"></i>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fs-15 fw-semibold">Brand Logo Design - MD</h5>
                    <p class="text-muted">Graphics Work</p>
                    <div class="d-flex flex-wrap justify-content-evenly">
                        <p class="text-muted mb-0">
                            <i class="mdi mdi-numeric-1-circle text-success fs-18 align-middle me-2"></i>Completed
                        </p>
                        <p class="text-muted mb-0">
                            <i class="mdi mdi-numeric-3-circle text-info fs-18 align-middle me-2"></i>In Progress
                        </p>
                        <p class="text-muted mb-0"><i
                                class="mdi mdi-numeric-2-circle text-primary fs-18 align-middle me-2"></i>To Do</p>
                    </div>
                </div>
                <div class="progress animated-progress rounded-bottom rounded-0" style="height: 6px;">
                    <div class="progress-bar bg-success rounded-0" role="progressbar" style="width: 30%"
                        aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-info rounded-0" role="progressbar" style="width: 50%" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar rounded-0" role="progressbar" style="width: 20%" aria-valuenow="20"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div><!-- end col -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fs-15 fw-semibold">Redesign - Landing Page</h5>
                    <p class="text-muted">UI/UX Design</p>
                    <div class="d-flex flex-wrap justify-content-evenly">
                        <p class="text-muted mb-0">
                            <i class="mdi mdi-numeric-3-circle text-success fs-18 align-middle me-2"></i>Completed
                        </p>
                        <p class="text-muted mb-0"><i
                                class="mdi mdi-numeric-0-circle text-info fs-18 align-middle me-2"></i>In Progress</p>
                        <p class="text-muted mb-0"><i
                                class="mdi mdi-numeric-8-circle text-primary fs-18 align-middle me-2"></i>To Do</p>
                    </div>
                </div>
                <div class="progress animated-progress rounded-bottom rounded-0" style="height: 6px;">
                    <div class="progress-bar bg-success rounded-0" role="progressbar" style="width: 30%"
                        aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-info rounded-0" role="progressbar" style="width: 0%" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar rounded-0" role="progressbar" style="width: 70%" aria-valuenow="70"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div><!-- end col -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fs-15 fw-semibold">Ecommerce App for Web</h5>
                    <p class="text-muted">CRM Project</p>
                    <div class="d-flex flex-wrap justify-content-evenly">
                        <p class="text-muted mb-0">
                            <i class="mdi mdi-numeric-10-circle text-success fs-18 align-middle me-2"></i>Completed
                        </p>
                        <p class="text-muted mb-0"><i
                                class="mdi mdi-numeric-3-circle text-info fs-18 align-middle me-2"></i>In Progress</p>
                        <p class="text-muted mb-0"><i
                                class="mdi mdi-numeric-2-circle text-primary fs-18 align-middle me-2"></i>To Do</p>
                    </div>
                </div>
                <div class="progress animated-progress rounded-bottom rounded-0" style="height: 6px;">
                    <div class="progress-bar bg-success rounded-0" role="progressbar" style="width: 60%"
                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-info rounded-0" role="progressbar" style="width: 25%" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar rounded-0" role="progressbar" style="width: 15%" aria-valuenow="15"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div><!-- end col -->
    </div> <!-- end row-->

    <div class="row">
        <div class="col-xxl-4">
            <div class="card card-height-100">
                <div class="card-header d-flex">
                    <h5 class="card-title flex-grow-1 mb-0">Income Details</h5>
                    <div class="flex-shrink-0">
                        <div class="dropdown">
                            <a href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill fs-14"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <h6 class="fs-15 mb-1">$380.50</h6>
                    <p class="text-muted fs-12 mb-0">Total Income</p>
                </div>
                <div>
                    <div id="area_chart_basic" data-colors='["--tb-success"]' class="apex-charts" dir="ltr"></div>
                </div>
                <div class="border-top border-top-dashed">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="card-body text-center border-end border-end-dashed">
                                <h5 class="fs-13 mb-1">$324.00</h5>
                                <p class="mb-0 fs-11 text-muted">Total Sales</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body text-center border-end border-end-dashed">
                                <h5 class="fs-13 mb-1">$250.00</h5>
                                <p class="mb-0 fs-11 text-muted">Spendings</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body text-center">
                                <h5 class="fs-13 mb-1">$380.50</h5>
                                <p class="mb-0 fs-11 text-muted">Income</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card card-height-100">
                <div class="card-header d-flex">
                    <h5 class="card-title flex-grow-1 mb-0">Income Breakdown</h5>
                    <div class="flex-shrink-0">
                        <div class="dropdown">
                            <a href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill fs-14"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="widgets-piechart pt-3 pb-2">
                        <div id="simple_dount_chart"
                            data-colors='["--tb-info", "--tb-danger", "--tb-warning", "--tb-success"]' class="apex-charts"
                            dir="ltr"></div>
                    </div>
                </div>
                <div class="border-top border-top-dashed">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <div class="card-body border-end border-end-dashed d-flex">
                                <div class="me-2 text-info fs-16"><i class="ri-record-circle-fill"></i></div>
                                <div>
                                    <h5 class="fs-13 mb-1">Marketing Channels</h5>
                                    <p class="mb-0 fs-11 text-muted">$22.0k</p>
                                </div>

                            </div>
                            <div class="card-body border-end border-end-dashed d-flex">
                                <div class="me-2 text-warning fs-16"><i class="ri-record-circle-fill"></i></div>
                                <div>
                                    <h5 class="fs-13 mb-1">Direct Sales</h5>
                                    <p class="mb-0 fs-11 text-muted">$8.4k</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body d-flex">
                                <div class="me-2 text-danger fs-16"><i class="ri-record-circle-fill"></i></div>
                                <div>
                                    <h5 class="fs-13 mb-1">Offline Channels</h5>
                                    <p class="mb-0 fs-11 text-muted">$18.6k</p>
                                </div>

                            </div>
                            <div class="card-body d-flex">
                                <div class="me-2 text-success fs-16"><i class="ri-record-circle-fill"></i></div>
                                <div>
                                    <h5 class="fs-13 mb-1">Other Channels</h5>
                                    <p class="mb-0 fs-11 text-muted">$15.3k</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card card-height-100">
                <div class="card-header d-flex">
                    <h5 class="card-title flex-grow-1 mb-0">Latest Sales</h5>
                    <div class="flex-shrink-0">
                        <div class="dropdown">
                            <a href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill fs-14"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col">Email<i class="ri-arrow-up-down-line align-middle ms-2"></i></th>
                                    <th scope="col">Price<i class="ri-arrow-up-down-line align-middle ms-2"></i></th>
                                    <th scope="col">Tag<i class="ri-arrow-up-down-line align-middle ms-2"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>jordan.martino@hybrix.com</td>
                                    <td>$1.95</td>
                                    <td><a href="#" class="badge text-success  bg-success-subtle">Paid</a></td>
                                </tr>
                                <tr>
                                    <td>nancy.martino@hybrix.com</td>
                                    <td>$5.00</td>
                                    <td><a href="#" class="badge text-warning bg-warning-subtle">Pending</a></td>
                                </tr>
                                <tr>
                                    <td>pieter.novitsky@hybrix.com</td>
                                    <td>$2.05</td>
                                    <td><a href="#" class="badge text-success  bg-success-subtle">Paid</a></td>
                                </tr>
                                <tr>
                                    <td>Ashley@hybrix.com</td>
                                    <td>$69.99</td>
                                    <td><a href="#" class="badge text-danger  bg-danger-subtle">Cancelled</a></td>
                                </tr>
                                <tr>
                                    <td>Heather@hybrix.com</td>
                                    <td>$16.78</td>
                                    <td><a href="#" class="badge text-danger  bg-danger-subtle">Cancelled</a></td>
                                </tr>
                                <tr>
                                    <td>Jimenez@hybrix.com</td>
                                    <td>$79.99</td>
                                    <td><a href="#" class="badge text-success  bg-success-subtle">Paid</a></td>
                                </tr>
                                <tr>
                                    <td>Daniel@hybrix.com</td>
                                    <td>$87.00</td>
                                    <td><a href="#" class="badge text-warning bg-warning-subtle">Pending</a></td>
                                </tr>
                                <tr>
                                    <td>Scott@hybrix.com</td>
                                    <td>$42.32</td>
                                    <td><a href="#" class="badge text-danger  bg-danger-subtle">Cancelled</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ul class="pagination pagination-separated mb-0 mt-4 pt-1 justify-content-end">
                        <li class="page-item disabled">
                            <a href="#" class="page-link">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a href="#" class="page-link">1</a>
                        </li>
                        <li class="page-item ">
                            <a href="#" class="page-link">2</a>
                        </li>
                        <li class="page-item">
                            <a href="#" class="page-link">3</a>
                        </li>
                        <li class="page-item">
                            <a href="#" class="page-link">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-5">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Upcoming Activities</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Remove</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body pt-0">
                    <ul class="list-group list-group-flush border-dashed">
                        <li class="list-group-item ps-0">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                        <div class="text-center">
                                            <h5 class="mb-0">25</h5>
                                            <div class="text-muted">Tue</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="text-muted mt-0 mb-1 fs-13">12:00am - 03:30pm</h5>
                                    <a href="#" class="text-reset fs-14 mb-0">Meeting for campaign with sales
                                        team</a>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="avatar-group">
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Stine Nielsen">
                                                <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Jansh Brown">
                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Dan Gibson">
                                                <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);">
                                                <div class="avatar-xxs">
                                                    <span class="avatar-title rounded-circle bg-info text-white">
                                                        5
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </li><!-- end -->
                        <li class="list-group-item ps-0">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                        <div class="text-center">
                                            <h5 class="mb-0">20</h5>
                                            <div class="text-muted">Wed</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="text-muted mt-0 mb-1 fs-13">02:00pm - 03:45pm</h5>
                                    <a href="#" class="text-reset fs-14 mb-0">Adding a new event with
                                        attachments</a>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="avatar-group">
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Frida Bang">
                                                <img src="{{ URL::asset('build/images/users/avatar-4.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Malou Silva">
                                                <img src="{{ URL::asset('build/images/users/avatar-5.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Simon Schmidt">
                                                <img src="{{ URL::asset('build/images/users/avatar-6.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Tosh Jessen">
                                                <img src="{{ URL::asset('build/images/users/avatar-7.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);">
                                                <div class="avatar-xxs">
                                                    <span class="avatar-title rounded-circle bg-success text-white">
                                                        3
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </li><!-- end -->
                        <li class="list-group-item ps-0">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                        <div class="text-center">
                                            <h5 class="mb-0">17</h5>
                                            <div class="text-muted">Wed</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="text-muted mt-0 mb-1 fs-13">04:30pm - 07:15pm</h5>
                                    <a href="#" class="text-reset fs-14 mb-0">Create new project Bundling
                                        Product</a>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="avatar-group">
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Nina Schmidt">
                                                <img src="{{ URL::asset('build/images/users/avatar-8.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Stine Nielsen">
                                                <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Jansh Brown">
                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);">
                                                <div class="avatar-xxs">
                                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                                        4
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </li><!-- end -->
                        <li class="list-group-item ps-0">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                        <div class="text-center">
                                            <h5 class="mb-0">12</h5>
                                            <div class="text-muted">Tue</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="text-muted mt-0 mb-1 fs-13">10:30am - 01:15pm</h5>
                                    <a href="#" class="text-reset fs-14 mb-0">Weekly closed sales won checking with
                                        sales team</a>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="avatar-group">
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Stine Nielsen">
                                                <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Jansh Brown">
                                                <img src="{{ URL::asset('build/images/users/avatar-5.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Dan Gibson">
                                                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt=""
                                                    class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);">
                                                <div class="avatar-xxs">
                                                    <span class="avatar-title rounded-circle bg-warning text-white">
                                                        9
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </li><!-- end -->
                    </ul><!-- end -->
                    <div class="align-items-center mt-2 row text-center text-sm-start">
                        <div class="col-sm">
                            <div class="text-muted">Showing<span class="fw-semibold">4</span> of <span
                                    class="fw-semibold">125</span> Results</div>
                        </div>
                        <div class="col-sm-auto">
                            <ul
                                class="pagination pagination-separated pagination-sm justify-content-center justify-content-sm-start mb-0">
                                <li class="page-item disabled">
                                    <a href="#" class="page-link">←</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">1</a>
                                </li>
                                <li class="page-item active">
                                    <a href="#" class="page-link">2</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">3</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">→</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div> <!-- end col-->
        <div class="col-xxl-7 card-height-100">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Connections</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ri-more-2-fill fs-14"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                        <li><a class="dropdown-item" href="#">View</a></li>
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="d-flex align-items-center pb-3">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}" alt=""
                                            class="img-fluid rounded-circle" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h6 class="mb-1">Esther James</h6>
                                            <p class="fs-12 text-muted mb-0">475 Connections</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <button type="button" class="btn btn-sm btn-outline-info custom-toggle active"
                                            data-bs-toggle="button" aria-pressed="true">
                                            <span class="icon-on"><i class="ri-user-follow-line align-bottom me-1"></i>
                                                Follow</span>
                                            <span class="icon-off"><i class="ri-user-unfollow-line align-bottom me-1"></i>
                                                Unfollow</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center py-3">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt=""
                                            class="img-fluid rounded-circle" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h6 class="mb-1">George Whalen</h6>
                                            <p class="fs-12 text-muted mb-0">Backend Developer</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <button type="button" class="btn btn-sm btn-outline-info custom-toggle"
                                            data-bs-toggle="button" aria-pressed="true">
                                            <span class="icon-on"><i class="ri-user-follow-line align-bottom me-1"></i>
                                                Follow</span>
                                            <span class="icon-off"><i class="ri-user-unfollow-line align-bottom me-1"></i>
                                                Unfollow</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center py-3">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        <img src="{{ URL::asset('build/images/users/avatar-8.jpg') }}" alt=""
                                            class="img-fluid rounded-circle" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h6 class="mb-1">Daniel Gonzalez</h6>
                                            <p class="fs-12 text-muted mb-0">React JS Developer</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <button type="button" class="btn btn-sm btn-outline-info custom-toggle"
                                            data-bs-toggle="button" aria-pressed="true">
                                            <span class="icon-on"><i class="ri-user-follow-line align-bottom me-1"></i>
                                                Follow</span>
                                            <span class="icon-off"><i class="ri-user-unfollow-line align-bottom me-1"></i>
                                                Unfollow</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center py-3">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        <img src="{{ URL::asset('build/images/users/avatar-9.jpg') }}" alt=""
                                            class="img-fluid rounded-circle" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h6 class="mb-1">Scott Wilson</h6>
                                            <p class="fs-12 text-muted mb-0">Full Stack Developer</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <button type="button" class="btn btn-sm btn-outline-info custom-toggle"
                                            data-bs-toggle="button" aria-pressed="true">
                                            <span class="icon-on"><i class="ri-user-follow-line align-bottom me-1"></i>
                                                Follow</span>
                                            <span class="icon-off"><i class="ri-user-unfollow-line align-bottom me-1"></i>
                                                Unfollow</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                        <div class="card-footer text-center">
                            <a href="#!" class="link-secondar">View All Connections <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">Activity Stream</h5>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-soft-primary btn-sm">
                                    View All Activity
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div data-simplebar style="max-height: 330px;" class="p-3 pt-0">
                                <ul class="acitivity-timeline-2 list-unstyled mb-0">
                                    <li>
                                        <h6 class="fs-14">Purchase by James Price</h6>
                                        <p>09:24 PM</p>
                                        <p class="mb-0">Product noise evolve smartwatch</p>
                                    </li>
                                    <li>
                                        <h6 class="fs-14">New ticket received <span
                                                class="badge text-bg-info align-middle ms-1">New</span></h6>
                                        <p class="mb-3">4 days ago</p>
                                        <p class="text-muted mb-0">User <span class="text-secondary">Erica245</span>
                                            submitted a ticket</p>
                                    </li>
                                    <li>
                                        <h6 class="fs-14">Adding a new event with attachments</h6>
                                        <p class="mb-3">30 days ago</p>
                                        <div class="row g-3">
                                            <div class="col-auto">
                                                <div
                                                    class="d-flex position-relative gap-2 border border-dashed p-2 rounded-3">
                                                    <div class="flex-shrink-0">
                                                        <i class="bi bi-file-earmark-image fs-17 text-danger"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <a href="javascript:void(0);" class="stretched-link">
                                                            <h6 class="mb-1 fs-12">UI/UX design</h6>
                                                        </a>
                                                        <small class="text-muted">685 KB</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div
                                                    class="d-flex position-relative gap-2 border border-dashed p-2 rounded-3">
                                                    <div class="flex-shrink-0">
                                                        <i class="bi bi-file-pdf fs-17 text-info"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <a href="javascript:void(0);" class="stretched-link">
                                                            <h6 class="mb-1 fs-12">Hybrix Invoice</h6>
                                                        </a>
                                                        <small class="text-muted">342 KB</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h6 class="fs-14">Templates layout upload</h6>
                                        <p class="mb-3">1 week ago</p>
                                        <p class="text-muted fst-italic">
                                            Powerful, clean & modern responsive bootstrap 5 admin template. The maximum file
                                            size for uploads in this demo :
                                        </p>
                                        <div class="row mt-2">
                                            <div class="col-xxl-10">
                                                <div class="row border border-dashed gx-2 p-2">
                                                    <div class="col-3">
                                                        <img src="{{ URL::asset('build/images/small/img-3.jpg') }}" alt=""
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-3">
                                                        <img src="{{ URL::asset('build/images/small/img-5.jpg') }}" alt=""
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-3">
                                                        <img src="{{ URL::asset('build/images/small/img-7.jpg') }}" alt=""
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-3">
                                                        <img src="{{ URL::asset('build/images/small/img-9.jpg') }}" alt=""
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="time">01:30 PM</div>
                                        <p>Lunch time after which sleep just doesn't want to let go of me. 🤝</p>
                                    </li>
                                    <li>
                                        <div class="time">3:30 PM</div>
                                        <p>Drink the magical chai, it will ward off sleep they said. 🤷‍</p>
                                    </li>
                                    <li>
                                        <div class="time">4:30 PM </div>
                                        <p>The only time I don't feel sleepy cause it's work out time. I mean walking time.
                                            😹</p>
                                    </li>
                                    <li>
                                        <div class="time">07:00 PM </div>
                                        <p>Food my tummy needs, sleep my body needs.👿</p>
                                    </li>
                                    <li>
                                        <div class="time">07:30 PM </div>
                                        <p>My tummy's happy time 🍝</p>
                                    </li>
                                    <li>
                                        <div class="time">10:00 PM </div>
                                        <p>uh oh!!! fuel low, get some snacks but wait should I just take a quick nap?🤓
                                        </p>
                                    </li>
                                    <li>
                                        <div class="time">2:30 PM </div>
                                        <p>All hail! The time to sleep has finally arrived.😴😴😴😴😴 </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    <div class="row">
        <div class="col-12">
            <h5 class="text-decoration-underline mb-3 mt-2 pb-3">Chart & Map Widgets</h5>
        </div>
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-xxl-4 col-xl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Live Users By Country</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            Export Report
                        </button>
                    </div>
                </div><!-- end card header -->

                <!-- card body -->
                <div class="card-body">

                    <div id="users-by-country" data-colors='["--tb-light"]' style="height: 252px"></div>

                    <div
                        class="table-responsive table-card mt-4 pt-2 border-top-dashed border-top border-start-0 border-end-0 bg-light-subtle">
                        <table class="table table-borderless table-sm table-centered align-middle table-nowrap mt-3">
                            <thead class="text-muted">
                                <tr>
                                    <th>Parameters</th>
                                    <th>Today</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Percent</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                <tr>
                                    <th>Duration (Secs)</th>
                                    <td>0-30</td>
                                    <td>35000</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" role="progressbar" aria-label="Basic example"
                                                style="width: 73%" aria-valuenow="73" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>73</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Sessions</th>
                                    <td>250</td>
                                    <td>2,750</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                aria-label="Basic example" style="width: 90%" aria-valuenow="90"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>90</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Views</th>
                                    <td>180</td>
                                    <td>4,950</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                aria-label="Basic example" style="width: 87%" aria-valuenow="87"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>87</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">User</th>
                                    <td>120</td>
                                    <td>3,010</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                aria-label="Basic example" style="width: 36%" aria-valuenow="36"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>36</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xxl-4 col-xl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Sessions by Countries</h4>
                    <div>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            ALL
                        </button>
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            1M
                        </button>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            6M
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div>
                        <div id="countries_charts"
                            data-colors='["--tb-info", "--tb-info", "--tb-info", "--tb-info", "--tb-danger", "--tb-info", "--tb-info", "--tb-info", "--tb-info", "--tb-info"]'
                            class="apex-charts" dir="ltr"></div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div> <!-- end col-->

        <div class="col-xxl-4">
            <div class="card card-height-100">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Audiences Metrics</h4>
                    <div>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            ALL
                        </button>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            1M
                        </button>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            6M
                        </button>
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            1Y
                        </button>
                    </div>
                </div><!-- end card header -->
                <div class="card-header p-0">
                    <div class="alert alert-warning alert-solid alert-label-icon border-0 rounded-0 m-0 d-flex align-items-center"
                        role="alert">
                        <i class="ri-error-warning-line label-icon"></i>
                        <div class="flex-grow-1 text-truncate">
                            Your free trial expired in <b>17</b> days.
                        </div>
                        <div class="flex-shrink-0">
                            <a href="pages-pricing" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                        </div>
                    </div>
                </div>
                <div class="card-header p-0 border-0 bg-light-subtle">
                    <div class="row g-0 text-center">
                        <div class="col-6 col-sm-4">
                            <div class="p-3 border border-dashed border-start-0">
                                <h5 class="mb-1"><span class="counter-value" data-target="854">0</span>
                                    <span class="text-success ms-1 fs-12">49%<i
                                            class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                </h5>
                                <p class="text-muted mb-0">Avg.Earning</p>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-6 col-sm-4">
                            <div class="p-3 border border-dashed border-start-0">
                                <h5 class="mb-1"><span class="counter-value" data-target="1278">0</span>
                                    <span class="text-success ms-1 fs-12">60%<i
                                            class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                </h5>
                                <p class="text-muted mb-0">Total Conversation</p>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-6 col-sm-4">
                            <div class="p-3 border border-dashed border-start-0 border-end-0">
                                <h5 class="mb-1"><span class="counter-value" data-target="3">0</span>m
                                    <span class="counter-value" data-target="40">0</span>sec
                                </h5>
                                <p class="text-muted mb-0">Total Order</p>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div><!-- end card header -->

                <div class="card-body p-0 pb-2">
                    <div>
                        <div id="column_stacked" data-colors='["--tb-primary", "--tb-danger"]' class="apex-charts"
                            dir="ltr"></div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

    </div> <!-- end row-->

    <div class="row">
        <div class="col-xxl-4 col-xl-6">
            <!-- card -->
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Sales by Locations</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            Export Report
                        </button>
                    </div>
                </div><!-- end card header -->

                <!-- card body -->
                <div class="card-body">

                    <div id="sales-by-locations" data-colors='["--tb-light"]' style="height: 269px">
                    </div>

                    <div class="px-2 py-2 mt-1">
                        <p class="mb-1">New Maxico <span class="float-end">75%</span></p>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="75"></div>
                        </div>

                        <p class="mt-3 mb-1">California <span class="float-end">47%</span></p>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                style="width: 47%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="47"></div>
                        </div>

                        <p class="mt-3 mb-1">Texas <span class="float-end">82%</span></p>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="82"></div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xxl-4 col-xl-6">
            <div class="card card-height-100">
                <div class="card-header border-bottom-dashed align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">My Portfolio</h4>
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-soft-primary btn-sm" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="text-uppercase">Btc<i
                                        class="mdi mdi-chevron-down align-middle ms-1"></i></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">BTC</a>
                                <a class="dropdown-item" href="#">USD</a>
                                <a class="dropdown-item" href="#">Euro</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardheader -->
                <div class="card-body">
                    <div id="portfolio_donut_charts"
                        data-colors='["--tb-primary", "--tb-info", "--tb-warning", "--tb-success"]' class="apex-charts"
                        dir="ltr"></div>

                    <ul class="list-group list-group-flush border-dashed mb-0">
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <span class="avatar-title bg-light p-1 rounded-circle">
                                        <img src="{{ URL::asset('build/images/svg/crypto-icons/btc.svg') }}" class="img-fluid"
                                            alt="">
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-1">Bitcoin</h6>
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-primary me-1"></i>BTC
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mb-1">BTC 0.00584875</h6>
                                    <p class="text-success fs-12 mb-0">$19,405.12</p>
                                </div>
                            </div>
                        </li><!-- end -->
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <span class="avatar-title bg-light p-1 rounded-circle">
                                        <img src="{{ URL::asset('build/images/svg/crypto-icons/eth.svg') }}" class="img-fluid"
                                            alt="">
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-1">Ethereum</h6>
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-info me-1"></i>ETH
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mb-1">ETH 2.25842108</h6>
                                    <p class="text-danger fs-12 mb-0">$40552.18</p>
                                </div>
                            </div>
                        </li><!-- end -->
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <span class="avatar-title bg-light p-1 rounded-circle">
                                        <img src="{{ URL::asset('build/images/svg/crypto-icons/ltc.svg') }}" class="img-fluid"
                                            alt="">
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-1">Litecoin</h6>
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-warning me-1"></i>LTC
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mb-1">LTC 10.58963217</h6>
                                    <p class="text-success fs-12 mb-0">$15824.58</p>
                                </div>
                            </div>
                        </li><!-- end -->
                        <li class="list-group-item px-0 pb-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <span class="avatar-title bg-light p-1 rounded-circle">
                                        <img src="{{ URL::asset('build/images/svg/crypto-icons/dash.svg') }}" class="img-fluid"
                                            alt="">
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-1">Dash</h6>
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-success me-1"></i>DASH
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mb-1">DASH 204.28565885</h6>
                                    <p class="text-success fs-12 mb-0">$30635.84</p>
                                </div>
                            </div>
                        </li><!-- end -->
                    </ul><!-- end -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xxl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Top Referrals Pages</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            Export Report
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <div id="color_heatmap"
                        data-colors='["--tb-success", "--tb-info", "--tb-primary", "--tb-warning", "--tb-secondary"]'
                        class="apex-charts mt-n3" dir="ltr"></div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0">
                                        <i class="mdi mdi-circle align-middle text-primary me-2"></i>www.google.com
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">24.58%</p>
                                </div>
                            </div><!-- end -->
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0">
                                        <i class="mdi mdi-circle align-middle text-warning me-2"></i>www.medium.com
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">12.22%</p>
                                </div>
                            </div><!-- end -->
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0">
                                        <i class="mdi mdi-circle align-middle text-secondary me-2"></i>Other
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">17.58%</p>
                                </div>
                            </div><!-- end -->
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0">
                                        <i class="mdi mdi-circle align-middle text-info me-2"></i>www.youtube.com
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">17.51%</p>
                                </div>
                            </div><!-- end -->
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0">
                                        <i class="mdi mdi-circle align-middle text-success me-2"></i>www.meta.com
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">23.05%</p>
                                </div>
                            </div><!-- end -->
                        </div>
                    </div>

                    <div class="mt-2 text-center">
                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">Show All</a>
                    </div>

                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->

    </div>
    <!-- end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- for basic area chart -->
    <script src="https://img.themesbrand.com/velzon/apexchart-js/stock-prices.js"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ URL::asset('build/js/maps/us-merc-en.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/widgets.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
