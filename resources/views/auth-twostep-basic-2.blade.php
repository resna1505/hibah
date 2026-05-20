@extends('layouts.master-without-nav')
@section('title')
@lang('translation.two-step-verification')
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
                        <div class="mb-4">
                            <lord-icon src="https://cdn.lordicon.com/diihvcfp.json" trigger="loop" class="avatar-md"> </lord-icon>
                        </div>

                        <div class="p-2 mt-4">
                            <div class="text-muted text-center mb-4 mx-lg-3">
                                <h4>Verify Your Email</h4>
                                <p>Please enter the 4 digit code sent to <span class="fw-semibold">example@abc.com</span></p>
                            </div>

                            <form autocomplete="off">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="digit1-input" class="visually-hidden">Digit 1</label>
                                            <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(1, event)" maxLength="1" id="digit1-input">
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="digit2-input" class="visually-hidden">Digit 2</label>
                                            <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(2, event)" maxLength="1" id="digit2-input">
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="digit3-input" class="visually-hidden">Digit 3</label>
                                            <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(3, event)" maxLength="1" id="digit3-input">
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="digit4-input" class="visually-hidden">Digit 4</label>
                                            <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(4, event)" maxLength="1" id="digit4-input">
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            </form><!-- end form -->

                            <div class="mt-3">
                                <button type="button" class="btn btn-primary w-100">Confirm</button>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Didn't receive a code ? <a href="auth-pass-reset-basic" class="fw-semibold text-primary text-decoration-underline">Resend</a> </p>
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
    <!--edn container-->
</section>


@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/two-step-verification.init.js') }}"></script>

@endsection
