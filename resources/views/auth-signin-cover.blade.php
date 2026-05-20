@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')


<section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
    <div class="bg-overlay"></div>
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-xl-8 col-lg-6">
                <div class="h-100 mb-0 p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt="" height="32" />
                        </div>
                    </div>

                    <div class="text-white mt-4">
                        <p class="mb-0">&copy;
                            <script>
                                document.write(new Date().getFullYear())

                            </script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                        </p>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-4 col-lg-6">
                <div class="card mb-0 py-5">

                    <div class="card-body p-4 p-sm-5 m-lg-2">
                        <div class="text-center mt-2">
                            <h5 class="text-primary fs-22">Welcome Back !</h5>
                            <p class="text-muted">Sign in to continue to Hybrix.</p>
                        </div>
                        <div class="p-2 mt-5">
                            <form action="index">

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter username">
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        <a href="auth-pass-reset-basic" class="text-muted">Forgot password?</a>
                                    </div>
                                    <label class="form-label" for="password-input">Password</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input">
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                </div>

                                <div class="mt-4 pt-2 text-center">
                                    <div class="signin-other-title">
                                        <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                    </div>
                                    <div class="pt-2 hstack gap-2 justify-content-center">
                                        <button type="button" class="btn btn-soft-primary btn-icon"><i class="ri-facebook-fill fs-16"></i></button>
                                        <button type="button" class="btn btn-soft-danger btn-icon"><i class="ri-google-fill fs-16"></i></button>
                                        <button type="button" class="btn btn-soft-dark btn-icon"><i class="ri-github-fill fs-16"></i></button>
                                        <button type="button" class="btn btn-soft-info btn-icon"><i class="ri-twitter-fill fs-16"></i></button>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center mt-5">
                                <p class="mb-0">Don't have an account ? <a href="auth-signup-cover" class="fw-semibold text-secondary text-decoration-underline"> SignUp</a> </p>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end conatiner-->
</section>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>

@endsection
