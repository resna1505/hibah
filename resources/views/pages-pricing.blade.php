@extends('layouts.master')
@section('title')
@lang('translation.pricing')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') Pricing @endslot
@endcomponent


<div class="row justify-content-center mt-4">
    <div class="col-lg-5">
        <div class="text-center mb-5">
            <h4 class="fw-semibold fs-22">Plans & Pricing</h4>
            <p class="text-muted mb-4 fs-15">Simple pricing. No hidden fees. Advanced features for you business.</p>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row justify-content-center">
    <div class="col-xxl-8">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills plan-nav nav-info mb-4 p-2 d-inline-flex bg-light rounded" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold active" id="month-tab" data-bs-toggle="pill" data-bs-target="#month" type="button" role="tab" aria-selected="true">Monthly</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="annual-tab" data-bs-toggle="pill" data-bs-target="#annual" type="button" role="tab" aria-selected="false">Annually <span class="badge bg-success">25% Off</span></button>
                            </li>
                        </ul>
                        <ul class="list-unstyled vstack gap-4 text-muted mb-0" id="plan-list">
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 text-success me-2">
                                        <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b>8</b> Projects
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 text-success me-2">
                                        <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b>449</b> Customers
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 text-success me-2">
                                        <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        Scalable Bandwidth
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 text-success me-2">
                                        <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b>7</b> FTP Login
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 text-success me-2">
                                        <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b>24/7</b> Support
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 text-danger me-2">
                                        <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b>Unlimited</b> Storage
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 text-danger me-2">
                                        <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        Domain
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="vstack gap-3">
                    <div class="form-check card-radio">
                        <input id="plans01" type="radio" value="startup" class="form-check-input plan-radio" checked="">
                        <label class="form-check-label" for="plans01">
                            <span class="d-flex align-items-center">
                                <span class="fw-semibold d-block flex-grow-1 fs-15 text-uppercase">Startup</span>
                                <span class="month fw-semibold flex-shrink-0 fs-24 text-uppercase">$19 <small class="fs-12 text-muted">/Month</small></span>
                                <span class="annual fw-semibold flex-shrink-0 fs-24 text-uppercase"><small class="fs-16"><del>$228</del></small> $171 <small class="fs-12 text-muted">/Year</small></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-check card-radio">
                        <input id="plans02" type="radio" value="professional" class="form-check-input plan-radio">
                        <label class="form-check-label" for="plans02">
                            <span class="d-flex align-items-center">
                                <span class="flex-grow-1">
                                    <span class="fw-semibold d-block fs-14 text-uppercase mb-2">Professional</span>
                                </span>
                                <span class="month fw-semibold flex-shrink-0 fs-24 text-uppercase">$29 <small class="fs-12 text-muted">/Month</small></span>
                                <span class="annual fw-semibold flex-shrink-0 fs-24 text-uppercase"><small class="fs-16"><del>$348</del></small> $261 <small class="fs-12 text-muted">/Year</small></span>
                            </span>

                        </label>
                    </div>
                    <div class="form-check card-radio">
                        <input id="plans03" type="radio" value="enterprise" class="form-check-input plan-radio">
                        <label class="form-check-label" for="plans03">
                            <span class="d-flex align-items-center">
                                <span class="flex-grow-1">
                                    <span class="fw-semibold d-block fs-14 text-uppercase mb-2">Enterprise</span>
                                    <span class="badge text-bg-danger">15% save</span>
                                </span>
                                <span class="month fw-semibold flex-shrink-0 fs-24 text-uppercase">$39 <small class="fs-12 text-muted">/Month</small></span>
                                <span class="annual fw-semibold flex-shrink-0 fs-24 text-uppercase"><small class="fs-16"><del>$468</del></small> $351 <small class="fs-12 text-muted">/Year</small></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-check card-radio">
                        <input id="plans04" type="radio" value="unlimited" class="form-check-input plan-radio">
                        <label class="form-check-label" for="plans04">
                            <span class="d-flex align-items-center">
                                <span class="fw-semibold d-block flex-grow-1 fs-15 text-uppercase">Unlimited</span>
                                <span class="month fw-semibold flex-shrink-0 fs-24 text-uppercase">$49 <small class="fs-12 text-muted">/Month</small></span>
                                <span class="annual fw-semibold flex-shrink-0 fs-24 text-uppercase"><small class="fs-16"><del>$588</del></small> $441 <small class="fs-12 text-muted">/Year</small></span>
                            </span>
                        </label>
                    </div>

                    <div>
                        <a href="#!" class="btn btn-primary w-100">Get Started</a>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end-col-->
</div>

<div class="row justify-content-center mt-5">
    <div class="col-lg-5">
        <div class="text-center mb-5">
            <h3 class="fw-semibold fs-22">Our plans for your Business</h3>
            <p class="text-muted fs-15">Simple pricing. No hidden fees. Advanced features for you business.</p>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row">
    <div class="col-xxl-3 col-lg-6">
        <div class="card pricing-box card-animate shadow-lg border-0 border-top border-2 border-success rounded-0 rounded-bottom">
            <div class="card-body m-2 p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-semibold">Starter</h5>
                    </div>
                    <div class="ms-auto">
                        <h2 class="mb-0">$19 <small class="fs-13 text-muted">/Month</small></h2>
                    </div>
                </div>

                <p class="text-muted">The perfect way to get started and get used to our tools.</p>
                <ul class="list-unstyled vstack gap-3">
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>3</b> Projects
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>299</b> Customers
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                Scalable Bandwidth
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>5</b> FTP Login
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-3 pt-2">
                    <a href="javascript:void(0);" class="btn btn-danger disabled w-100">Your Current Plan</a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->

    <div class="col-xxl-3 col-lg-6">
        <div class="card pricing-box card-animate shadow-lg border-0 border-top border-2 border-secondary rounded-0 rounded-bottom">
            <div class="card-body m-2 p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-semibold">Professional</h5>
                    </div>
                    <div class="ms-auto">
                        <h2 class="mb-0">$29 <small class="fs-13 text-muted">/Month</small></h2>
                    </div>
                </div>
                <p class="text-muted">Excellent for scalling teams to build culture. Special plan for professional business.</p>
                <ul class="list-unstyled vstack gap-3">
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>8</b> Projects
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>449</b> Customers
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                Scalable Bandwidth
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>7</b> FTP Login
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>24/7</b> Support
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-3 pt-2">
                    <a href="javascript:void(0);" class="btn btn-info w-100">Change Plan</a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->

    <div class="col-xxl-3 col-lg-6">
        <div class="card pricing-box card-animate shadow-lg border-0 border-top border-2 border-primary rounded-0 rounded-bottom">
            <div class="card-body m-2 p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-semibold">Enterprise</h5>
                    </div>
                    <div class="ms-auto">
                        <h2 class="mb-0">$39 <small class="fs-13 text-muted">/Month</small></h2>
                    </div>
                </div>
                <p class="text-muted">This plan is for those who have a team alredy and running a large business.</p>
                <ul class="list-unstyled vstack gap-3">
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>15</b> Projects
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>Unlimited</b> Customers
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                Scalable Bandwidth
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>12</b> FTP Login
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>24/7</b> Support
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>35GB</b> Storage
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-3 pt-2">
                    <a href="javascript:void(0);" class="btn btn-info w-100">Change Plan</a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->

    <div class="col-xxl-3 col-lg-6">
        <div class="card pricing-box card-animate shadow-lg border-0 border-top border-2 border-info rounded-0 rounded-bottom">
            <div class="p-1 bg-info bg-opacity-10 text-center text-info fw-semibold"><span><i class="ri-flashlight-fill align-bottom me-1"></i> Most Popular Choice</span></div>
            <div class="card-body m-2 p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-semibold">Unlimited</h5>
                    </div>
                    <div class="ms-auto">
                        <h2 class="mb-0">$49 <small class="fs-13 text-muted">/Month</small></h2>
                    </div>
                </div>
                <p class="text-muted">For most businesses that want to optimize web queries.</p>
                <ul class="list-unstyled vstack gap-3">
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>Unlimited</b> Projects
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>Unlimited</b> Customers
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                Scalable Bandwidth
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>Unlimited</b> FTP Login
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>24/7</b> Support
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <b>Unlimited</b> Storage
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div class="flex-shrink-0 text-success me-1">
                                <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                Domain
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-3 pt-2">
                    <a href="javascript:void(0);" class="btn btn-info w-100">Change Plan</a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row justify-content-center mt-5">
    <div class="col-xl-5">
        <div class="text-center mb-4 pb-4">
            <h4 class="fw-semibold fs-22">Package for your plans</h4>
            <p class="text-muted mb-4 fs-15">Simple pricing. No hidden fees. Advanced features for you business.</p>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="row gy-5 gy-lg-4">
            <div class="col-xxl-4 col-lg-6">
                <div class="card pricing-box">
                    <div class="mt-n4">
                        <div class="avatar-md mt-n3 mx-auto p-1 border rounded-circle">
                            <div class="avatar-title bg-light rounded-circle text-primary">
                                <i class="ri-book-mark-line fs-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 m-2 mt-0">
                        <div>
                            <h5 class="mb-1 fw-semibold">Basic Plan</h5>
                            <p class="text-muted mb-0">For Startup</p>
                        </div>
                        <div class="pt-4">
                            <h2><sup><small>$</small></sup>19.99<span class="fs-13 text-muted">/Month</span></h2>
                        </div>
                        <hr class="my-4 text-muted border-dashed">
                        <div>
                            <ul class="list-unstyled text-muted vstack gap-3">
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Upto <b>3</b> Projects
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Upto <b>299</b> Customers
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Scalable Bandwidth
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>5</b> FTP Login
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-danger me-1">
                                            <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>24/7</b> Support
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-danger me-1">
                                            <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Unlimited</b> Storage
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-danger me-1">
                                            <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Domain
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <a href="javascript:void(0);" class="btn btn-soft-secondary w-100">Sign Up Free</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xxl-4 col-lg-6">
                <div class="card pricing-box">
                    <div class="mt-n4">
                        <div class="avatar-md mt-n3 mx-auto p-1 border rounded-circle">
                            <div class="avatar-title bg-light rounded-circle text-primary">
                                <i class="ri-medal-line fs-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 m-2 mt-0">
                        <div>
                            <div>
                                <h5 class="mb-1 fw-semibold">Pro Business</h5>
                                <p class="text-muted mb-0">Professional plans</p>
                            </div>

                            <div class="pt-4">
                                <h2><sup><small>$</small></sup> 29.99<span class="fs-13 text-muted">/Month</span></h2>
                            </div>
                        </div>
                        <hr class="my-4 text-muted">
                        <div>
                            <ul class="list-unstyled vstack gap-3 text-muted">
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Upto <b>15</b> Projects
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Unlimited</b> Customers
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Scalable Bandwidth
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>12</b> FTP Login
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>24/7</b> Support
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-danger me-1">
                                            <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Unlimited</b> Storage
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-danger me-1">
                                            <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Domain
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <a href="javascript:void(0);" class="btn btn-secondary w-100">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xxl-4 col-lg-6">
                <div class="card pricing-box">
                    <div class="mt-n4">
                        <div class="avatar-md mt-n3 mx-auto p-1 border rounded-circle">
                            <div class="avatar-title bg-light rounded-circle text-primary">
                                <i class="ri-stack-line fs-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 m-2 mt-0">
                        <div>
                            <div>
                                <h5 class="mb-1 fw-semibold">Platinum Plan</h5>
                                <p class="text-muted mb-0">Enterprise Businesses</p>
                            </div>

                            <div class="pt-4">
                                <h2><sup><small>$</small></sup> 39.99<span class="fs-13 text-muted">/Month</span></h2>
                            </div>
                        </div>
                        <hr class="my-4 text-muted">
                        <div>
                            <ul class="list-unstyled vstack gap-3 text-muted">
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Unlimited</b> Projects
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Unlimited</b> Customers
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Scalable Bandwidth
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Unlimited</b> FTP Login
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>24/7</b> Support
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Unlimited</b> Storage
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-success me-1">
                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            Domain
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <a href="javascript:void(0);" class="btn btn-soft-secondary w-100">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row justify-content-center mt-5">
    <div class="col-xl-4">
        <div class="text-center mb-4 pb-2">
            <h4 class="fw-semibold fs-22">Simple Pricing Plan</h4>
            <p class="text-muted mb-4 fs-15">Simple pricing. No hidden fees. Advanced features for you business.</p>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
