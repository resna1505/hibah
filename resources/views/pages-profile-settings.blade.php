@extends('layouts.master')
@section('title')
@lang('translation.settings')
@endsection
@section('content')
<div class="row">
    <div class="col-xxl-12">
        <div class="card overflow-hidden profile-setting-img">
            <div class="profile-user rounded profile-basic" style="background-image: url('build/images/profile-bg.jpg');background-size: cover;background-position: center;">
                <div class="bg-overlay bg-primary"></div>
                <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                    <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input d-none">
                    <label for="profile-foreground-img-file-input" class="btn btn-light">
                        <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                    </label>
                </div>
            </div>

            <div class="card-body">
                <div class="position-relative mb-3">
                    <div class="mt-n5">
                        <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" alt="" class="avatar-lg rounded-circle p-1 mt-n4">
                    </div>
                </div>
                <div class="row justify-content-between gy-4">
                    <div class="col-xl-3 col-lg-5">
                        <div class="border border-dashed p-3 rounded-3">
                            <div class="d-flex align-items-center mb-4 pb-1">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Complete Your Profile</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="badge bg-light text-secondary"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                                </div>
                            </div>
                            <div class="progress animated-progress custom-progress progress-label">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                    <div class="label">30%</div>
                                </div>
                            </div>
                        </div>
                        <div class="border border-dashed p-3 rounded-3 mt-4">
                            <div class="d-flex align-items-center mb-3 pb-1">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Skills</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="badge bg-light text-secondary"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 fs-15">
                                <a href="javascript:void(0);" class="badge text-info bg-info-subtle">Photoshop</a>
                                <a href="javascript:void(0);" class="badge text-info bg-info-subtle">illustrator</a>
                                <a href="javascript:void(0);" class="badge text-info bg-info-subtle">HTML</a>
                                <a href="javascript:void(0);" class="badge text-info bg-info-subtle">CSS</a>
                                <a href="javascript:void(0);" class="badge text-info bg-info-subtle">Javascript</a>
                                <a href="javascript:void(0);" class="badge text-info bg-info-subtle">Php</a>
                                <a href="javascript:void(0);" class="badge text-info bg-info-subtle">Python</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-5">
                        <div>
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Portfolio</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-add-fill align-bottom me-1"></i> Add</a>
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-dark text-white">
                                        <i class="ri-github-fill"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" id="gitUsername" placeholder="Username" value="@edwarddiana">
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-primary">
                                        <i class="ri-global-fill"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com" value="www.themesbrand.com">
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-success">
                                        <i class="ri-dribbble-fill"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="dribbleName" placeholder="Username" value="@edward_diana">
                            </div>
                            <div class="d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-danger">
                                        <i class="ri-pinterest-fill"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="pinterestName" placeholder="Username" value="Edward Diana">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nav tabs -->
                <div class="row align-items-center mt-3 gy-3">
                    <div class="col-md order-1">
                        <ul class="nav nav-pills animation-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Personal Details</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#changePassword" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-list-unordered d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Changes Password</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#experience" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-price-tag-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Experience</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#privacy" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Privacy Policy</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-auto order-md-2">
                        <div class="flex-shrink-0">
                            <a href="pages-profile-settings" class="btn btn-secondary"><i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!--end col-->
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="firstnameInput" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstnameInput" placeholder="Enter your firstname" value="Edward">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="lastnameInput" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastnameInput" placeholder="Enter your lastname" value="Diana">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phonenumberInput" placeholder="Enter your phone number" value="+(254) 25462 32145">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="emailInput" placeholder="Enter your email" value="edwarddiana@hybrix.com">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="JoiningdatInput" class="form-label">Joining Date</label>
                                        <input type="text" class="form-control" data-provider="flatpickr" id="JoiningdatInput" data-date-format="d M, Y" data-deafult-date="24 Nov, 2021" placeholder="Select date" />
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="skillsInput" class="form-label">Skills</label>
                                        <select class="form-control" name="skillsInput" data-choices data-choices-text-unique-true multiple id="skillsInput">
                                            <option value="illustrator">Illustrator</option>
                                            <option value="photoshop">Photoshop</option>
                                            <option value="css">CSS</option>
                                            <option value="html">HTML</option>
                                            <option value="javascript" selected>Javascript</option>
                                            <option value="python">Python</option>
                                            <option value="php">PHP</option>
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="designationInput" class="form-label">Designation</label>
                                        <input type="text" class="form-control" id="designationInput" placeholder="Designation" value="Lead Designer / Developer">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="websiteInput1" class="form-label">Website</label>
                                        <input type="text" class="form-control" id="websiteInput1" placeholder="www.example.com" value="www.themesbrand.com" />
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="cityInput" class="form-label">City</label>
                                        <input type="text" class="form-control" id="cityInput" placeholder="City" value="Phoenix" />
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="countryInput" class="form-label">Country</label>
                                        <input type="text" class="form-control" id="countryInput" placeholder="Country" value="USA" />
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="zipcodeInput" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" minlength="5" maxlength="6" id="zipcodeInput" placeholder="Enter zipcode" value="00012">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="mb-3 pb-2">
                                        <label for="exampleFormControlTextarea" class="form-label">Description</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Enter your description" rows="3">Hi I'm Edward Diana,It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is European languages are members of the same family.</textarea>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Updates</button>
                                        <button type="button" class="btn btn-soft-success">Cancel</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        <form action="pages-profile-settings">
                            <div class="row g-2 justify-content-lg-between align-items-center">
                                <div class="col-lg-4">
                                    <div>
                                        <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="oldpasswordInput" placeholder="Enter current password">
                                            <button class="btn btn-link position-absolute top-0 end-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="auth-pass-inputgroup">
                                        <label for="password-input" class="form-label">New Password*</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control password-input" id="password-input" onpaste="return false" placeholder="Enter new password" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="auth-pass-inputgroup">
                                        <label for="confirm-password-input" class="form-label">Confirm Password*</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control password-input" onpaste="return false" id="confirm-password-input" placeholder="Confirm password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="confirm-password-input"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                    <div class="">

                                        <button type="submit" class="btn btn-success">Change Password</button>
                                    </div>
                                </div>

                                <!--end col-->

                                <div class="col-lg-12">
                                    <div class="card bg-light passwd-bg" id="password-contain">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <h5 class="fs-13">Password must contain:</h5>
                                            </div>
                                            <div class="">
                                                <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                                <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                                <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                                <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--end row-->
                        </form>
                        <div class="mt-4 mb-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Login History</h5>
                            <div class="">
                                <a href="javascript:void(0);" class="btn btn-secondary">All Logout</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-borderless align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Address</th>
                                                <th scope="col"><i class="ri-logout-box-r-line"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><i class="ri-smartphone-line me-2"></i>iPhone 12 Pro</td>
                                                <td>192.44.234.160</td>
                                                <td>12/12/2022</td>
                                                <td>Los Angeles, United States</td>
                                                <td><a href="#">Logout</a></td>

                                            </tr>

                                            <tr>
                                                <td><i class="ri-tablet-line me-2"></i>Apple iPad Pro</td>
                                                <td>192.44.234.162</td>
                                                <td>9/01/2022</td>
                                                <td>Phoenix, United States</td>
                                                <td><a href="#">Logout</a></td>
                                            </tr>

                                            <tr>
                                                <td><i class="ri-smartphone-line me-2"></i>Galaxy S21 Ultra 5G</td>
                                                <td>192.45.234.160</td>
                                                <td>25/02/2022</td>
                                                <td>Washington, United States</td>
                                                <td><a href="#">Logout</a></td>
                                            </tr>

                                            <tr>
                                                <td><i class="ri-macbook-line me-2"></i>Dell Inspiron 14</td>
                                                <td>192.40.234.160</td>
                                                <td>16/09/2022</td>
                                                <td>Phoenix, United States</td>
                                                <td><a href="#">Logout</a></td>
                                            </tr>

                                            <tr>
                                                <td><i class="ri-smartphone-line me-2"></i>iPhone 12 Pro</td>
                                                <td>192.44.236.160</td>
                                                <td>22/01/2022</td>
                                                <td>Conneticut, United States</td>
                                                <td><a href="#">Logout</a></td>

                                            </tr>

                                            <tr>
                                                <td><i class="ri-tablet-line me-2"></i>Apple iPad Pro</td>
                                                <td>190.44.234.160</td>
                                                <td>19/06/2022</td>
                                                <td>Los Angeles, United States</td>
                                                <td><a href="#">Logout</a></td>

                                            </tr>

                                            <tr>
                                                <td><i class="ri-smartphone-line me-2"></i>Galaxy S21 Ultra 5G</td>
                                                <td>194.44.235.160</td>
                                                <td>30/08/2022</td>
                                                <td>Conneticut, United States</td>
                                                <td><a href="#">Logout</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="experience" role="tabpanel">
                        <form>
                            <div id="newlink">
                                <div id="1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="jobTitle" class="form-label">Job Title</label>
                                                <input type="text" class="form-control" id="jobTitle" placeholder="Job title" value="Lead Designer / Developer">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="companyName" class="form-label">Company Name</label>
                                                <input type="text" class="form-control" id="companyName" placeholder="Company name" value="Themesbrand">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="experienceYear" class="form-label">Experience Years</label>
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <select class="form-control" data-choices data-choices-search-false name="experienceYear" id="experienceYear">
                                                            <option value="">Select years</option>
                                                            <option value="Choice 1">2001</option>
                                                            <option value="Choice 2">2002</option>
                                                            <option value="Choice 3">2003</option>
                                                            <option value="Choice 4">2004</option>
                                                            <option value="Choice 5">2005</option>
                                                            <option value="Choice 6">2006</option>
                                                            <option value="Choice 7">2007</option>
                                                            <option value="Choice 8">2008</option>
                                                            <option value="Choice 9">2009</option>
                                                            <option value="Choice 10">2010</option>
                                                            <option value="Choice 11">2011</option>
                                                            <option value="Choice 12">2012</option>
                                                            <option value="Choice 13">2013</option>
                                                            <option value="Choice 14">2014</option>
                                                            <option value="Choice 15">2015</option>
                                                            <option value="Choice 16">2016</option>
                                                            <option value="Choice 17" selected>2017</option>
                                                            <option value="Choice 18">2018</option>
                                                            <option value="Choice 19">2019</option>
                                                            <option value="Choice 20">2020</option>
                                                            <option value="Choice 21">2021</option>
                                                            <option value="Choice 22">2022</option>
                                                        </select>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-auto align-self-center">
                                                        to
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-5">
                                                        <select class="form-control" data-choices data-choices-search-false name="choices-single-default2">
                                                            <option value="">Select years</option>
                                                            <option value="Choice 1">2001</option>
                                                            <option value="Choice 2">2002</option>
                                                            <option value="Choice 3">2003</option>
                                                            <option value="Choice 4">2004</option>
                                                            <option value="Choice 5">2005</option>
                                                            <option value="Choice 6">2006</option>
                                                            <option value="Choice 7">2007</option>
                                                            <option value="Choice 8">2008</option>
                                                            <option value="Choice 9">2009</option>
                                                            <option value="Choice 10">2010</option>
                                                            <option value="Choice 11">2011</option>
                                                            <option value="Choice 12">2012</option>
                                                            <option value="Choice 13">2013</option>
                                                            <option value="Choice 14">2014</option>
                                                            <option value="Choice 15">2015</option>
                                                            <option value="Choice 16">2016</option>
                                                            <option value="Choice 17">2017</option>
                                                            <option value="Choice 18">2018</option>
                                                            <option value="Choice 19">2019</option>
                                                            <option value="Choice 20" selected>2020</option>
                                                            <option value="Choice 21">2021</option>
                                                            <option value="Choice 22">2022</option>
                                                        </select>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="jobDescription" class="form-label">Job Description</label>
                                                <textarea class="form-control" id="jobDescription" rows="3" placeholder="Enter description">You always want to make sure that your fonts work well together and try to limit the number of fonts you use to three or less. Experiment and play around with the fonts that you already have in the software you're working with reputable font websites. </textarea>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="hstack gap-2 justify-content-end">
                                            <a class="btn btn-success" href="javascript:deleteEl(1)">Delete</a>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                            <div id="newForm" style="display: none;">

                            </div>
                            <div class="col-lg-12">
                                <div class="hstack gap-2">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="javascript:new_link()" class="btn btn-primary">Add New</a>
                                </div>
                            </div>
                            <!--end col-->
                        </form>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="privacy" role="tabpanel">
                        <div class="mb-4 pb-2">
                            <h5 class="card-title text-decoration-underline mb-3">Security:</h5>
                            <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                <div class="flex-grow-1">
                                    <h6 class="fs-14 mb-1">Two-factor Authentication</h6>
                                    <p class="text-muted">Two-factor authentication is an enhanced security meansur. Once enabled, you'll be required to give two types of identification when you log into Google Authentication and SMS are Supported.</p>
                                </div>
                                <div class="flex-shrink-0 ms-sm-3">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary">Enable Two-facor Authentication</a>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                <div class="flex-grow-1">
                                    <h6 class="fs-14 mb-1">Secondary Verification</h6>
                                    <p class="text-muted">The first factor is a password and the second commonly includes a text with a code sent to your smartphone, or biometrics using your fingerprint, face, or retina.</p>
                                </div>
                                <div class="flex-shrink-0 ms-sm-3">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary">Set up secondary method</a>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                <div class="flex-grow-1">
                                    <h6 class="fs-14 mb-1">Backup Codes</h6>
                                    <p class="text-muted mb-sm-0">A backup code is automatically generated for you when you turn on two-factor authentication through your iOS or Android Twitter app. You can also generate a backup code on twitter.com.</p>
                                </div>
                                <div class="flex-shrink-0 ms-sm-3">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary">Generate backup codes</a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="card-title text-decoration-underline mb-3">Application Notifications:</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex">
                                    <div class="flex-grow-1">
                                        <label for="directMessage" class="form-check-label fs-14">Direct messages</label>
                                        <p class="text-muted">Messages from people you follow</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="directMessage" checked />
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mt-2">
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fs-14" for="desktopNotification">
                                            Show desktop notifications
                                        </label>
                                        <p class="text-muted">Choose the option you want as your default setting. Block a site: Next to "Not allowed to send notifications," click Add.</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="desktopNotification" checked />
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mt-2">
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fs-14" for="emailNotification">
                                            Show email notifications
                                        </label>
                                        <p class="text-muted"> Under Settings, choose Notifications. Under Select an account, choose the account to enable notifications for. </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="emailNotification" />
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mt-2">
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fs-14" for="chatNotification">
                                            Show chat notifications
                                        </label>
                                        <p class="text-muted">To prevent duplicate mobile notifications from the Gmail and Chat apps, in settings, turn off Chat notifications.</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="chatNotification" />
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mt-2">
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fs-14" for="purchaesNotification">
                                            Show purchase notifications
                                        </label>
                                        <p class="text-muted">Get real-time purchase alerts to protect yourself from fraudulent charges.</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="purchaesNotification" />
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="card-title text-decoration-underline mb-3">Delete This Account:</h5>
                            <p class="text-muted">Go to the Data & Privacy section of your profile Account. Scroll to "Your data & privacy options." Delete your Profile Account. Follow the instructions to delete your account :</p>
                            <div>
                                <input type="password" class="form-control" id="passwordInput" placeholder="Enter your password" value="make@321654987" style="max-width: 265px;">
                            </div>
                            <div class="hstack gap-2 mt-3">
                                <a href="javascript:void(0);" class="btn btn-soft-danger">Close & Delete This Account</a>
                                <a href="javascript:void(0);" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </div>
                    <!--end tab-pane-->
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/passowrd-create.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
