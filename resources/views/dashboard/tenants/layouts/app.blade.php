<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>
        @hasSection('title')
            @yield('title') | {{ $global->site_title ?? config('app.name') }}
        @else
            {{ $global->site_title ?? config('app.name') }}
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ $global->site_description ?? 'Kost, kontrakan, sewa rumah Menganti Gresik Jawa Timur' }}" />
    <meta name="keywords"
        content="{{ $global->site_keywords ?? 'kost, kontrakan, sewa rumah, Menganti, Gresik, Surabaya, Jawa Timur, murah, strategis, fasilitas lengkap, pelajar, mahasiswa, karyawan, keluarga' }}" />
    <meta name="author" content="{{ $global->meta_author ?? 'KostASH.id' }}" />
    <meta name="robots" content="{{ $global->meta_robots ?? 'index, follow' }}" />
    <meta property="og:title"
        content="{{ $global->og_title ?? ($global->site_title ?? 'Kost, Kontrakan, Sewa Rumah Menganti Gresik Jawa Timur') }}" />
    <meta property="og:description"
        content="{{ $global->og_description ?? ($global->site_description ?? 'Cari kost, kontrakan, dan sewa rumah di Menganti, Gresik, Jawa Timur. Lokasi strategis, fasilitas lengkap, harga terjangkau, cocok untuk pelajar, mahasiswa, karyawan, dan keluarga.') }}" />
    <meta property="og:image" content="{{ $global->og_image ?? asset('assets/images/kostash-logo-tp-white.png') }}" />
    <meta property="og:type" content="website" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('assets/js/dark-mode.js') }}"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/k-logo.png') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/dashboard/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/dashboard/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom Notification Styles -->
    <style>
        .notification-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1055;
            max-width: 400px;
        }

        .notification-container .alert {
            margin-bottom: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .notification-container {
                left: 20px;
                right: 20px;
                max-width: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div id="layout-wrapper">
        @include('dashboard.tenants.layouts.header')
        @include('dashboard.tenants.layouts.navigation')
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <div class="main-content">
            <div class="page-content">
                <!-- Notifications Container -->
                <div class="notification-container">
                    @include('dashboard.components.notifications')
                </div>

                @yield('content')
            </div>
            @include('dashboard.tenants.layouts.footer')
        </div>
    </div>
    @yield('script')

    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <script src="{{ asset('assets/dashboard/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js') }}"></script>

    <script src="{{ asset('assets/dashboard/js/app.js') }}"></script>

    @yield('scripts')

    <!-- Notification System Script -->
    <script>
        // Notification System
        let notificationDropdown;

        document.addEventListener('DOMContentLoaded', function() {
            notificationDropdown = document.getElementById('notification-dropdown');
            loadNotifications();

            // Mark all as read button
            const markAllReadBtn = document.getElementById('mark-all-read-btn');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', markAllAsRead);
            }

            // Refresh notifications every 30 seconds
            setInterval(updateNotificationCount, 30000);
        });

        function loadNotifications() {
            fetch('/notifications', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    renderNotifications(data.notifications, 'all');
                    renderNotifications(data.notifications.filter(n => n.type === 'transaction'), 'transaction');
                    renderNotifications(data.notifications.filter(n => n.type === 'report'), 'report');
                    updateNotificationBadge(data.unread_count);
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }

        function renderNotifications(notifications, type) {
            const container = document.getElementById(`notification-list-${type}`);
            if (!container) return;

            if (notifications.length === 0) {
                const emptyState = getEmptyState(type);
                container.innerHTML = emptyState;
                return;
            }

            let html = '';
            notifications.forEach(notification => {
                html += createNotificationItem(notification);
            });
            container.innerHTML = html;
        }

        function createNotificationItem(notification) {
            const isRead = notification.is_read;
            const readClass = isRead ? '' : 'active';
            const readStyle = isRead ? 'opacity: 0.7;' : '';

            return `
                <div class="text-reset notification-item d-block dropdown-item position-relative ${readClass}" 
                     style="${readStyle}" data-notification-id="${notification.id}">
                    <div class="d-flex">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                <i class="${notification.icon}"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <a href="${notification.url}" class="stretched-link" onclick="markAsRead(${notification.id})">
                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">${notification.title}</h6>
                            </a>
                            <div class="fs-13 text-muted">
                                <p class="mb-1">${notification.message}</p>
                            </div>
                            <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span><i class="mdi mdi-clock-outline"></i> ${notification.created_at}</span>
                            </p>
                        </div>
                        <div class="px-2 fs-15">
                            ${!isRead ? '<div class="bg-primary rounded-circle" style="width: 8px; height: 8px;"></div>' : ''}
                        </div>
                    </div>
                </div>
            `;
        }

        function getEmptyState(type) {
            const icons = {
                'all': 'bx-bell',
                'transaction': 'bx-wallet',
                'report': 'bx-message-alt-detail'
            };

            const messages = {
                'all': 'Belum ada notifikasi',
                'transaction': 'Belum ada notifikasi transaksi',
                'report': 'Belum ada notifikasi laporan'
            };

            return `
                <div class="text-center py-4">
                    <i class="${icons[type]} fs-48 text-muted"></i>
                    <p class="mt-2 text-muted">${messages[type]}</p>
                </div>
            `;
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(() => {
                    // Update UI
                    const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (item) {
                        item.classList.remove('active');
                        item.style.opacity = '0.7';
                        const indicator = item.querySelector('.bg-primary.rounded-circle');
                        if (indicator) indicator.remove();
                    }
                    updateNotificationCount();
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
        }

        function markAllAsRead() {
            fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(() => {
                    loadNotifications();
                })
                .catch(error => {
                    console.error('Error marking all as read:', error);
                });
        }

        function updateNotificationCount() {
            fetch('/notifications/unread-count', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.count);
                })
                .catch(error => {
                    console.error('Error updating notification count:', error);
                });
        }

        function updateNotificationBadge(count) {
            const badge = document.getElementById('notification-badge');
            const countElement = document.getElementById('notification-count');

            if (count > 0) {
                if (badge) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.style.display = 'inline-block';
                } else {
                    // Create badge if it doesn't exist
                    const button = document.querySelector('#page-header-notifications-dropdown');
                    const newBadge = document.createElement('span');
                    newBadge.id = 'notification-badge';
                    newBadge.className =
                        'position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger';
                    newBadge.innerHTML =
                        `${count > 99 ? '99+' : count}<span class="visually-hidden">unread messages</span>`;
                    button.appendChild(newBadge);
                }

                if (countElement) {
                    countElement.textContent = `${count} Baru`;
                }
            } else {
                if (badge) {
                    badge.style.display = 'none';
                }
                if (countElement) {
                    countElement.textContent = '0 Baru';
                }
            }
        }

        // Other existing functions...
        function validateFileSize(input) {
            const maxSize = 2 * 1024 * 1024; // 2MB
            const errorEl = document.getElementById('image-error');
            if (input.files[0] && input.files[0].size > maxSize) {
                errorEl.textContent = 'Ukuran gambar tidak boleh lebih dari 2MB.';
                input.value = ''; // reset file input
            } else {
                errorEl.textContent = '';
            }
        }

        // Auto-hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.notification-container .alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert && alert.parentNode) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000); // 5 seconds
            });
        });
    </script>
</body>

</html>
