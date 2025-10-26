@php
    $user = auth()->user();
    $name = $user->name ?? 'Tuan';
    $role = $user->role ?? 'Pengguna';
    $avatar = $user->photo ?? 'assets/dashboard/images/users/avatar-1.jpg';

    // Get notifications server-side
    $notifications = $user ? \App\Services\NotificationService::getForUser($user, 15) : collect();
    $unreadCount = $user ? \App\Services\NotificationService::getUnreadCount($user) : 0;

    // Group notifications by type for tabs
    $allNotifications = $notifications;
    $transactionNotifications = $notifications->where('type', 'transaction');
    $reportNotifications = $notifications->where('type', 'report');
    $systemNotifications = $notifications->whereIn('type', ['payment', 'general']);
@endphp

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/dashboard/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/kostash-logo-tp-white.png') }}" alt=""
                                height="35">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/dashboard/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/kostash-logo-tp-white.png') }}" alt=""
                                height="35">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                            id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i
                                        class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i
                                        class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/dashboard/images/users/avatar-2.jpg') }}"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/dashboard/images/users/avatar-3.jpg') }}"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/dashboard/images/users/avatar-5.jpg') }}"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i
                                    class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                        aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @if ($unreadCount > 0)
                            <span
                                class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCount }}<span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">Notifikasi</h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13">{{ $unreadCount }} Baru</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-simplebar style="max-height: 300px;">
                            @if ($allNotifications->count() > 0)
                                @foreach ($allNotifications as $notification)
                                    @include('dashboard.tenants.layouts.partials.notification-item', [
                                        'notification' => $notification,
                                    ])
                                @endforeach
                            @else
                                <div class="text-center p-4">
                                    <div class="avatar-md mx-auto mb-3">
                                        <div class="avatar-title bg-soft-info text-info rounded-circle">
                                            <i class="ri-notification-off-line fs-24"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold">Tidak ada notifikasi</h6>
                                    <p class="text-muted mb-0">Semua bersih!</p>
                                </div>
                            @endif
                        </div>

                        <div class="notification-actions text-center border-top border-top-dashed p-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    @if ($unreadCount > 0)
                                        <form action="{{ route('notifications.mark-all-read') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-soft-primary btn-sm w-100">
                                                <i class="mdi mdi-check-all me-1"></i>Tandai Dibaca
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-soft-secondary btn-sm w-100" disabled>
                                            <i class="mdi mdi-check-all me-1"></i>Semua Dibaca
                                        </button>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('tenant.notifications.index') }}"
                                        class="btn btn-soft-secondary btn-sm w-100">
                                        <i class="mdi mdi-eye me-1"></i>Lihat Semua
                                    </a>
                                </div>
                            </div>
                        </div>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#transaction-tab" role="tab"
                                aria-selected="false" id="transaction-tab-link">
                                Transaksi (<span id="transaction-count">0</span>)
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#report-tab" role="tab"
                                aria-selected="false" id="report-tab-link">
                                Laporan (<span id="report-count">0</span>)
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#system-tab" role="tab"
                                aria-selected="false" id="system-tab-link">
                                Sistem (<span id="system-count">0</span>)
                            </a>
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            {{-- @if ($user->photo)
                                        <img src="{{ asset('storage/uploads/profile/' . $user->photo) }}" 
                                            alt="Profile Picture" 
                                            class="rounded-circle header-profile-user" style='object-fit: cover;'>
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=120&font-size=0.4"
                                            alt="Avatar" class="rounded-circle header-profile-user">
                                    @endif --}}
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ ucfirst($role) }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Selamat datang, {{ auth()->user()->name ?? 'Tuan' }}!</h6>
                        <a class="dropdown-item" href="{{ route('public.home') }}"><i
                                class="mdi mdi-view-dashboard-outline text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Beranda</span></a>
                        <a class="dropdown-item" href="{{ route('tenant.profile.index') }}"><i
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
                        <!-- <a class="dropdown-item" href="pages-profile.html"><i
                                        class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">Balance : <b>$5971.67</b></span></a> -->
                        <a class="dropdown-item" href="{{ route('tenant.profile.change-password') }}">
                            <i class="mdi mdi-key text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Change Password</span>
                        </a>
                        <!-- <a class="dropdown-item" href="auth-lockscreen-basic.html">
                                    <span class="badge bg-soft-success text-success mt-1 float-end">New</span>
                                    <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">Lock screen</span>
                                </a> -->
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-logout">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
</header>

<script>
    // Simple mark as read function for individual notifications
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to refresh notification count
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
