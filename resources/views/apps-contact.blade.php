@extends('layouts.master')
@section('title') @lang('translation.contact') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card mt-n4 mx-n4 border-0 rounded-0 bg-primary-subtle">
            <div class="card-body pb-0 px-4">
                <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
                    <div class="col-lg-4">
                        <h4 class="mb-0">Contacts</h4>
                    </div>
                    <div class="col-lg-4">
                        <div class="search-box">
                            <input type="text" class="form-control border-0" id="searchResultList" placeholder="Search for name or number..." autocomplete="off">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>

<div class="row mt-n5">
    <div class="col-lg-3">
        <div class="card" style="min-height: calc(100vh - 70px - 60px - 142px);">
            <div class="card-body">
                <button type="button" class="btn btn-primary w-100 addContact-modal" data-bs-toggle="modal" data-bs-target="#addContactModal"><i class="bi bi-plus align-middle"></i> Add Contact</button>
                <div class="mt-3 mx-n4 px-4 contact-sidebar-menu" data-simplebar>
                    <ul class="list-unstyled contact-menu-list">
                        <li>
                            <a href="#!" class="active"><i class="ri-folder-2-line align-bottom me-2"></i> <span class="menu-list-link" data-tab="all">All Contacts</span></a>
                        </li>
                        <li>
                            <a href="#!"><i class="ri-history-line align-bottom me-2"></i> <span class="menu-list-link" data-tab="frequently">Frequently Contacted</span></a>
                        </li>
                        <li>
                            <a href="#!"><i class="ri-star-line align-bottom me-2"></i> <span class="menu-list-link" data-tab="important">Important</span></a>
                        </li>
                        <li>
                            <a href="#!"><i class="ri-group-line align-bottom me-2"></i> <span class="menu-list-link" data-tab="groups">Groups</span></a>
                        </li>
                        <li>
                            <a href="#!"><i class="ri-delete-bin-line align-bottom me-2"></i> <span class="menu-list-link" data-tab="trash">Deleted</span></a>
                        </li>
                    </ul>

                    <p class="text-muted mb-2">Labels</p>
                    <ul class="list-unstyled contact-menu-list">
                        <li>
                            <a href="#!" class="text-body"><i class="bi bi-tag-fill align-middle me-2 text-secondary"></i> <span class="menu-list-link" data-label="Friends">Friends</span></a>
                        </li>
                        <li>
                            <a href="#!" class="text-body"><i class="bi bi-tag-fill align-middle me-2 text-success"></i> <span class="menu-list-link" data-label="Family">Family</span></a>
                        </li>
                        <li>
                            <a href="#!" class="text-body"><i class="bi bi-tag-fill align-middle me-2 text-info"></i> <span class="menu-list-link" data-label="Business">Business</span></a>
                        </li>
                        <li>
                            <a href="#!" class="text-body"><i class="bi bi-tag-fill align-middle me-2 text-danger"></i> <span class="menu-list-link" data-label="Imported">Imported</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div id="recomended-jobs" class="table-card"></div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->


<div class="offcanvas offcanvas-end" tabindex="-1" id="viewContactoffcanvas" aria-labelledby="viewContactoffcanvasLabel">
    <div class="offcanvas-header">
        <ul class="list-unstyled hstack gap-2 mb-0 justify-content-end w-100 me-2">
            <li>
                <a href="#!" class="btn btn-sm btn-icon btn-ghost-info"><i class="ri-pushpin-line fs-15"></i></a>
            </li>
            <li>
                <a href="#!" class="btn btn-sm btn-icon btn-ghost-success"><i class="ri-edit-line fs-15"></i></a>
            </li>
            <li>
                <a href="#!" class="btn btn-sm btn-icon btn-ghost-secondary"><i class="ri-more-2-fill fs-15"></i></a>
            </li>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="text-center">
            <div class="mb-3">
                <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt="" class="avatar-lg d-block mx-auto rounded-circle overview-userimg" />
            </div>
            <h5 class="offcanvas-title mb-2 overview-name" id="viewContactoffcanvasLabel">Danielle Wright</h5>
            <p class="text-muted mb-4 overview-location">Ukraine</p>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th scope="row">Name</th>
                        <td class="overview-name">Danielle Wright</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone Number</th>
                        <td class="overview-phone">+(380) 39 489 7330</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td class="overview-email">danielle@example.com</td>
                    </tr>
                    <tr>
                        <th scope="row">Birthday</th>
                        <td>19 Nov, 1999</td>
                    </tr>
                    <tr>
                        <th scope="row">Gender</th>
                        <td>Male</td>
                    </tr>
                    <tr>
                        <th scope="row">Location</th>
                        <td class="overview-location">Ukraine</td>
                    </tr>
                    <tr>
                        <th scope="row">Label</th>
                        <td class="overview-tags">Family</td>
                    </tr>
                    <tr>
                        <th scope="row">Age</th>
                        <td>25</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="hstack gap-2">
            <button type="button" class="btn btn-secondary w-100">Audio Call</button>
            <button type="button" class="btn btn-info w-100">Video Call</button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header p-4 pb-0 m-2">
                <h1 class="modal-title fs-5 fw-bold" id="addContactModalLabel">Add Contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="addContact-btnClose" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 p-4">
                <form id="contactlist-form" autocomplete="off" class="needs-validation p-2" novalidate>
                    <input type="hidden" id="contactid-input" class="form-control" value="">
                    <div class="text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <div class="position-absolute bottom-0 end-0">
                                <label for="contact-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select contact user Image">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                            <i class="ri-image-fill"></i>
                                        </div>
                                    </div>
                                </label>
                                <input class="form-control d-none" value="" id="contact-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                            </div>
                            <div class="avatar-lg">
                                <div class="avatar-title bg-light rounded-circle">
                                    <img src="{{ URL::asset('build/images/users/user-dummy-img.jpg') }}" id="contact-img" class="avatar-md rounded-circle" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" required />
                            <div class="invalid-feedback">
                                Please enter a name.
                            </div>
                        </div>
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required />
                            <div class="invalid-feedback">
                                Please enter an email.
                            </div>
                        </div>
                        <div>
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="phone" class="form-control" id="phoneNumber" placeholder="Enter your number" required />
                            <div class="invalid-feedback">
                                Please enter phone number.
                            </div>
                        </div>
                        <div>
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" id="country" required>
                                <option value="">Select Country</option>
                                <option value="Angola">Angola</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Spain">Spain</option>
                                <option value="USA">USA</option>
                                <option value="Ukraine">Ukraine</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a country.
                            </div>
                        </div>
                        <div>
                            <label for="label" class="form-label">Label</label>
                            <select class="form-select" id="label" required>
                                <option value="">Select Label</option>
                                <option value="Family">Family</option>
                                <option value="Friends">Friends</option>
                                <option value="Business">Business</option>
                                <option value="Imported">Imported</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a label.
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-secondary" id="addNewContact">Add Contact</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- removeContactModal -->
<div id="removeContactModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="removeContactModalbtn-close"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-4"></i>
                    </div>
                    <div class="mt-4 fs-15">
                        <h4 class="mb-1">Remove Contact ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this contact ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-contact">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/tom-select/js/tom-select.base.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/gridjs/gridjs.umd.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/contact.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection
