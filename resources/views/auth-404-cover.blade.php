@extends('layouts.master-without-nav')

@section('title')
@lang('translation.404-error-cover')
@endsection
@section('content')
    <section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
        <div class="bg-overlay"></div>
        <div class="container-fluid px-0">
            <div class="row g-0">
                <div class="col-xl-8 col-lg-6">
                    <div class="h-100 mb-0 p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <img src="{{ URL::asset('build/images/logo-light-full.png') }}" alt="" height="32" />
                            </div>
                        </div>

                        <div class="text-white mt-4">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-xl-4 col-lg-6">
                    <div class="card mb-0 py-5">
                        <div class="card-body p-4 p-sm-5 m-lg-2">
                            <div class="error-img text-center px-5">
                                <img src="{{ URL::asset('build/images/error400.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="mt-4 text-center pt-3">
                                <div class="position-relative">
                                    <h4 class="fs-18 error-subtitle text-uppercase mb-0">Opps, page not found</h4>
                                    <p class="fs-15 text-muted mt-3">It will be as simple as Occidental in fact,
                                        it will Occidental to an English person</p>
                                        <div class="mt-4">
                                            <a href="index" class="btn btn-primary"><i class="mdi mdi-home me-1"></i>Back to home</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end conatiner-->
    </section>

@endsection