@extends('layouts.master')
@section('title')
@lang('translation.search-results')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') Search Results @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-light pb-0 border-0">
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
                            <div class="position-relative flex-grow-1">
                                <input type="text" class="form-control border-0" placeholder="Search here.." value="Themesbrand">
                                <a class="btn btn-link link-secondary position-absolute end-0 top-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i class="ri-mic-fill"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="hstack gap-2">
                            <div class="dropdown">
                                <a class="fw-medium btn btn-ghost-primary btn-icon" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ph-gear-six fs-20"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                    <li><a class="dropdown-item" href="#">Search Settings</a></li>
                                    <li><a class="dropdown-item" href="#">Advanced Search</a></li>
                                    <li><a class="dropdown-item" href="#">Search History</a></li>
                                    <li><a class="dropdown-item" href="#">Search Help</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a class="dropdown-item" href="#">Dark Mode:Off</a></li>
                                </ul>
                            </div>
                            <a class="fw-medium btn btn-ghost-secondary btn-icon" href="#!" role="button">
                                <i class="ph-list-bold fs-20"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <ul class="nav nav-tabs nav-tabs-custom nav-secondary" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#all" role="tab" aria-selected="false">
                                All Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="images-tab" href="#images" role="tab" aria-selected="true">
                                Images
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#news" role="tab" aria-selected="false">
                                News
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#video" role="tab" aria-selected="false">
                                Videos
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="all" role="tabpanel">
                        <p class="text-muted mb-4">Showing results for "Themesbrand"</p>
                        <div class="row gy-3">
                            <div class="col-xxl-8">
                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">Themesbrand | Web design and development company</a></h5>
                                    <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <span class="fw-semibold">bootstrap 5</span> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design in your existing project using Hybrix it is very quick and easy as it is beautiful, adroit, and delivers the ultimate user experience.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>

                                <div class="mb-4">
                                    <h5 class="mb-3"><i class="ph-image-bold align-middle"></i> Images for Themesbrand</h5>

                                    <div class="row g-2 mb-3">
                                        <div class="col-lg-2">
                                            <a href="#!">
                                                <img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" class="img-fluid rounded" />
                                            </a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="#!">
                                                <img src="{{ URL::asset('build/images/small/img-3.jpg') }}" alt="" class="img-fluid rounded" />
                                            </a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="#!">
                                                <img src="{{ URL::asset('build/images/small/img-4.jpg') }}" alt="" class="img-fluid rounded" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="#!" class="border rounded-pill p-1 d-flex align-items-center">
                                            <img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt="" class="avatar-xs rounded-circle object-cover" />
                                            <span class="inline-block fw-medium px-2">themesbrand Hybrix</span>
                                        </a>
                                        <a href="#!" class="border rounded-pill p-1 d-flex align-items-center">
                                            <img src="{{ URL::asset('build/images/small/img-8.jpg') }}" alt="" class="avatar-xs rounded-circle object-cover" />
                                            <span class="inline-block fw-medium px-2">skote</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">Themesbrand - Portfolio - ThemeForest</a></h5>
                                    <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <span class="fw-semibold">bootstrap 5</span> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design in your existing project using Hybrix it is very quick and easy as it is beautiful, adroit, and delivers the ultimate user experience.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>
                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">themesbrand (ThemesBrand) - GitHub</a></h5>
                                    <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <span class="fw-semibold">bootstrap 5</span> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design in your existing project using Hybrix it is very quick and easy as it is beautiful, adroit, and delivers the ultimate user experience.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>
                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">Hybrix - Admin & Dashboard Templates by ThemesBrand</a></h5>
                                    <p class="text-muted mb-2">We design and develop web applications that matter. 5 posts. 41 followers. 37 following. Hybrix 13 in 1 Premium Multipurpose Admin & Dashboard Template.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>
                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">Themes Brand - Dribbble</a></h5>
                                    <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <span class="fw-semibold">bootstrap 5</span> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design in your existing project using Hybrix it is very quick and easy as it is beautiful, adroit, and delivers the ultimate user experience.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>
                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">Themesbrand - Portfolio | ThemeForest</a></h5>
                                    <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <span class="fw-semibold">bootstrap 5</span> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design in your existing project using Hybrix it is very quick and easy as it is beautiful, adroit, and delivers the ultimate user experience.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>
                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">Skote - Admin & Dashboard Templates</a></h5>
                                    <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <span class="fw-semibold">bootstrap 5</span> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design in your existing project using Hybrix it is very quick and easy as it is beautiful, adroit, and delivers the ultimate user experience.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>
                                <div class="mb-4">
                                    <h5><a href="javascript:void(0);">Themesbrand | Web design and development company</a></h5>
                                    <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <span class="fw-semibold">bootstrap 5</span> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design in your existing project using Hybrix it is very quick and easy as it is beautiful, adroit, and delivers the ultimate user experience.</p>
                                    <a href="#!" class="text-info">https://themesbrand.com/works</a>
                                </div>

                                <div class="d-md-flex align-items-center border-top pt-3 text-center text-md-start">
                                    <div class="flex-grow-1 mt-2">
                                        <div class="text-muted">Showing <span class="fw-semibold">8</span> of <span class="fw-semibold">125</span> Results</div>
                                    </div>
                                    <ul class="pagination pagination-separated justify-content-center mb-0 mt-2">
                                        <li class="page-item disabled">
                                            <a href="javascript:void(0);" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                        <li class="page-item active">
                                            <a href="javascript:void(0);" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">4</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">5</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xxl-4">
                                <div class="card overflow-hidden">
                                    <div class="card-header p-4">
                                        <div class="d-flex gap-3 align-items-center mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="25">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1">Themes Brand - IT Company</h5>
                                                <div class="d-flex align-items-center gap-2">
                                                    <p class="text-muted mb-0">5.0</p>
                                                    <div class="text-warning">
                                                        <i class="ph-star-fill"></i> <i class="ph-star-fill"></i> <i class="ph-star-fill"></i> <i class="ph-star-fill"></i> <i class="ph-star-fill"></i>
                                                    </div>
                                                    <p class="text-muted mb-0">1663 reviews</p>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="list-inline mb-2">
                                            <li class="list-inline-item">
                                                <a href="#!" class="btn btn-sm btn-soft-info"><i class="ph-globe-simple align-middle"></i> Website</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#!" class="btn btn-sm btn-soft-info"><i class="ph-map-pin align-middle"></i> Locations</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#!" class="btn btn-sm btn-soft-info"><i class="ph-phone align-middle"></i> Contact Us</a>
                                            </li>
                                        </ul>
                                        <p class="text-muted">Website designer in Surat, Gujarat</p>

                                        <p class="text-muted mb-0">We understand how crucial a good User Interface is. UI is what keeps a user engaged or detached from a website. So we craft something that users can’t resist <a href="#!">Read More</a>.</p>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-card table-responsive">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:110px;">Address</th>
                                                        <td class="text-muted">404-B, Deepkamal 2, Nr. Sarthana Zoo Park, Sarthana Jakat Naka, Surat, Gujarat 395006</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:110px;">Hours</th>
                                                        <td class="text-muted">24/7 Hours</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:110px;">Contact Us</th>
                                                        <td class="text-muted"><a href="#!" class="link-dark">078028 01866</a></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:110px;">Social Media</th>
                                                        <td>
                                                            <div class="hstack gap-3">
                                                                <a href="#!"><i class="bi bi-whatsapp"></i></a>
                                                                <a href="#!"><i class="bi bi-facebook"></i></a>
                                                                <a href="#!"><i class="bi bi-twitter"></i></a>
                                                                <a href="#!"><i class="bi bi-linkedin"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <div class="col-lg-6">
                                                <iframe class="w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.063273560225!2d72.89517741533432!3d21.229339386275537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f294a061655%3A0xae0998c532a11f96!2sThemes%20Brand%20-%20IT%20Company%20in%20Surat!5e0!3m2!1sen!2sin!4v1665380345709!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                            <div class="col-lg-6">
                                                <a href="#!">
                                                    <img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt="" class="img-fluid object-cover h-100">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="images" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="swiper images-menu mb-3">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Bootstrap"><img src="{{ URL::asset('build/images/small/img-12.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Website"><img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Responsive"><img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Design"><img src="{{ URL::asset('build/images/small/img-4.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="eCommerce"><img src="{{ URL::asset('build/images/small/img-3.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Templates"><img src="{{ URL::asset('build/images/small/img-5.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Admin Panal"><img src="{{ URL::asset('build/images/small/img-7.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Simple"><img src="{{ URL::asset('build/images/small/img-6.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dark"><img src="{{ URL::asset('build/images/small/img-11.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Users"><img src="{{ URL::asset('build/images/small/img-9.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div>
                                                <a href="javascript:void(0);" class="stretched-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Office"><img src="{{ URL::asset('build/images/small/img-10.jpg') }}" alt="" class="avatar-sm rounded-circle object-cover" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col">
                                <div class="imgs">
                                    <div class="row" id="gallery-element">
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Glasses and laptop from above</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">In enim justo rhoncus ut, imperdiet a venenatis vitae justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer bg-light">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Pretty fun and relaxed day</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">Donec quam felis ultricies nec, pellentesque eu, pretium quis sem. Nulla consequat massa quis enim. Donec pede justo fringilla vel, aliquet nec vulputate eget.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-3.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Photo was taken in Beach</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-4.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Drawing a sketch</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-5.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Working at a coffee shop</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-6.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Working at a coffee shop</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-7.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Arts & Culture</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">Lorem ipsum dolor sit amet consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-8.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Team work, work colleagues, working together</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">Aenean leo ligula porttitor eu consequat vitae, eleifend ac enim. Aliquam lorem ante, dapibus in viverra quis feugiat a tellus. Phasellus viverra nulla ut metus varius laoreet.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-9.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Textures & Patterns</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-10.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Solo trip to near by place mountain</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-11.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Cycling in the countryside</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card border-0 gallery-card cursor-pointer">
                                                <div>
                                                    <img src="{{ URL::asset('build/images/small/img-12.jpg') }}" alt="" class="card-img-top gallery-img" />
                                                </div>
                                                <div class="card-body">
                                                    <a href="#!">
                                                        <h5 class="overlay-caption card-caption-title text-truncate mb-0">Working at a coffee shop</h5>
                                                    </a>
                                                    <p class="card-caption-desc d-none">It will be as simple as Occidental in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4" id="overview-cardelem">
                                <div class="main-img card p-2" id="gallerycard-overview">
                                    <div class="position-relative">
                                        <button type="button" class="btn-close btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2" aria-label="Close"></button>
                                        <img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" id="current" class="img-fluid rounded" />
                                        <div class="position-absolute bottom-0 end-0 m-3 d-flex align-items-center gap-2">
                                            <div class="dropdown">
                                                <a href="#!" class="btn btn-icon btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ph-share-network fs-20"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item link-primary" href="#"><i class="ph-facebook-logo-bold align-middle me-1"></i> Facebook</a></li>
                                                    <li><a class="dropdown-item link-info" href="#"><i class="ph-twitter-logo-bold align-middle me-1"></i> Twitter</a></li>
                                                    <li><a class="dropdown-item link-danger" href="#"><i class="ph-envelope-bold align-middle me-1"></i> Email</a></li>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-icon btn-light" id="prev-btn"><i class="ph-caret-double-left-bold fs-20"></i></button>
                                            <button type="button" class="btn btn-icon btn-light" id="next-btn"><i class="ph-caret-double-right-bold fs-20"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="#!" class="link-success">themesbrand.com/portfolio</a>
                                        <a href="#!">
                                            <h5 class="mt-2 overview-title">Working at a coffee shop</h5>
                                        </a>
                                        <p class="text-muted overview-desc text-truncate-two-lines mb-0">We understand how crucial a good User Interface is. UI is what keeps a user engaged or detached from a website. So we craft something that users can’t resist <a href="#!">Read More</a>.</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <h5 class="flex-grow-1 mb-0">Related images</h5>
                                    <div class="flex-shrink-0">
                                        <a href="#!" class="text-decoration-underline">See More</a>
                                    </div>
                                </div>
                                <div class="row mt-3 g-3">
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0 text-truncate-two-lines">Glasses and laptop from above</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-3.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0 text-truncate-two-lines">Photo was taken in Beach</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0 text-truncate-two-lines">Pretty fun and relaxed day</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-10.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0 text-truncate-two-lines">Solo trip to near by place mountain</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-11.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0 text-truncate-two-lines">Team work, work colleagues, working together</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-12.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0">Cycling in the countryside</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-7.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0">Working at a coffee shop</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-8.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0">Arts & Culture</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="position-relative border-0">
                                            <div>
                                                <img src="{{ URL::asset('build/images/small/img-9.jpg') }}" alt="" class="img-fluid rounded" />
                                            </div>
                                            <div class="mt-2">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="overlay-caption mb-0">Textures & Patterns</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-ghost-success btn-load">
                                <span class="d-flex align-items-center">
                                    <span class="spinner-border flex-shrink-0" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </span>
                                    <span class="flex-grow-1 ms-2">
                                        Loading...
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="news" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> CNBC News</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">A mix of friends and strangers heading off to find an adventure</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> James Ballard</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 5 hrs ago</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> News TV</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">How to get creative in your work ?</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> Ruby Griffin</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 1 days ago</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-3.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> News TV</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">How to become a best sale marketer in a year!</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> Elwood Arter</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 5 days ago</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-4.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> News TV</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">Manage white space in responsive layouts ?</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> Elwood Arter</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 1 month ago</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-5.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> News TV</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">Stack designer Olivia Murphy offers freelancing advice</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> Elwood Arter</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 24 Nov, 2022</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-6.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> News TV</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">A day in the of a professional fashion designer</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> Elwood Arter</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 19 Nov, 2022</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-7.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> News TV</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">Design your apps in your own way</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> Elwood Arter</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 19 Nov, 2022</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-8.jpg') }}" alt="" width="125" class="rounded" />
                                            </div>
                                            <div class="flex-grow-1 ms-sm-4 mt-3 mt-sm-0">
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> News TV</li>
                                                </ul>
                                                <a href="javascript:void(0);">
                                                    <h5 class="mb-3">How apps is changing the IT world</h5>
                                                </a>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><i class="ph-user-bold text-primary align-middle me-1"></i> Elwood Arter</li>
                                                    <li class="list-inline-item"><i class="ph-clock-bold text-primary align-middle me-1"></i> 19 Nov, 2022</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->

                                <div class="d-flex align-items-center border-top pt-3">
                                    <div class="flex-grow-1">
                                        <div class="text-muted">Showing <span class="fw-semibold">8</span> of <span class="fw-semibold">125</span> Results</div>
                                    </div>
                                    <ul class="pagination pagination-separated justify-content-center mb-0">
                                        <li class="page-item disabled">
                                            <a href="javascript:void(0);" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                        <li class="page-item active">
                                            <a href="javascript:void(0);" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">4</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link">5</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="javascript:void(0);" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-4">
                                <div class="card overflow-hidden">
                                    <div class="card-header p-4">
                                        <div class="d-flex gap-3 align-items-center mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" width="125" class="rounded">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5>A mix of friends and strangers heading off to find an adventure</h5>
                                                <ul class="list-inline mb-2">
                                                    <li class="list-inline-item"><i class="ph-broadcast-bold me-1"></i> CNBC News</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <ul class="list-inline mb-2">
                                            <li class="list-inline-item">
                                                <a href="#!" class="btn btn-sm btn-soft-info"><i class="ph-globe-simple align-middle"></i> Website</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#!" class="btn btn-sm btn-soft-info"><i class="ph-map-pin align-middle"></i> Locations</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#!" class="btn btn-sm btn-soft-info"><i class="ph-phone align-middle"></i> Contact Us</a>
                                            </li>
                                        </ul>
                                        <p class="text-muted">Website designer in Surat, Gujarat</p>

                                        <p class="text-muted mb-0">We understand how crucial a good User Interface is. UI is what keeps a user engaged or detached from a website. So we craft something that users can’t resist Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on bootstrap 5 stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design. <a href="#!">Read More</a>.</p>

                                    </div>
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <div class="col-lg-6">
                                                <iframe class="w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.063273560225!2d72.89517741533432!3d21.229339386275537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f294a061655%3A0xae0998c532a11f96!2sThemes%20Brand%20-%20IT%20Company%20in%20Surat!5e0!3m2!1sen!2sin!4v1665380345709!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                            <div class="col-lg-6">
                                                <a href="#!">
                                                    <img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt="" class="img-fluid object-cover h-100">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="video" role="tabpanel">
                        <p class="text-muted mb-4">Showing results for "Themesbrand"</p>
                        <div class="row">
                            <div class="col-xxl-8 video-list">
                                <div class="list-element">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="flex-shrink-0">
                                            <iframe src="https://www.youtube.com/embed/GfSZtaoc5bw" title="YouTube video" allowfullscreen class="rounded"></iframe>
                                        </div>
                                        <div class="flex-grow-1 ms-sm-3 mt-2 mt-sm-0">
                                            <div class="position-relative">
                                                <p class="text-success mb-2">themesbrand.com/Hybrix/index.html</p>
                                                <a href="javascript:void(0);" class="stretched-link">
                                                    <h5 class="mb-3">Admin dashboard templates - Material Design for Hybrix</h5>
                                                </a>
                                            </div>
                                            <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <b>bootstrap 5</b> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design.</p>
                                            <ul class="list-unstyled d-flex align-items-center gap-3 text-muted fs-14 mb-0">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ph-youtube-logo-bold"></i>
                                                        </div>
                                                        <div class="flex-grow-1 fs-13 ms-1">
                                                            <a href="#!" class="fw-medium">Themesbrand</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><i class="ph-clock-bold align-middle"></i> 3 days ago</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end list-element-->

                                <div class="list-element mt-4">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="flex-shrink-0">
                                            <iframe src="https://www.youtube.com/embed/Z-fV2lGKnnU" title="YouTube video" allowfullscreen class="rounded"></iframe>
                                        </div>
                                        <div class="flex-grow-1 ms-sm-3 mt-2 mt-sm-0">
                                            <div class="position-relative">
                                                <p class="text-success mb-2">themesbrand.com/Hybrix/index.html</p>
                                                <a href="javascript:void(0);" class="stretched-link">
                                                    <h5 class="mb-3">Create Responsive Admin Dashboard using Html CSS</h5>
                                                </a>
                                            </div>
                                            <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <b>bootstrap 5</b> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design.</p>
                                            <ul class="list-unstyled d-flex align-items-center gap-3 text-muted fs-14 mb-0">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ph-youtube-logo-bold"></i>
                                                        </div>
                                                        <div class="flex-grow-1 fs-13 ms-1">
                                                            <a href="#!" class="fw-medium">Themesbrand</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><i class="ph-clock-bold align-middle"></i> 15 days ago</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end list-element-->

                                <div class="list-element mt-4">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="flex-shrink-0">
                                            <iframe src="https://www.youtube.com/embed/2RZQN_ko0iU" title="YouTube video" allowfullscreen class="rounded"></iframe>
                                        </div>
                                        <div class="flex-grow-1 ms-sm-3 mt-2 mt-sm-0">
                                            <div class="position-relative">
                                                <p class="text-success mb-2">themesbrand.com/Hybrix/index.html</p>
                                                <a href="javascript:void(0);" class="stretched-link">
                                                    <h5 class="mb-3">Hybrix - The Most Popular Bootstrap 5 HTML, Angular & React Js Admin</h5>
                                                </a>
                                            </div>
                                            <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <b>bootstrap 5</b> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design.</p>
                                            <ul class="list-unstyled d-flex align-items-center gap-3 text-muted fs-14 mb-0">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ph-youtube-logo-bold"></i>
                                                        </div>
                                                        <div class="flex-grow-1 fs-13 ms-1">
                                                            <a href="#!" class="fw-medium">Themesbrand</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><i class="ph-clock-bold align-middle"></i> 17 Nov, 2022</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end list-element-->

                                <div class="list-element mt-4">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="flex-shrink-0">
                                            <iframe src="https://www.youtube.com/embed/Z-fV2lGKnnU" title="YouTube video" allowfullscreen class="rounded"></iframe>
                                        </div>
                                        <div class="flex-grow-1 ms-sm-3 mt-2 mt-sm-0">
                                            <div class="position-relative">
                                                <p class="text-success mb-2">themesbrand.com/Hybrix/index.html</p>
                                                <a href="javascript:void(0);" class="stretched-link">
                                                    <h5 class="mb-3">Hybrix Admin Dashboard (website analytics) with Bootstrap 5</h5>
                                                </a>
                                            </div>
                                            <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <b>bootstrap 5</b> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design.</p>
                                            <ul class="list-unstyled d-flex align-items-center gap-3 text-muted fs-14 mb-0">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ph-youtube-logo-bold"></i>
                                                        </div>
                                                        <div class="flex-grow-1 fs-13 ms-1">
                                                            <a href="#!" class="fw-medium">Themesbrand</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><i class="ph-clock-bold align-middle"></i> 02 Nov, 2022</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end list-element-->

                                <div class="list-element mt-4">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="flex-shrink-0">
                                            <iframe src="https://www.youtube.com/embed/1y_kfWUCFDQ" title="YouTube video" allowfullscreen class="rounded"></iframe>
                                        </div>
                                        <div class="flex-grow-1 ms-sm-3 mt-2 mt-sm-0">
                                            <div class="position-relative">
                                                <p class="text-success mb-2">themesbrand.com/Hybrix/index.html</p>
                                                <a href="javascript:void(0);" class="stretched-link">
                                                    <h5 class="mb-3">Dashboard Admin Basics - YouTube</h5>
                                                </a>
                                            </div>
                                            <p class="text-muted mb-2">Hybrix admin is super flexible, powerful, clean, modern & responsive admin template based on <b>bootstrap 5</b> stable with unlimited possibilities. You can simply change to any layout or mode by changing a couple of lines of code. You can start small and large projects or update design.</p>
                                            <ul class="list-unstyled d-flex align-items-center gap-3 text-muted fs-14 mb-0">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ph-youtube-logo-bold"></i>
                                                        </div>
                                                        <div class="flex-grow-1 fs-13 ms-1">
                                                            <a href="#!" class="fw-medium">Themesbrand</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><i class="ph-clock-bold align-middle"></i> 30 Oct, 2022</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end list-element-->

                            </div>
                            <!--end col-->
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-ghost-success btn-load">
                                    <span class="d-flex align-items-center">
                                        <span class="spinner-border flex-shrink-0" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </span>
                                        <span class="flex-grow-1 ms-2">
                                            Load More
                                        </span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <!--end tab-pane-->
                </div>
                <!--end tab-content-->

            </div>
            <!--end card-body-->
        </div>
        <!--end card -->
    </div>
    <!--end card -->
</div>
<!--end row-->

@endsection
@section('script')

<script src="{{ URL::asset('build/libs/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/search-result.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
