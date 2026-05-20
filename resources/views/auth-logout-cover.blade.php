@extends('layouts.master-without-nav')
@section('title')
@lang('translation.logout')
@endsection
@section('content')

<section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
    <div class="bg-overlay"></div>
    <div class="container-fluid px-0">
        <div class="row g-0 justify-content-center">
            <div class="col-xl-4 col-lg-6">
                <div class="text-center mb-4 pb-2">
                    <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt="" height="32" />
                </div>
                <div class="card mb-0 py-4">

                    <div class="card-body p-4 p-sm-5 m-lg-4 text-center">
                        <div class="display-4 text-primary">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        <div class="mt-4 pt-2">
                            <h5 class="fs-18">You are Logged Out</h5>
                            <p class="text-muted">Thank you for using <span class="fw-semibold">hybrix</span> admin template</p>
                            <div class="mt-4">
                                <a href="auth-signin-basic" class="btn btn-primary w-100">Sign In</a>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-white text-center mt-4">
                    <p class="mb-0">&copy;
                        <script>
                            document.write(new Date().getFullYear())

                        </script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                    </p>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end conatiner-->
</section>

@endsection
