@extends('layouts.master-without-nav')
@section('title')
@lang('translation.offline-page')
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
                        <div class="mt-2 text-center">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/ptzyuaia.json" trigger="loop" style="width:200px;height:200px">
                                </lord-icon>
                                <h3 class="mt-4 fw-semibold">We're Currently Offline</h3>
                                <p class="text-muted mb-4 fs-14">We can't show you this images because you aren't connected to the internet. When you’re back online refresh the page or hit the button below</p>
                                <button class="btn btn-primary" onClick="window.location.href=window.location.href"><i class="ri-refresh-line align-bottom"></i> Refresh</button>
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
