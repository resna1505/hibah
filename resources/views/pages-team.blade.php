@extends('layouts.master')
@section('title')
@lang('translation.settings')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') Team @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-sm-4">
                        <div class="search-box">
                            <input type="text" class="form-control" id="searchMemberList" placeholder="Search for name or designation...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-sm-auto ms-auto">
                        <div class="list-grid-nav hstack gap-1">
                            <button class="btn btn-info addMembers-modal" data-bs-toggle="modal" data-bs-target="#addmemberModal"><i class="ri-add-fill me-1 align-bottom"></i> Add Members</button>
                            <button type="button" class="btn btn-soft-primary btn-icon fs-14"><i class="ri-grid-fill"></i></button>
                            <button type="button" class="btn btn-soft-primary  btn-icon fs-14"><i class="ri-list-unordered"></i></button>
                            <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-soft-secondary btn-icon fs-14"><i class="ri-more-2-fill"></i></button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                <li><a class="dropdown-item" href="#">All</a></li>
                                <li><a class="dropdown-item" href="#">Last Week</a></li>
                                <li><a class="dropdown-item" href="#">Last Month</a></li>
                                <li><a class="dropdown-item" href="#">Last Year</a></li>
                            </ul>
                        </div>
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

<div class="row" id="team-member-list"></div>
<!--end row-->

<div class="row g-0 justify-content-end mb-4" id="pagination-element">
    <!-- end col -->
    <div class="col-sm-6">
        <div class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
            <div class="page-item">
                <a href="javascript:void(0);" class="page-link" id="page-prev">Previous</a>
            </div>
            <span id="page-num" class="pagination"></span>
            <div class="page-item">
                <a href="javascript:void(0);" class="page-link" id="page-next">Next</a>
            </div>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-12">
        <h5 class="card-title mb-4">Basic Example</h5>
    </div>
</div>

<div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1">
    <div class="col">
        <div class="card">
            <div class="card-body p-4 m-2">
                <div class="row mb-4 pb-2">
                    <div class="col">
                        <div class="flex-shrink-0 me-2">
                            <button type="button" class="btn btn-outline-danger custom-toggle rounded-circle btn-icon btn-sm" data-bs-toggle="button">
                                <span class="icon-on"><i class="ri-heart-line fs-14"></i></span>
                                <span class="icon-off"><i class="ri-heart-fill fs-14"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="col text-end dropdown"> <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill fs-17"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item edit-list" href="#addmemberModal" data-bs-toggle="modal" data-edit-id="12"><i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit</a></li>
                            <li><a class="dropdown-item remove-list" href="#removeMemberModal" data-bs-toggle="modal" data-remove-id="12"><i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove</a></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <img src="{{ URL::asset('build/images/users/avatar-9.jpg') }}" alt="" class="avatar-md rounded-3" />
                </div>
                <div class="text-center">
                    <a href="#member-overview" data-bs-toggle="offcanvas">
                        <h5 class="fs-17">Jordan Martino</h5>
                    </a>
                    <p class="text-muted mb-0">jordan.martino@hybrix.com</p>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col">
        <div class="card">
            <div class="card-body p-4 m-2">
                <div class="row mb-4 pb-2">
                    <div class="col">
                        <div class="flex-shrink-0 me-2">
                            <button type="button" class="btn btn-outline-danger custom-toggle rounded-circle btn-icon btn-sm" data-bs-toggle="button">
                                <span class="icon-on"><i class="ri-heart-line fs-14"></i></span>
                                <span class="icon-off"><i class="ri-heart-fill fs-14"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="col text-end dropdown"> <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill fs-17"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item edit-list" href="#addmemberModal" data-bs-toggle="modal" data-edit-id="12"><i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit</a></li>
                            <li><a class="dropdown-item remove-list" href="#removeMemberModal" data-bs-toggle="modal" data-remove-id="12"><i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove</a></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <img src="{{ URL::asset('build/images/users/avatar-10.jpg') }}" alt="" class="avatar-md rounded-3" />
                </div>
                <div class="text-center">
                    <a href="#member-overview" data-bs-toggle="offcanvas">
                        <h5 class="fs-17">Nancy Martino</h5>
                    </a>
                    <p class="text-muted mb-0">nancy.martino@hybrix.com</p>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col">
        <div class="card">
            <div class="card-body p-4 m-2">
                <div class="row mb-4 pb-2">
                    <div class="col">
                        <div class="flex-shrink-0 me-2">
                            <button type="button" class="btn btn-outline-danger custom-toggle rounded-circle btn-icon btn-sm" data-bs-toggle="button">
                                <span class="icon-on"><i class="ri-heart-line fs-14"></i></span>
                                <span class="icon-off"><i class="ri-heart-fill fs-14"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="col text-end dropdown"> <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill fs-17"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item edit-list" href="#addmemberModal" data-bs-toggle="modal" data-edit-id="12"><i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit</a></li>
                            <li><a class="dropdown-item remove-list" href="#removeMemberModal" data-bs-toggle="modal" data-remove-id="12"><i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove</a></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" alt="" class="avatar-md rounded-3" />
                </div>
                <div class="text-center">
                    <a href="#member-overview" data-bs-toggle="offcanvas">
                        <h5 class="fs-17">Pieter Novitsky</h5>
                    </a>
                    <p class="text-muted mb-0">pieter.novitsky@hybrix.com</p>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col">
        <div class="card">
            <div class="card-body p-4 m-2">
                <div class="row mb-4 pb-2">
                    <div class="col">
                        <div class="flex-shrink-0 me-2">
                            <button type="button" class="btn btn-outline-danger custom-toggle rounded-circle btn-icon btn-sm active" data-bs-toggle="button">
                                <span class="icon-on"><i class="ri-heart-line fs-14"></i></span>
                                <span class="icon-off"><i class="ri-heart-fill fs-14"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="col text-end dropdown"> <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill fs-17"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item edit-list" href="#addmemberModal" data-bs-toggle="modal" data-edit-id="12"><i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit</a></li>
                            <li><a class="dropdown-item remove-list" href="#removeMemberModal" data-bs-toggle="modal" data-remove-id="12"><i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove</a></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt="" class="avatar-md rounded-3" />
                </div>
                <div class="text-center">
                    <a href="#member-overview" data-bs-toggle="offcanvas">
                        <h5 class="fs-17">Allyson Booker</h5>
                    </a>
                    <p class="text-muted mb-0">allyson.booker@hybrix.com</p>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col">
        <div class="card">
            <div class="card-body p-4 m-2">
                <div class="row mb-4 pb-2">
                    <div class="col">
                        <div class="flex-shrink-0 me-2">
                            <button type="button" class="btn btn-outline-danger custom-toggle rounded-circle btn-icon btn-sm" data-bs-toggle="button">
                                <span class="icon-on"><i class="ri-heart-line fs-14"></i></span>
                                <span class="icon-off"><i class="ri-heart-fill fs-14"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="col text-end dropdown"> <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill fs-17"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item edit-list" href="#addmemberModal" data-bs-toggle="modal" data-edit-id="12"><i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit</a></li>
                            <li><a class="dropdown-item remove-list" href="#removeMemberModal" data-bs-toggle="modal" data-remove-id="12"><i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove</a></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}" alt="" class="avatar-md rounded-3" />
                </div>
                <div class="text-center">
                    <a href="#member-overview" data-bs-toggle="offcanvas">
                        <h5 class="fs-17">Cristofer Leblanc</h5>
                    </a>
                    <p class="text-muted mb-0">cristofer.leblanc@hybrix.com</p>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<!-- Modal -->
