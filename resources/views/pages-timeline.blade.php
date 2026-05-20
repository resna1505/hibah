@extends('layouts.master')
@section('title')
@lang('translation.timeline')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') Timeline @endslot
@endcomponent


<div class="row">
    <div class="col-lg-12">
        <div class="timeline mt-5">
            <div class="timeline-line">
                <div class="timeline-box ">
                    <div class="date">22 Oct 2022</div>
                    <div class="content">
                        <h5>Frank hook joined with our company</h5>
                        <p class="text-muted mb-0">
                            It makes a statement, it’s impressive graphic design. Increase or decrease the letter spacing depending on the situation and try, try again until it looks right, and each letter has the perfect spot of its own.
                        </p>
                    </div>
                </div>
            </div>
            <div class="timeline-line">
                <div class="timeline-box">
                    <div class="date">30 Oct 2022</div>
                    <div class="content">
                        <h5>Design Review with Timeless</h5>
                        <p class="text-muted">
                            12:30 - 03:20 PM, California, US.
                        </p>
                        <div class="avatar-group">
                            <div class="avatar-group-item">
                                <img src="{{ URL::asset('build/images/users/avatar-4.jpg') }}" alt="" class="rounded-circle avatar-xs">
                            </div>
                            <div class="avatar-group-item">
                                <img src="{{ URL::asset('build/images/users/avatar-5.jpg') }}" alt="" class="rounded-circle avatar-xs">
                            </div>
                            <div class="avatar-group-item">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-light text-primary">
                                        A
                                    </div>
                                </div>
                            </div>
                            <div class="avatar-group-item">
                                <img src="{{ URL::asset('build/images/users/avatar-6.jpg') }}" alt="" class="rounded-circle avatar-xs">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline-line">
                <div class="timeline-box">
                    <div class="date">19 Nov 2022</div>
                    <div class="content">
                        <div class="d-flex gap-3 mb-3">
                            <div class="flex-shrink-0">
                                <img src="{{ URL::asset('build/images/users/avatar-6.jpg') }}" alt="" class="avatar-sm rounded-circle">
                            </div>
                            <div>
                                <h5 class="mb-1">Brianna Clinton</h5>
                                <p class="text-muted mb-0">Creative Designer</p>
                            </div>
                        </div>
                        <p class="text-muted mb-0">
                            I'm so impressed by your dedication to learning. I know it wasn't easy when that technology solution you presented didn't work out.
                        </p>
                    </div>
                </div>
            </div>
            <div class="timeline-line">
                <div class="timeline-box">
                    <div class="date">24 Nov 2022</div>
                    <div class="content">
                        <div class="mb-3">
                            <span class="badge text-secondary bg-secondary-subtle">Business</span>
                            <span class="badge text-secondary bg-secondary-subtle">Marketing</span>
                        </div>
                        <p class="text-muted mb-2">
                            A business is defined as <b>an organization or enterprising entity engaged in commercial, industrial, or professional activities.</b> Businesses can be for-profit entities or non-profit organizations. Business types range from limited liability companies to sole proprietorships, corporations, and partnerships.
                        </p>

                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-emoji-smile text-muted"></i> 3 reactions
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-chat-left-text text-muted"></i> 245
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-eye text-muted"></i> 530
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="timeline-line">
                <div class="timeline-box">
                    <div class="date">15 Dec 2022</div>
                    <div class="content">
                        <h5>Project</h5>
                        <p class="text-muted">
                            <b>@jennifer_daina</b> edited <b>hybrix.zip</b> and attach 2 files to the hybrix project.
                        </p>

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card border-dashed shadow-none mb-0">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-xs flex-shrink-0">
                                                <div class="avatar-title bg-light text-muted rounded">
                                                    <i class="bi bi-file-earmark-zip"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">hybrix.zip</h6>
                                                <p class="fs-11 text-muted mb-0">12.76 MP</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card border-dashed shadow-none mb-0">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-xs flex-shrink-0">
                                                <div class="avatar-title bg-light text-muted rounded">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">documentation.pdf</h6>
                                                <p class="fs-11 text-muted mb-0">754 KB</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline-line">
                <div class="timeline-box">
                    <div class="date">8 Jan 2023</div>
                    <div class="content">
                        <h5>New ticket received <span class="badge bg-info-subtle text-info fs-10 align-middle ms-1">New</span></h5>
                        <p class="text-muted mb-2">
                            It is important for us that we receive email notifications when a ticket is created as our IT staff are mobile and will not always be looking at the dashboard for new tickets.
                        </p>
                        <a href="javascript:void(0);" class="link-secondary">Read More <i class="ri-arrow-right-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row mt-4">
    <div class="col-lg-12">
        <div>
            <h5>Horizontal Timeline</h5>
            <div class="horizontal-timeline my-3">
                <div class="swiper timelineSlider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted fw-medium mb-2">October, 2022</p>
                                        <h6 class="mb-0 fs-15">Plateform Development</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">23 Oct</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted mb-2">October, 2022</p>
                                        <h6 class="mb-0 fs-15">Release Bank & Cards Phase</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">31 Oct</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted mb-2">November, 2022</p>
                                        <h6 class="mb-0 fs-15">Beta Launch of Plateform</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">24 Nov</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted mb-2">December, 2022</p>
                                        <h6 class="mb-0 fs-15">First Crypto Bank Transfers</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">07 Dec</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted mb-2">January, 2023</p>
                                        <h6 class="mb-0 fs-15">Launch Ethbay Services</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">15 Jan</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted mb-2">February, 2023</p>
                                        <h6 class="mb-0 fs-15">Fastest Crypto Transaction</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">03 Feb</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted mb-2">July, 2023</p>
                                        <h6 class="mb-0 fs-15">Crypto Blockchain Release</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">24 July</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                        <div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded border border-dashed">
                                    <div>
                                        <p class="text-muted mb-2">August, 2023</p>
                                        <h6 class="mb-0 fs-16">Launch Ethereum Classifieds</h6>
                                    </div>
                                </div>
                                <div class="time"><span class="badge text-bg-secondary">16 Aug</span></div>
                            </div>
                        </div>
                        <!--end swiper-slide-->
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            <!--end timeline-->
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection
@section('script')
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/timeline.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

