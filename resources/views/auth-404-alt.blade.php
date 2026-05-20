@extends('layouts.master-without-nav')

@section('title')
@lang('translation.404-error-alt')
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
                <div class="card mb-0 rounded-0 rounded-end border-0">
                    <div class="card-body p-4 p-sm-5 m-lg-4 text-center">
                        <div class="text-center px-5">
                            <h1 class="error-title mb-0">404</h1>
                        </div>
                        <div class="mt-2 text-center">
                            <div class="position-relative">
                                <h4 class="fs-18 error-subtitle text-uppercase mb-0">Opps, page not found</h4>
                                <p class="fs-15 text-muted mt-3">It will be as simple as Occidental in fact,
                                    it will Occidental to an English person</p>
                                <div class="mt-4">
                                    <a href="index" class="btn btn-primary"><i class="mdi mdi-home me-1"></i>Back to home</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--edn container-->
</section>

@endsection
