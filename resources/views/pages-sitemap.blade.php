@extends('layouts.master')
@section('title')
@lang('translation.coming-soon')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') Sitemap @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h5 class="fs-14">Example 1</h5>
                        <p class="text-muted mb-4">Use <code>treemap-color="**"</code> attribute with <code>.treemap-elem</code> class for diffrent color icon treemap.</p>

                        <ul class="treemap-elem">
                            <li>
                                <input type="checkbox" id="check01" checked />
                                <label class="elem-label" for="check01">Admin</label>
                                <ul>
                                    <li><span class="elem-label">Dashboard</span></li>
                                    <li>
                                        <input type="checkbox" id="check02" checked />
                                        <label for="check02" class="elem-label">Apps</label>
                                        <ul>
                                            <li><span class="elem-label">Calender</span></li>
                                            <li><span class="elem-label">Chat</span></li>
                                            <li><span class="elem-label">Email</span></li>
                                        </ul>
                                    </li>
                                    <li><span class="elem-label">Widgets</span></li>
                                    <li>
                                        <input type="checkbox" id="check03" />
                                        <label for="check03" class="elem-label">Pages</label>
                                        <ul>
                                            <li><span class="elem-label">Sign in</span></li>
                                            <li><span class="elem-label">Sign up</span></li>
                                            <li><span class="elem-label">Forget password</span></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="check04" checked />
                                        <label for="check04" class="elem-label">Components</label>
                                        <ul>
                                            <li>
                                                <input type="checkbox" id="check05" checked />
                                                <label for="check05" class="elem-label">UI Element</label>
                                                <ul>
                                                    <li><span class="elem-label">Alerts</span></li>
                                                    <li><span class="elem-label">Buttons</span></li>
                                                    <li><span class="elem-label">Colors</span></li>
                                                    <li>
                                                        <input type="checkbox" id="check06" checked />
                                                        <label for="check06" class="elem-label">Forms</label>
                                                        <ul>
                                                            <li><span class="elem-label">Basic</span></li>
                                                            <li><span class="elem-label">Advanced</span></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><span class="elem-label">Advance UI</span></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>


                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="fs-14">Example 2 (Arrow icon)</h5>
                        <p class="text-muted mb-4">Use <code>treemap-icon="arrow"</code> attribute with <code>.treemap-elem</code> class for arrow icon treemap.</p>
                        <ul class="treemap-elem" treemap-icon="arrow" treemap-color="light">
                            <li>
                                <input type="checkbox" id="check11" checked />
                                <label class="elem-label" for="check11">Admin</label>
                                <ul>
                                    <li><span class="elem-label">Dashboard</span></li>
                                    <li>
                                        <input type="checkbox" id="check12" checked />
                                        <label for="check12" class="elem-label">Apps</label>
                                        <ul>
                                            <li><span class="elem-label">Calender</span></li>
                                            <li><span class="elem-label">Chat</span></li>
                                            <li><span class="elem-label">Email</span></li>
                                        </ul>
                                    </li>
                                    <li><span class="elem-label">Widgets</span></li>
                                    <li>
                                        <input type="checkbox" id="check13" />
                                        <label for="check13" class="elem-label">Pages</label>
                                        <ul>
                                            <li><span class="elem-label">Sign in</span></li>
                                            <li><span class="elem-label">Sign up</span></li>
                                            <li><span class="elem-label">Forget password</span></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="check14" checked />
                                        <label for="check14" class="elem-label">Components</label>
                                        <ul>
                                            <li>
                                                <input type="checkbox" id="check15" checked />
                                                <label for="check15" class="elem-label">UI Element</label>
                                                <ul>
                                                    <li><span class="elem-label">Alerts</span></li>
                                                    <li><span class="elem-label">Buttons</span></li>
                                                    <li><span class="elem-label">Colors</span></li>
                                                    <li>
                                                        <input type="checkbox" id="check16" checked />
                                                        <label for="check16" class="elem-label">Forms</label>
                                                        <ul>
                                                            <li><span class="elem-label">Basic</span></li>
                                                            <li><span class="elem-label">Advanced</span></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><span class="elem-label">Advance UI</span></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Responsive Sitemap</h4>
            </div>
            <div class="card-body">
                <div class="sitemap-content">
                    <figure class="sitemap-horizontal">
                        <ul class="administration">
                            <li>
                                <ul class="director">
                                    <li>
                                        <a href="javascript:void(0);" class="fw-semibold bg-primary-subtle text-primary"><span class="">Hybrix Admin</span></a>
                                        <ul class="subdirector">
                                            <li><a href="javascript:void(0);" class="fw-semibold"><span class="text-reset">Contact Us</span></a></li>
                                        </ul>
                                        <ul class="departments">
                                            <li><a href="javascript:void(0);" class="fw-semibold"><span class="text-reset">Main Pages</span></a></li>

                                            <li class="department">
                                                <a href="javascript:void(0);" class="fw-semibold bg-success-subtle text-success"><span class="">Account Management</span></a>
                                                <ul>
                                                    <li><a href="javascript:void(0);"><span>Sign Up</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Login</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Profile Settings</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Modify Reservation</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Cancel Reservation</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Write Reviews</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department">
                                                <a href="javascript:void(0);" class="fw-semibold bg-success-subtle text-success"><span class="">About Us</span></a>
                                                <ul>
                                                    <li><a href="javascript:void(0);"><span>Overview</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Connect Via Social Media</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Careers</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Team Members</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Policies</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department">
                                                <a href="javascript:void(0);" class="fw-semibold bg-success-subtle text-success"><span class="">Book a Trip</span></a>
                                                <ul>
                                                    <li><a href="javascript:void(0);"><span>Travel Details</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Reservation Process</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Payment Option</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Comfirmation</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department">
                                                <a href="javascript:void(0);" class="fw-semibold bg-success-subtle text-success"><span class="">Destination</span></a>
                                                <ul>
                                                    <li><a href="javascript:void(0);"><span>Architecture</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Art</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Entertainment</span></a></li>
                                                    <li>
                                                        <a href="javascript:void(0);"><span>History</span></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);"><span>Science</span></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);"><span>Sports</span></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);"><span>Music</span></a>
                                                    </li>
                                                    <li><a href="javascript:void(0);"><span>Tracking Camp</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department">
                                                <a href="javascript:void(0);" class="fw-semibold bg-success-subtle text-success"><span class="">Travel Tips</span></a>
                                                <ul>
                                                    <li><a href="javascript:void(0);"><span>General Travel</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Helpth Concerns</span></a></li>
                                                    <li><a href="javascript:void(0);"><span>Safety Measures</span></a></li>
                                                    <li>
                                                        <a href="javascript:void(0);"><span>FAQ's</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </figure>
                </div>
                <!--end sitemap-content-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Horizontal</h4>
            </div>
            <div class="card-body">
                <div class="hori-sitemap">
                    <ul class="list-unstyled mb-0">
                        <li class="p-0 parent-title"><a href="javascript: void(0);" class="fw-semibold fs-14">My Account</a></li>
                        <li>
                            <ul class="list-unstyled second-list row g-0 pt-0">
                                <li class="col-sm-3">
                                    <a href="javascript: void(0);" class="fw-semibold sub-title">About Us</a>
                                    <ul class="list-unstyled row g-0 second-list">
                                        <li class="col-sm-6">
                                            <a href="javascript: void(0);">Overview</a>
                                        </li>
                                        <li class="col-sm-6">
                                            <a href="javascript: void(0);">History</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <a href="javascript: void(0);" class="fw-semibold">My self-care Plan</a>
                                    <ul class="list-unstyled second-list pt-0">
                                        <li>
                                            <div>
                                                <a href="javascript: void(0);">Basic</a>
                                                <a href="javascript: void(0);">Early Physiotherapy</a>
                                                <a href="javascript: void(0);">Intermediate Physiotherapy</a>
                                                <a href="javascript: void(0);">Return to Normal Activity</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <a href="javascript: void(0);" class="fw-semibold sub-title">Support Us</a>
                                    <ul class="list-unstyled row g-0 sub-list">
                                        <li class="col-sm-6">
                                            <a href="javascript: void(0);">Contact Us</a>
                                        </li>
                                        <li class="col-sm-6">
                                            <a href="javascript: void(0);">Customer Services</a>
                                            <ul class="list-unstyled second-list">
                                                <li>
                                                    <div>
                                                        <a href="javascript: void(0);">Chat With Us</a>
                                                        <a href="javascript: void(0);">Connect Information</a>
                                                        <a href="javascript: void(0);">FAQ'S</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <a href="javascript: void(0);" class="fw-semibold">Terms & Conditions</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Vertical</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="verti-sitemap">
                            <ul class="list-unstyled mb-0">
                                <li class="p-0 parent-title"><a href="javascript: void(0);" class="fw-medium fs-14">Nancy Martino - Project Director</a>
                                </li>
                                <li>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary">Erica Kernan - Team Leader</a>
                                        </div>
                                        <ul class="second-list list-unstyled">
                                            <li>
                                                <a href="javascript: void(0);">Jason McQuaid - Member</a>
                                            </li>
                                            <li>
                                                <a href="javascript: void(0);">Elwood Arter - Member</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary">Mary Jones - Project Manager</a>
                                        </div>
                                        <ul class="second-list list-unstyled">
                                            <li><a href="javascript: void(0);">Jordyn Jones - Designer</a></li>
                                            <li><a href="javascript: void(0);">Ashlee Haney - Developer</a></li>
                                            <li><a href="javascript: void(0);">Rashad Charles - BackEnd Developer</a></li>
                                            <li>
                                                <a href="javascript: void(0);">Walter Newman - Frontend Developer</a>
                                            </li>
                                            <li><a href="javascript: void(0);">Adam Moss - Designer</a></li>
                                        </ul>
                                    </div>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary">Tilly Kent - Executive Manager</a>
                                        </div>
                                        <ul class="second-list list-unstyled">
                                            <li>
                                                <a href="javascript: void(0);">Tyler Porter - Account Executive</a>
                                            </li>
                                            <li>
                                                <a href="javascript: void(0);">Alicia Thompson - Sales Executive</a>
                                                <ul class="third-list list-unstyled">
                                                    <li><a href="javascript: void(0);">Jack Coates - Member</a></li>
                                                    <li><a href="javascript: void(0);">Owen Jarvis - Member</a></li>
                                                    <li><a href="javascript: void(0);">Ashlee Haney - Member</a></li>
                                                    <li><a href="javascript: void(0);">Archie Cook - Member</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary">Rachel Rose - HR</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end col-->

                    <div class="col-sm-6">
                        <div class="verti-sitemap">
                            <ul class="list-unstyled mb-0">
                                <li class="p-0 parent-title"><a href="javascript: void(0);" class="fw-medium fs-14">Hybrix</a></li>
                                <li>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary"><i class="ri-airplay-line me-1 align-bottom"></i> Dashboards</a>
                                        </div>
                                        <ul class="second-list list-unstyled">
                                            <li>
                                                <a href="javascript: void(0);">Analytics</a>
                                            </li>
                                            <li>
                                                <a href="javascript: void(0);">CRM</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary"><i class="ri-pencil-ruler-2-line me-1 align-bottom"></i> App Pages</a>
                                        </div>
                                        <ul class="second-list list-unstyled">
                                            <li><a href="javascript: void(0);">Calender</a></li>
                                            <li><a href="javascript: void(0);">Chat</a></li>
                                            <li><a href="javascript: void(0);">Email</a></li>
                                            <li><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li><a href="javascript: void(0);">Projects</a></li>
                                            <li><a href="javascript: void(0);">Tasks</a></li>
                                        </ul>
                                    </div>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary"><i class="ri-file-list-3-line me-1 align-bottom"></i> Pages</a>
                                        </div>
                                    </div>
                                    <div class="first-list">
                                        <div class="list-wrap">
                                            <a href="javascript: void(0);" class="fw-medium text-primary"><i class="ri-stack-line me-1 align-bottom"></i> Components</a>
                                        </div>
                                        <ul class="second-list list-unstyled">
                                            <li>
                                                <a href="javascript: void(0);">Base UI</a>
                                            </li>
                                            <li>
                                                <a href="javascript: void(0);">Advance UI</a>
                                                <ul class="third-list list-unstyled">
                                                    <li><a href="javascript: void(0);">Sweet Alerts</a></li>
                                                    <li><a href="javascript: void(0);">Range Slider</a></li>
                                                    <li><a href="javascript: void(0);">Nestable List</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
