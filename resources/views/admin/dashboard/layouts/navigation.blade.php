<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard.home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/dashboard/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/kostash-logo-tp-white.png') }}" alt="" height="35">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard.home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/dashboard/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/kostash-logo-tp-white.png') }}" alt="" height="35">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard.home') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="bx bxs-data"></i> <span data-key="t-authentication">Master Data</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('room.home') }}" class="nav-link" data-key="t-room"> Room </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('global.index') }}" class="nav-link" data-key="t-room"> Global Setting </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('gallery.index') }}" class="nav-link" data-key="t-gallery"> Gallery </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('user.index') }}">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">User</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Template</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Menu</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link" data-key="t-mailbox"> Sub Menu 1 </a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin"> Sub Menu 2
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSignIn">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="" class="nav-link" data-key="t-basic"> Sub menu 1
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" class="nav-link" data-key="t-cover"> Sub menu 2
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
    </div>
</div>
