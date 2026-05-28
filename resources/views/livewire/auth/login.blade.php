@section('title')
    Login - Hibah Internal UNIBA
@endsection

<section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
    <div class="bg-overlay"></div>
    <div class="container-fluid px-0">
        <div class="row g-0 justify-content-center">
            <div class="col-xl-4 col-lg-6 col-md-8">
                <div class="card mb-0 py-5">
                    <div class="card-body p-4 p-sm-5 m-lg-2">
                        <div class="text-center mt-2">
                            <h5 class="text-primary fs-22">Hibah Internal LPPM</h5>
                            <p class="text-muted">Universitas Batam</p>
                            <p class="text-muted small mt-2">Masukkan NIK dan password untuk masuk.</p>
                        </div>

                        @if (session()->has('error'))
                            <div class="alert alert-borderless alert-danger alert-dismissible mb-2 mx-2">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="p-2 mt-3">
                            <form wire:submit.prevent="submit">
                                @csrf

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                    <input id="nik" type="text"
                                        class="form-control @error('nik') is-invalid @enderror"
                                        wire:model.live="nik"
                                        required autofocus
                                        placeholder="Masukkan NIK">
                                    @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        @if (Route::has('password.reset'))
                                            <a class="text-muted" href="{{ route('password.reset') }}">Lupa Password?</a>
                                        @endif
                                    </div>
                                    <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input id="password-input" type="password"
                                            class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                            wire:model.live="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="Masukkan password">
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon">
                                            <i class="ri-eye-fill align-middle"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" wire:model="remember">
                                    <label class="form-check-label" for="remember">Ingat saya</label>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <span wire:loading.remove wire:target="submit">Masuk</span>
                                        <span wire:loading wire:target="submit">Memproses...</span>
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-5">
                                <p class="mb-0 text-muted small">Akun login disediakan oleh LPPM. Hubungi operator bila belum memiliki akses.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('script')
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection
