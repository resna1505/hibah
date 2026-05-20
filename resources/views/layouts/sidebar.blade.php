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
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="26">
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
            
                <li class="menu-title"><span data-key="t-menu">@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a href="index" class="nav-link menu-link"> <i class="bi bi-speedometer2"></i> <span data-key="t-dashboard">@lang('translation.dashboards')</span> </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">@lang('translation.pages')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="bi bi-person-circle"></i> <span data-key="t-authentication">@lang('translation.authentication')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin">@lang('translation.signin')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSignIn">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-signin-basic" class="nav-link" data-key="t-basic"> @lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signin-basic-2" class="nav-link" data-key="t-basic-2">@lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signin-cover" class="nav-link" data-key="t-cover">@lang('translation.cover') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarSignUp" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSignUp" data-key="t-signup"> @lang('translation.signup')</a>
                                <div class="collapse menu-dropdown" id="sidebarSignUp">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-signup-basic" class="nav-link" data-key="t-basic"> @lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signup-basic-2" class="nav-link" data-key="t-basic-2"> @lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signup-cover" class="nav-link" data-key="t-cover"> @lang('translation.cover') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarResetPass" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarResetPass" data-key="t-password-reset">
                                   @lang('translation.password-reset')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarResetPass">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-basic" class="nav-link" data-key="t-basic">@lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-basic-2" class="nav-link" data-key="t-basic-2"> @lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-cover" class="nav-link" data-key="t-cover"> @lang('translation.cover')</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarchangePass" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarchangePass" data-key="t-password-create">
                                    @lang('translation.password-create')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarchangePass">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-pass-change-basic" class="nav-link" data-key="t-basic"> @lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-change-basic-2" class="nav-link" data-key="t-basic-2"> @lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-change-cover" class="nav-link" data-key="t-cover"> @lang('translation.cover') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarLockScreen" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLockScreen" data-key="t-lock-screen">
                                     @lang('translation.lock-screen')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarLockScreen">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-lockscreen-basic" class="nav-link" data-key="t-basic">  @lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-lockscreen-basic-2" class="nav-link" data-key="t-basic-2">   @lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-lockscreen-cover" class="nav-link" data-key="t-cover">  @lang('translation.cover') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarLogout" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLogout" data-key="t-logout">@lang('translation.logout')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarLogout">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-logout-basic" class="nav-link" data-key="t-basic"> @lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-logout-basic-2" class="nav-link" data-key="t-basic-2"> @lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-logout-cover" class="nav-link" data-key="t-cover"> @lang('translation.cover') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarSuccessMsg" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSuccessMsg" data-key="t-success-message"> @lang('translation.success-message')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSuccessMsg">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-success-msg-basic" class="nav-link" data-key="t-basic"> @lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-success-msg-basic-2" class="nav-link" data-key="t-basic-2"> @lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-success-msg-cover" class="nav-link" data-key="t-cover"> @lang('translation.cover') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarTwoStep" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTwoStep" data-key="t-two-step-verification">  @lang('translation.two-step-verification')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarTwoStep">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-twostep-basic" class="nav-link" data-key="t-basic">  @lang('translation.basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-twostep-basic-2" class="nav-link" data-key="t-basic-2">   @lang('translation.basic-2') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-twostep-cover" class="nav-link" data-key="t-cover">  @lang('translation.cover') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarErrors" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarErrors" data-key="t-errors"> @lang('translation.errors')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarErrors">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-404-basic" class="nav-link" data-key="t-404-basic"> @lang('translation.404-basic') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-404-cover" class="nav-link" data-key="t-404-cover"> @lang('translation.404-cover') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-404-alt" class="nav-link" data-key="t-404-alt"> @lang('translation.404-alt') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-500" class="nav-link" data-key="t-500"> @lang('translation.500') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-offline" class="nav-link" data-key="t-offline-page">  @lang('translation.offline-page') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i class="bi bi-journal-medical"></i> <span data-key="t-pages">@lang('translation.pages')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="pages-starter" class="nav-link" data-key="t-starter"> @lang('translation.starter') </a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarProfile" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProfile" data-key="t-profile">  @lang('translation.profile')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarProfile">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="pages-profile" class="nav-link" data-key="t-simple-page"> @lang('translation.simple-page') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile-settings" class="nav-link" data-key="t-settings"> @lang('translation.settings') </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="pages-team" class="nav-link" data-key="t-team"> @lang('translation.team') </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-timeline" class="nav-link" data-key="t-timeline"> @lang('translation.timeline') </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-faqs" class="nav-link" data-key="t-faqs"> @lang('translation.faqs') </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-pricing" class="nav-link" data-key="t-pricing">  @lang('translation.pricing') </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-maintenance" class="nav-link" data-key="t-maintenance"> @lang('translation.maintenance') 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-coming-soon" class="nav-link" data-key="t-coming-soon"> @lang('translation.coming-soon') 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-sitemap" class="nav-link" data-key="t-sitemap"> @lang('translation.sitemap')  </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-search-results" class="nav-link" data-key="t-search-results"> @lang('translation.search-results')  </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="widgets">
                        <i class="bi bi-hdd-stack"></i> <span data-key="t-widgets">@lang('translation.widgets')</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="components" target="_blank">
                        <i class="bi bi-layers"></i> <span data-key="t-components">@lang('translation.components')</span>
                    </a>
                </li>
                
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-apps">@lang('translation.apps')</span></li>
                
                <li class="nav-item">
                    <a href="apps-calendar" class="nav-link menu-link"> <i class="bi bi-calendar3"></i> <span data-key="t-calendar">@lang('translation.calendar')</span> </a>
                </li>
                
                <li class="nav-item">
                    <a href="apps-api-key" class="nav-link menu-link"> <i class="bi bi-key"></i> <span data-key="t-api-key">@lang('translation.api-key')</span> </a>
                </li>
                
                <li class="nav-item">
                    <a href="apps-contact" class="nav-link menu-link"> <i class="bi bi-person-square"></i> <span data-key="t-contact">@lang('translation.contact')</span> </a>
                </li>
                
                <li class="nav-item">
                    <a href="apps-leaderboards" class="nav-link menu-link"> <i class="bi bi-gem"></i> <span data-key="t-leaderboard">@lang('translation.leaderboard')</span> </a>
                </li>
                
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-layouts">@lang('translation.layouts')</span></li>
                <li class="nav-item">
                    <a href="layouts-horizontal" class="nav-link menu-link" target="_blank"> <i class="bi bi-window"></i> <span data-key="t-horizontal">@lang('translation.horizontal')</span> </a>
                </li>
                <li class="nav-item">
                    <a href="layouts-detached" class="nav-link menu-link" target="_blank"> <i class="bi bi-layout-sidebar-inset"></i> <span data-key="t-detached">@lang('translation.detached')</span> </a>
                </li>
                <li class="nav-item">
                    <a href="layouts-two-column" class="nav-link menu-link" target="_blank"> <i class="bi bi-layout-three-columns"></i> <span data-key="t-two-column">@lang('translation.two-column')</span> </a>
                </li>
                <li class="nav-item">
                    <a href="layouts-vertical-hovered" class="nav-link menu-link" target="_blank"> <i class="bi bi-layout-text-sidebar-reverse"></i> <span data-key="t-hovered">@lang('translation.hovered')</span> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                        <i class="bi bi-share"></i> <span data-key="t-multi-level">@lang('translation.multi-level')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-level-1.1"> @lang('translation.level-1.1')</a>
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
                                            <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm" data-key="t-level-2.2"> @lang('translation.level-2.2')
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

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>