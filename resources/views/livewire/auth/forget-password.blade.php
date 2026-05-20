@section('title')
    Forget Password
@endsection

<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <!-- auth-page content -->
    <div class="container-fluid">
        <div class="row g-0 justify-content-center">
            <div class="col-xl-4 col-lg-6">
                <div class="text-center mb-4 pb-2">
                    <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt="" height="32" />
                </div>
                <div class="card mb-0 border-0 py-3 shadow-none">
                    <div class="card-body p-4 p-sm-5">
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
                        @if (session()->has('error'))
                            <div class="alert alert-borderless alert-danger alert-dismissible mb-2 mx-2">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('success'))
                            <div class="alert alert-borderless alert-success alert-dismissible mb-2 mx-2">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="p-2">
                            <form method="POST" wire:submit="submit">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" wire:model.live="email"
                                        value="{{ old('email') }}" autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="text-center mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
                                </div>
                                <div wire:loading wire:target="submit">
                                    <div id="preloader" style="opacity: 0.5; visibility: visible;">
                                        <div id="status">
                                            <div class="spinner-border text-primary avatar-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form><!-- end form -->
                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Wait, I remember my password... <a href="{{ Route('login') }}"
                                    class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                        </div>
                    </div><!-- end card body -->
                </div>
                <div class="text-white text-center mt-4">
                    <p class="mb-0">&copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                        Themesbrand
                    </p>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end conatiner-->
</div>
<!-- end auth-page-wrapper -->
