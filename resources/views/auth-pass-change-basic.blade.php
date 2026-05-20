@extends('layouts.master-without-nav')
@section('title')
@lang('translation.password-create')
@endsection
@section('content')

        <section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-lg-5">
                                        <div class="card auth-card bg-primary h-100 border-0 shadow-none p-sm-3 overflow-hidden">
                                            <div class="card-body p-4 d-flex justify-content-between flex-column">
                                                <div class="auth-image">
                                                    <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt="" height="26" />
                                                    <img src="{{ URL::asset('build/images/effect-pattern/auth-effect-2.png') }}" alt="" class="auth-effect-2" />
                                                    <img src="{{ URL::asset('build/images/effect-pattern/auth-effect.png') }}" alt="" class="auth-effect" />
                                                    <img src="{{ URL::asset('build/images/effect-pattern/auth-effect.png') }}" alt="" class="auth-effect-3" />
                                                </div>

                                                <div>   
                                                    <h3 class="text-white">Start your journey with us.</h3>
                                                    <p class="text-white-75 fs-15">It brings together your tasks, projects, timelines, files and more</p>
                                                </div>
                                                <div class="text-center text-white-75">
                                                    <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-7">
                                        <div class="card mb-0 border-0 shadow-none">
                                            <div class="card-body px-0 p-sm-5 m-lg-4">
                                                <div class="text-center">
                                                    <h5 class="text-primary fs-20">Create new password</h5>
                                                    <p class="text-muted mb-5">Your new password must be different from previous used password.</p>
                                                </div>
                                                
                                                <div class="p-2">
                                                    <form action="auth-signin-basic">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="password-input">Password</label>
                                                            <div class="position-relative auth-pass-inputgroup">
                                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                            </div>
                                                            <div id="passwordInput" class="form-text">Your password must be 8-20 characters long.</div>
                                                        </div>
                                                
                                                        <div class="mb-3">
                                                            <label class="form-label" for="confirm-password-input">Confirm Password</label>
                                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Confirm password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="confirm-password-input" required>
                                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="confirm-password-input"><i class="ri-eye-fill align-middle"></i></button>
                                                            </div>
                                                        </div>
                                                
                                                        <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                            <h5 class="fs-13">Password must contain:</h5>
                                                            <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                                            <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                                            <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                                            <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                                        </div>
                                                
                                                        <div class="form-check form-check-primary">
                                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                        </div>
                                                
                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                                        </div>
                                                
                                                    </form>
                                                </div>
                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">Wait, I remember my password... <a href="auth-signin-basic" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section>

     @endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/passowrd-create.init.js') }}"></script>
@endsection
