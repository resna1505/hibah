@extends('layouts.master-without-nav')
@section('title')
@lang('translation.two-step-verification')
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
                                                    <p class="mb-0">&copy;
                                                        <script>document.write(new Date().getFullYear())</script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-7">
                                        <div class="card mb-0 border-0 py-3 shadow-none">
                                            <div class="card-body px-0 p-sm-5 m-lg-4 text-center">
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
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

      @endsection
       @section('script')
 <script src="{{ URL::asset('build/js/pages/two-step-verification.init.js') }}"></script>

 @endsection
