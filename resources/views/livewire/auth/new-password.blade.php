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
                <div class="card mb-0 border-0 shadow-none">
                    <div class="card-body p-4 p-sm-5 m-lg-2">
                        <div class="text-center">
                            <h5 class="text-primary fs-20">Create new password</h5>
                            <p class="text-muted mb-5">Your new password must be different from previous used password.
                            </p>
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
                            <form method="POST" wire:submit="resetPassword">
                                <input type="hidden" value="{{ $email }}" wire:model.live="email">
                                <input type="hidden" value="{{ $token }}" wire:model.live="token">
                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <input type="password"
                                            class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                            onpaste="return false" placeholder="Enter password" id="password-input"
                                            wire:model.live="password" aria-describedby="passwordInput" required>
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password-confirm">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 password-input"
                                            onpaste="return false" placeholder="Confirm password" id="password-confirm"
                                            wire:model.live="password_confirmation" required>
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-confirm"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                </div>

                            </form>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Wait, I remember my password... <a href="{{ Route('login') }}"
                                    class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
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

@section('script')
    <script>
        // password addon
        Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(function(item) {
            Array.from(item.querySelectorAll(".password-addon")).forEach(function(subitem) {
                subitem.addEventListener("click", function(event) {
                    var passwordInput = item.querySelector(".password-input");
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                    } else {
                        passwordInput.type = "password";
                    }
                });
            });
        });
    </script>
@endsection
