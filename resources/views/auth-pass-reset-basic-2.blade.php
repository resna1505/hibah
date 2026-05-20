@extends('layouts.master-without-nav')
@section('title')
@lang('translation.password-reset')
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
                <div class="card mb-0 border-0 py-3 shadow-none">
                    <div class="card-body p-4 p-sm-5 m-lg-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary fs-20">Forgot Password?</h5>
                            <p class="text-muted mb-4">Reset password with Hybrix</p>
                            <div class="display-5 mb-4 text-danger">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                            Enter your email and instructions will be sent to you!
                        </div>
                        <div class="p-2">
                            <form>
                                <div class="mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email" required="">
                                </div>

                                <div class="text-center mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
                                </div>
                            </form><!-- end form -->
                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Wait, I remember my password... <a href="auth-signin-basic" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--edn container-->
</section>

@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/two-step-verification.init.js') }}"></script>

@endsection
