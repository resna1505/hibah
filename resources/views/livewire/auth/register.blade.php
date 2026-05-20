@section('title') Register @endsection

<section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
    <div class="bg-overlay"></div>
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-xl-8 col-lg-6">
                <div class="h-100 mb-0 p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt=""
                                 height="32" />
                        </div>
                    </div>

                    <div class="text-white mt-4">
                        <p class="mb-0">&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Themesbrand
                        </p>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-4 col-lg-6">
                <div class="card mb-0">

                    <div class="card-body p-4 p-sm-5 m-lg-2">
                        <div class="text-center mt-2">
                            <h5 class="text-primary fs-20">Create New Account</h5>
                            <p class="text-muted">Get your free Hybrix account now</p>
                        </div>
                        @if(session()->has('error'))
                            <div class="alert alert-borderless alert-danger alert-dismissible mb-2 mx-2">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session()->has('success'))
                            <div class="alert alert-borderless alert-success alert-dismissible mb-2 mx-2">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="p-2 mt-5">
                            <form class="needs-validation" novalidate enctype="multipart/form-data" wire:submit="submit">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input id="first_name" type="text"
                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                   wire:model.live="first_name" value="{{ old('first_name') }}" required
                                                   autocomplete="first_name" autofocus placeholder="Enter first name">
                                            @error('first_name')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name <span
                                                    class="text-danger">*</span></label>
                                            <input id="last_name" type="text"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   wire:model.live="last_name" value="{{ old('last_name') }}" required
                                                   autocomplete="last_name" autofocus placeholder="Enter last name">
                                            @error('last_name')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror" wire:model.live="email"
                                                   value="{{ old('email') }}" required autocomplete="off"
                                                   placeholder="Enter your email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="avatar" class="form-label">Profile Photo <span
                                                    class="text-danger">*</span></label>
                                            <input id="avatar" type="file"
                                                   class="form-control @error('avatar') is-invalid @enderror" wire:model.live="avatar"
                                                   value="{{ old('avatar') }}" required autocomplete="off"
                                                   placeholder="Enter your avatar">
                                            @error('avatar')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password"
                                                       class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                                       onpaste="return false" placeholder="Enter password"
                                                       id="password-input" wire:model.live="password" aria-describedby="passwordInput"
                                                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
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
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="password-confirm">Confirm Password <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input id="confirm-password-input" type="password"
                                                       class="form-control pe-5 password-input"
                                                       wire:model.live="password_confirmation" required autocomplete="new-password"
                                                       placeholder="Enter confirm password">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the
                                            Hybrix
                                            <a href="#"
                                               class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                                of
                                                Use</a>
                                        </p>
                                    </div>

                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13">Password must contain:</h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b>
                                        </p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter
                                            (a-z)
                                        </p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b>
                                            letter
                                            (A-Z)
                                        </p>
                                        <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)
                                        </p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                                    </div>

                                     <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-soft-primary btn-icon "><i
                                                    class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-danger btn-icon "><i
                                                    class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-dark btn-icon "><i
                                                    class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-soft-info btn-icon "><i
                                                    class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="{{ url('login') }}"
                                class="fw-semibold text-primary text-decoration-underline"> Sign in </a> </p>
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

@section('script')
    <!-- validation init -->
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <!-- password create init -->
    <script src="{{ URL::asset('build/js/pages/passowrd-create.init.js') }}"></script>
@endsection