<div class="row">
    <div class="col-xxl-4 col-lg-6">
        <div class="card bg-primary bg-opacity-10 border-0">
            <div class="card-body p-4 m-2">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div>
                            <h5 class="mb-1">Starter</h5>
                            <p class="text-muted">Starter plans</p>
                        </div>

                        <div class="py-4">
                            <h2><sup><small>$</small></sup>22 <span class="fs-13 text-muted"> /Per month</span></h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-unstyled vstack gap-3 mb-0">
                            <li>Users: <span class="text-primary fw-semibold">1</span></li>
                            <li>Storage: <span class="text-primary fw-semibold">01 GB</span></li>
                            <li>Domain: <span class="text-primary fw-semibold">No</span></li>
                            <li>Support: <span class="text-primary fw-semibold">No</span></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <a href="#!" class="btn btn-primary w-100">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-4 col-lg-6">
        <div class="card bg-danger bg-opacity-10 border-0 ribbon-box ribbon-fill right">
            <div class="ribbon ribbon-danger shadow-none">New</div>
            <div class="card-body p-4 m-2">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div>
                            <h5 class="mb-1">Professional</h5>
                            <p class="text-muted">Professional plans</p>
                        </div>

                        <div class="py-4">
                            <h2><sup><small>$</small></sup>29.99 <span class="fs-13 text-muted"> /Per month</span></h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-unstyled vstack gap-3 mb-0">
                            <li>Users: <span class="text-danger fw-semibold">1</span></li>
                            <li>Storage: <span class="text-danger fw-semibold">01 GB</span></li>
                            <li>Domain: <span class="text-danger fw-semibold">No</span></li>
                            <li>Support: <span class="text-danger fw-semibold">No</span></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <a href="#!" class="btn btn-danger w-100">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-4 col-lg-6">
        <div class="card bg-info bg-opacity-10 border-0">
            <div class="card-body p-4 m-2">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div>
                            <h5 class="mb-1">Unlimited</h5>
                            <p class="text-muted">Unlimited plans</p>
                        </div>

                        <div class="py-4">
                            <h2><sup><small>$</small></sup>49.99 <span class="fs-13 text-muted"> /Per month</span></h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-unstyled vstack gap-3 mb-0">
                            <li>Users: <span class="text-info fw-semibold">5</span></li>
                            <li>Storage: <span class="text-info fw-semibold">40 GB</span></li>
                            <li>Domain: <span class="text-info fw-semibold">Yes</span></li>
                            <li>Support: <span class="text-info fw-semibold">Yes</span></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <a href="#!" class="btn btn-info w-100">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/pricing.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
