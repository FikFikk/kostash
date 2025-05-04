<nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('public.home') }}">
            <img src="{{ asset('assets/images/kostash-logo-tp.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="35">
            <img src="{{ asset('assets/images/kostash-logo.png') }}" class="card-logo card-logo-light" alt="logo light"
                height="17">
        </a>
        
        <!-- Mobile Login Indicator - only visible on mobile -->
        <div class="d-lg-none d-flex align-items-center  ms-auto">
            
            @guest
                <a href="{{ route('auth.login') }}" class="btn btn-sm btn-outline-primary me-2">Sign In</a>
                <a href="{{ route('auth.register') }}" class="btn btn-sm btn-primary">Sign Up</a>
            @else
            <div class="dropdown ms-sm-3 header-item topbar-user">
                <img class="rounded-circle" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"
                    src="{{ asset(auth()->user()->photo ?? 'assets/dashboard/images/users/avatar-1.jpg') }}" 
                    alt="User Avatar" 
                    width="32" height="32"
                    onerror="this.onerror=null;this.src='{{ asset('assets/dashboard/images/users/avatar-1.jpg') }}';">
                <div class="dropdown-menu dropdown-menu-end mt-5">
                    <!-- item-->
                    <h6 class="dropdown-header">Selamat datang, {{ auth()->user()->name ?? 'Tuan' }}!</h6>
                    <a class="dropdown-item" href=""><i
                            class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Profile</span></a>
                    <!-- <a class="dropdown-item" href="apps-chat.html"><i
                            class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Messages</span></a>
                    <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                            class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Taskboard</span></a> -->
                    <a class="dropdown-item" href=""><i
                            class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Help</span></a>
                    <div class="dropdown-divider"></div>
                    <!-- <a class="dropdown-item" href=""><i
                            class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Balance : <b>$5971.67</b></span></a>
                    <a class="dropdown-item" href="pages-profile-settings.html">
                        <span class="badge bg-soft-success text-success mt-1 float-end">New</span>
                        <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                        <span class="align-middle">Settings</span>
                    </a>
                    <a class="dropdown-item" href="auth-lockscreen-basic.html">
                        <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
                        <span class="align-middle">Lock screen</span>
                    </a> -->
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">
                        <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                        <span class="align-middle" data-key="t-logout">Logout</span>
                    </a>
                </div>
            </div>
            @endguest
        </div>

        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                <li class="nav-item">
                    <a class="nav-link active" href="#hero">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallery">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#lokasi">Lokasi</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li> -->
            </ul>

            <div class="">
            @guest
                {{-- Jika user belum login --}}
                <div class="d-none d-md-flex">
                    <a href="{{ route('auth.login') }}" class="btn btn-link fw-medium text-decoration-none text-dark">Sign in</a>
                    <a href="{{ route('auth.register') }}" class="btn btn-primary">Sign Up</a>
                </div>
            @else
                {{-- Jika user sudah login - DESKTOP ONLY PROFILE DROPDOWN --}}
                <div class="dropdown ms-sm-3 header-item topbar-user d-none d-lg-block bg-transparent border-0 shadow-none p-0">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset(auth()->user()->photo ?? 'assets/dashboard/images/users/avatar-1.jpg') }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/dashboard/images/users/avatar-1.jpg') }}';"
                                alt="User Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ ucfirst(auth()->user()->role) }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end mt-5">
                        <h6 class="dropdown-header">Selamat datang, {{ auth()->user()->name ?? 'Tuan' }}!</h6>

                        {{-- (Optional) Tambahan menu profile atau lainnya di sini --}}
                        <a class="dropdown-item" href=""><i
                            class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href=""><i
                            class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-logout">Logout</span>
                        </a>
                    </div>
                </div>
            @endguest
            </div>
        </div>
    </div>
</nav>