<div class="modal fade" id="addmemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-4 pb-0">
                <h5 class="modal-title" id="createMemberLabel">Add New Member</h5>
                <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form autocomplete="off" id="memberlist-form" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" id="memberid-input" class="form-control" value="">
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute top-100 start-100 translate-middle">
                                        <label for="member-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Member Image">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input class="form-control d-none" value="" id="member-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                    </div>
                                    <div class="avatar-lg">
                                        <div class="avatar-title bg-light rounded-3">
                                            <img src="{{ URL::asset('build/images/users/user-dummy-img.jpg') }}" id="member-img" class="avatar-md rounded-3 h-auto" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="teammembersName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="teammembersName" placeholder="Enter name" required>
                                <div class="invalid-feedback">Please Enter a member name.</div>
                            </div>

                            <div class="mb-4">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" placeholder="Enter designation" required>
                                <div class="invalid-feedback">Please Enter a designation.</div>
                            </div>

                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="addNewMember">Add Member</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->

<div class="offcanvas offcanvas-end border-0" tabindex="-1" id="member-overview">
    <!--end offcanvas-header-->
    <div class="offcanvas-body profile-offcanvas p-0">
        <div class="p-3">
            <div class="team-settings">
                <div class="row">
                    <div class="col">
                        <div class="bookmark-icon flex-shrink-0 me-2">
                            <input type="checkbox" id="favourite13" class="bookmark-input bookmark-hide">
                            <label for="favourite13" class="btn-star">
                                <svg width="20" height="20">
                                    <use xlink:href="#icon-star" />
                                </svg>
                            </label>
                        </div>
                    </div>
                    <div class="col text-end dropdown">
                        <a href="javascript:void(0);" id="dropdownMenuLink14" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill fs-17"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink14">
                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-line me-2 align-middle"></i>View</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-line me-2 align-middle"></i>Favorites</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <div class="p-3 text-center">
            <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt="" class="avatar-lg img-thumbnail rounded-4 mx-auto profile-img">
            <div class="mt-3">
                <h5 class="fs-15 profile-name">Nancy Martino</h5>
                <p class="text-muted profile-designation">Team Leader & HR</p>
            </div>
            <div class="hstack gap-2 justify-content-center mt-4">
                <div class="avatar-xs">
                    <a href="javascript:void(0);" class="avatar-title bg-secondary-subtle text-secondary rounded fs-16">
                        <i class="ri-facebook-fill"></i>
                    </a>
                </div>
                <div class="avatar-xs">
                    <a href="javascript:void(0);" class="avatar-title bg-success-subtle text-success rounded fs-16">
                        <i class="ri-slack-fill"></i>
                    </a>
                </div>
                <div class="avatar-xs">
                    <a href="javascript:void(0);" class="avatar-title bg-info-subtle text-info rounded fs-16">
                        <i class="ri-linkedin-fill"></i>
                    </a>
                </div>
                <div class="avatar-xs">
                    <a href="javascript:void(0);" class="avatar-title bg-danger-subtle text-danger rounded fs-16">
                        <i class="ri-dribbble-fill"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row g-0 text-center bg-light">
            <div class="col-6">
                <div class="p-3 border border-dashed border-start-0">
                    <h5 class="mb-1 profile-project">124</h5>
                    <p class="text-muted mb-0">Projects</p>
                </div>
            </div>
            <!--end col-->
            <div class="col-6">
                <div class="p-3 border border-dashed border-start-0">
                    <h5 class="mb-1 profile-task">81</h5>
                    <p class="text-muted mb-0">Tasks</p>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        <div class="p-3">
            <h5 class="fs-15 mb-3">Personal Details</h5>
            <div class="mb-3">
                <p class="text-muted text-uppercase fw-semibold fs-12 mb-2"><i class="ri-phone-fill align-middle fs-14 me-1"></i> Number</p>
                <h6 class="profile-contact">+(256) 2451 8974</h6>
            </div>
            <div class="mb-3">
                <p class="text-muted text-uppercase fw-semibold fs-12 mb-2"><i class="ri-mail-open-fill align-middle fs-14 me-1"></i> Email</p>
                <h6 class="profile-email">nancymartino@email.com</h6>
            </div>
            <div>
                <p class="text-muted text-uppercase fw-semibold fs-12 mb-2"><i class="ri-map-pin-fill align-middle fs-14 me-1"></i> Location</p>
                <h6 class="mb-0">Carson City - USA</h6>
            </div>
        </div>
        <div class="p-3 border-top">
            <h5 class="fs-15 mb-4">File Manager</h5>
            <div class="d-flex mb-3">
                <div class="flex-shrink-0 avatar-xs">
                    <div class="avatar-title bg-danger-subtle text-danger rounded fs-16">
                        <i class="ri-image-2-line"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><a href="javascript:void(0);">Images</a></h6>
                    <p class="text-muted mb-0">4469 Files</p>
                </div>
                <div class="text-muted">12 GB</div>
            </div>
            <div class="d-flex mb-3">
                <div class="flex-shrink-0 avatar-xs">
                    <div class="avatar-title bg-secondary-subtle text-secondary rounded fs-16">
                        <i class="ri-file-zip-line"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><a href="javascript:void(0);">Documents</a></h6>
                    <p class="text-muted mb-0">46 Files</p>
                </div>
                <div class="text-muted">
                    3.46 GB
                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="flex-shrink-0 avatar-xs">
                    <div class="avatar-title bg-success-subtle text-success rounded fs-16">
                        <i class="ri-live-line"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><a href="javascript:void(0);">Media</a></h6>
                    <p class="text-muted mb-0">124 Files</p>
                </div>
                <div class="text-muted">
                    4.3 GB
                </div>
            </div>
            <div class="d-flex">
                <div class="flex-shrink-0 avatar-xs">
                    <div class="avatar-title bg-primary-subtle text-primary rounded fs-16">
                        <i class="ri-error-warning-line"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><a href="javascript:void(0);">Others</a></h6>
                    <p class="text-muted mb-0">18 Files</p>
                </div>
                <div class="text-muted">
                    846 MB
                </div>
            </div>
        </div>
    </div>
    <!--end offcanvas-body-->
    <div class="offcanvas-foorter border p-3 hstack gap-3 text-center position-relative">
        <button class="btn btn-light w-100"><i class="ri-question-answer-fill align-bottom ms-1"></i> Send Message</button>
        <a href="pages-profile" class="btn btn-primary w-100"><i class="ri-user-3-fill align-bottom ms-1"></i> View Profile</a>
    </div>
</div>
<!--end offcanvas-->

<!-- start delete modal -->
<div id="removeMemberModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-removeMemberModal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this member ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-item">Yes, Delete It!</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--end delete modal -->


@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/team.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
