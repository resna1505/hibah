@extends('layouts.master-without-nav')
@section('title')
@lang('translation.two-step-verification')
@endsection
@section('content')

<section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
    <div class="bg-overlay"></div>
    <div class="container-fluid px-0">
        <div class="row g-0 justify-content-center">
            <div class="col-xl-4 col-lg-6">
                <div class="text-center mb-5">
                    <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt="" height="32" />
                </div>
                <div class="card mb-0 py-5">
                    <div class="card-body p-4 p-sm-5 m-lg-4 text-center">
                        <div class="mb-4 pb-2">
                            <lord-icon src="https://cdn.lordicon.com/diihvcfp.json" trigger="loop" class="avatar-md"> </lord-icon>
                        </div>
                        <div class="text-muted text-center mx-lg-3">
                            <h4 class="">Verify Your Email</h4>
                            <p>Please enter the 4 digit code sent to <span class="fw-semibold">example@abc.com</span></p>
                        </div>

                        <div class="mt-4">
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

                                <div class="mt-3">
                                    <button type="button" class="btn btn-primary w-100">Confirm</button>
                                </div>

                            </form>

                        </div>

                        <div class="mt-5 text-center">
                            <p class="mb-0">Didn't receive a code ? <a href="auth-pass-reset-cover" class="fw-semibold text-primary text-decoration-underline">Resend</a> </p>
                        </div>
                    </div><!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-white text-center mt-5">
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
@section('script')
<script src="{{ URL::asset('build/js/pages/two-step-verification.init.js') }}"></script>

@endsection
