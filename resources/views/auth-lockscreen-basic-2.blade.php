@extends('layouts.master-without-nav')
@section('title')
@lang('translation.lock-screen')
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
                    <div class="card-body p-4 p-sm-5 m-lg-4">
                        <div class="text-center">
                            <h5 class="text-primary fs-20">Lock Screen</h5>
                            <p class="text-muted mb-4">Enter your password to unlock the screen!</p>
                        </div>
                        <div class="user-thumb text-center">
                            <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                            <h5 class="font-size-15 mt-3">Hi ! Edward Diana</h5>
                        </div>
                        <div class="p-2 mt-4">
                            <form>

                                <div class="mb-3">
                                    <label class="form-label" for="userpassword">Password or Pin</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="ri-lock-2-line"></i></span>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password or pin" required>
                                    </div>
                                </div>

                                <div class="mb-2 mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Unlock</button>
                                </div>
                            </form><!-- end form -->

                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Not you ? return <a href="auth-signin-basic" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
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
@section('script')
<script src="{{ URL::asset('build/js/pages/two-step-verification.init.js') }}"></script>
@endsection
