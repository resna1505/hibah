@extends('layouts.master-without-nav')
@section('title')
@lang('translation.lock-screen')
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

                    <div class="card-body p-4 p-sm-5 m-lg-2 text-center">
                        <div>
                            <h5 class="text-primary fs-20">Lock Screen</h5>
                            <p class="text-muted">Enter your password to unlock the screen!</p>
                        </div>
                        <div class="user-thumb text-center">
                            <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                            <h5 class="font-size-15 mt-3">Hi ! Edward Diana</h5>
                        </div>

                        <div class="mt-4 text-start">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label" for="userpassword">Password or Pin</label>
                                    <input type="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                                </div>
                                <div class="mb-2 mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Unlock</button>
                                </div>
                            </form><!-- end form -->
                        </div>

                        <div class="mt-5 text-center">
                            <p class="mb-0">Not you ? return <a href="auth-signin-cover" class="fw-semibold text-primary text-decoration-underline"> Signin</a></p>
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
