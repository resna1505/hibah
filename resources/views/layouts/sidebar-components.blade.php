<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="26">
            </span>
        </a>
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="24">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">@lang('translation.components')</span></li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="components">
                        <i class="bi bi-command"></i> <span data-key="t-overview">@lang('translation.overview')</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUI">
                        <i class="bi bi-radioactive"></i> <span data-key="t-bootstrap-ui">@lang('translation.base-ui')</span>
                    </a>
                    <div class="collapse menu-dropdown mega-dropdown-menu" id="sidebarUI">
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="ui-alerts" class="nav-link" data-key="t-alerts">@lang('translation.alerts')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-badges" class="nav-link" data-key="t-badges">@lang('translation.badges')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-buttons" class="nav-link" data-key="t-buttons">@lang('translation.buttons')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-colors" class="nav-link" data-key="t-colors">@lang('translation.colors')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-cards" class="nav-link" data-key="t-cards">@lang('translation.cards')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-carousel" class="nav-link" data-key="t-carousel">@lang('translation.carousel')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-dropdowns" class="nav-link" data-key="t-dropdowns">@lang('translation.dropdowns')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-grid" class="nav-link" data-key="t-grid">@lang('translation.grid')</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="ui-images" class="nav-link" data-key="t-images">@lang('translation.images')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-tabs" class="nav-link" data-key="t-tabs">@lang('translation.tabs')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-accordions" class="nav-link" data-key="t-accordion-collapse">@lang('translation.accordion-collapse') </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-modals" class="nav-link" data-key="t-modals">@lang('translation.modals') </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-offcanvas" class="nav-link" data-key="t-offcanvas">@lang('translation.offcanvas')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-placeholders" class="nav-link" data-key="t-placeholders">@lang('translation.placeholders')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-progress" class="nav-link" data-key="t-progress">@lang('translation.progress')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-notifications" class="nav-link" data-key="t-notifications">@lang('translation.notifications')</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="ui-media" class="nav-link" data-key="t-media-object">@lang('translation.media-object')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-embed-video" class="nav-link" data-key="t-embed-video">@lang('translation.embed-video')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-typography" class="nav-link" data-key="t-typography">@lang('translation.typography')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-lists" class="nav-link" data-key="t-lists">@lang('translation.list')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-general" class="nav-link" data-key="t-general">@lang('translation.general')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-utilities" class="nav-link" data-key="t-utilities">@lang('translation.utilities')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                        <i class="bi bi-layers"></i> <span data-key="t-advance-ui">@lang('translation.advance-ui')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="advance-ui-sweetalerts" class="nav-link" data-key="t-sweet-alerts">@lang('translation.sweet-alerts')</a>
                            </li>
                            <li class="nav-item">
                                <a href="advance-ui-nestable" class="nav-link" data-key="t-nestable-list">@lang('translation.nestable-list')</a>
                            </li>
                            <li class="nav-item">
                                <a href="advance-ui-scrollbar" class="nav-link" data-key="t-scrollbar">@lang('translation.scrollbar')</a>
                            </li>
                            <li class="nav-item">
                                <a href="advance-ui-swiper" class="nav-link" data-key="t-swiper-slider">@lang('translation.swiper-slider')</a>
                            </li>
                            <li class="nav-item">
                                <a href="advance-ui-ratings" class="nav-link" data-key="t-ratings">@lang('translation.ratings')</a>
                            </li>
                            <li class="nav-item">
                                <a href="advance-ui-highlight" class="nav-link" data-key="t-highlight">@lang('translation.highlight')</a>
                            </li>
                            <li class="nav-item">
                                <a href="advance-ui-scrollspy" class="nav-link" data-key="t-scrollSpy">@lang('translation.scrollSpy')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#customUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="customUI">
                        <i class="bi bi-tools"></i> <span data-key="t-custom-ui">@lang('translation.custom-ui')</span> <span class="badge badge-pill bg-danger" data-key="t-custom">@lang('translation.custom')</span>
                    </a>
                    <div class="collapse menu-dropdown mega-dropdown-menu" id="customUI">
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="ui-ribbons" class="nav-link" data-key="t-ribbons">@lang('translation.ribbons')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-profile" class="nav-link" data-key="t-profile">@lang('translation.profile')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="ui-counter" class="nav-link" data-key="t-counter">@lang('translation.counter')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="ri-file-list-3-line"></i> <span data-key="t-forms">@lang('translation.forms')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarForms">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="forms-elements" class="nav-link" data-key="t-basic-elements">@lang('translation.basic-elements')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-select" class="nav-link" data-key="t-form-select"> @lang('translation.form-select')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-checkboxs-radios" class="nav-link" data-key="t-checkboxs-radios">@lang('translation.checkboxs-radios')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-pickers" class="nav-link" data-key="t-pickers"> @lang('translation.pickers')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-masks" class="nav-link" data-key="t-input-masks">@lang('translation.input-masks')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-advanced" class="nav-link" data-key="t-advanced">@lang('translation.advanced')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-range-sliders" class="nav-link" data-key="t-range-slider">@lang('translation.range-slider')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-validation" class="nav-link" data-key="t-validation">@lang('translation.validation')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-wizard" class="nav-link" data-key="t-wizard">@lang('translation.wizard')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-editors" class="nav-link" data-key="t-editors">@lang('translation.editors')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-file-uploads" class="nav-link" data-key="t-file-uploads">@lang('translation.file-uploads')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-layouts" class="nav-link" data-key="t-form-layouts">@lang('translation.form-layouts')</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-tom-select" class="nav-link" data-key="t-tom-select">@lang('translation.tom-select')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTables" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTables">
                        <i class="bi bi-table"></i> <span data-key="t-tables">@lang('translation.tables')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTables">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="tables-basic" class="nav-link" data-key="t-basic-tables">@lang('translation.basic-tables')</a>
                            </li>
                            <li class="nav-item">
                                <a href="tables-gridjs" class="nav-link" data-key="t-grid-js">@lang('translation.grid-js')</a>
                            </li>
                            <li class="nav-item">
                                <a href="tables-listjs" class="nav-link" data-key="t-list-js">@lang('translation.list-js')</a>
                            </li>
                            <li class="nav-item">
                                <a href="tables-datatables" class="nav-link" data-key="t-datatables">@lang('translation.datatables') </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCharts">
                        <i class="bi bi-pie-chart"></i> <span data-key="t-apexchart">@lang('translation.apexcharts')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCharts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="charts-apex-line" class="nav-link" data-key="t-line"> @lang('translation.line')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-area" class="nav-link" data-key="t-area"> @lang('translation.area')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-column" class="nav-link" data-key="t-column"> @lang('translation.column') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-bar" class="nav-link" data-key="t-bar"> @lang('translation.bar') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-mixed" class="nav-link" data-key="t-mixed"> @lang('translation.mixed')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-timeline" class="nav-link" data-key="t-timeline"> @lang('translation.timeline') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-candlestick" class="nav-link" data-key="t-candlstick"> @lang('translation.candlstick') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-boxplot" class="nav-link" data-key="t-boxplot"> @lang('translation.boxplot') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-bubble" class="nav-link" data-key="t-bubble">
                                    @lang('translation.bubble') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-scatter" class="nav-link" data-key="t-scatter">
                                    @lang('translation.scatter') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-heatmap" class="nav-link" data-key="t-heatmap">
                                    @lang('translation.heatmap') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-treemap" class="nav-link" data-key="t-treemap">
                                    @lang('translation.treemap') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-pie" class="nav-link" data-key="t-pie"> @lang('translation.pie') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-radialbar" class="nav-link" data-key="t-radialbar"> @lang('translation.radialbar') </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-radar" class="nav-link" data-key="t-radar"> @lang('translation.radar')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="charts-apex-polar" class="nav-link" data-key="t-polar-area">
                                    @lang('translation.polar-area') </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarIcons">
                        <i class="bi bi-usb-symbol"></i> <span data-key="t-icons">@lang('translation.icons')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarIcons">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="icons-remix" class="nav-link" data-key="t-remix">@lang('translation.remix')</a>
                            </li>
                            <li class="nav-item">
                                <a href="icons-boxicons" class="nav-link" data-key="t-boxicons">@lang('translation.boxicons')</a>
                            </li>
                            <li class="nav-item">
                                <a href="icons-materialdesign" class="nav-link" data-key="t-material-design">@lang('translation.material-design')</a>
                            </li>
                            <li class="nav-item">
                                <a href="icons-bootstrap" class="nav-link" data-key="t-bootstrap">@lang('translation.bootstrap')</a>
                            </li>
                            <li class="nav-item">
                                <a href="icons-phosphor" class="nav-link" data-key="t-phosphor">@lang('translation.phosphor')</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="bi bi-geo-alt"></i> <span data-key="t-maps">@lang('translation.maps')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="maps-google" class="nav-link" data-key="t-google">
                                    @lang('translation.google')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="maps-vector" class="nav-link" data-key="t-vector">
                                  @lang('translation.vector')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="maps-leaflet" class="nav-link" data-key="t-leaflet">
                                   @lang('translation.leaflet')
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                        <i class="bi bi-share"></i> <span data-key="t-multi-level">@lang('translation.multi-level')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-level-1.1">@lang('translation.level-1.1') </a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAccount" data-key="t-level-1.2"> @lang('translation.level-1.2')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarAccount">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" data-key="t-level-2.1"> @lang('translation.level-2.1') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm" data-key="t-level-2.2">@lang('translation.level-2.2')
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarCrm">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-key="t-level-3.1"> @lang('translation.level-3.1')
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-key="t-level-3.2"> @lang('translation.level-3.2')
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="back-btn">
        <a href="index" class="btn btn-primary p-0 avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-title="Back to Dashboard">
            <div class="avatar-title rounded-circle">
                <i class="bi bi-house-door-fill"></i>
            </div>
        </a>
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>