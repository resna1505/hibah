@extends('layouts.master-without-nav')
@section('title')
@lang('translation.maintenance')
@endsection
@section('body')

<body>
    @endsection
    @section('content')

    <section class="auth-page-wrapper-2 py-4 position-relative d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="auth-card card bg-primary h-100 rounded-0 rounded-start border-0 d-flex align-items-center justify-content-center overflow-hidden p-4">
                        <div class="auth-image">
                            <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt="" height="42" />
                            <img src="{{ URL::asset('build/images/effect-pattern/auth-effect-2.png') }}" alt="" class="auth-effect-2" />
                            <img src="{{ URL::asset('build/images/effect-pattern/auth-effect.png') }}" alt="" class="auth-effect" />
                            <img src="{{ URL::asset('build/images/effect-pattern/auth-effect.png') }}" alt="" class="auth-effect-3" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card mb-0 rounded-0 rounded-end border-0 py-lg-3">
                        <div class="card-body p-4 p-sm-5 m-lg-4">
                            <div class="text-center">
                                <div class="mb-5">
                                    <h3>Site is Under Maintenance</h3>
                                    <p class="text-muted fs-14">Please check back in sometime</p>
                                    <div class="mt-4 pt-2">
                                        <a href="index" class="btn btn-primary"><i class="mdi mdi-home me-1"></i> Back to Home</a>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <img src="{{ URL::asset('build/images/maintenance.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </section>

    @endsection
