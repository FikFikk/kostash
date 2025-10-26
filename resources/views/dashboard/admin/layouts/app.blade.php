<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

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

    <link rel="shortcut icon" href="{{ asset('assets/images/k-logo.png') }}">

    <link href="{{ asset('assets/dashboard/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">

    <link href="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/dashboard/libs/choices.js/public/assets/styles/choices.min.css') }}"
        rel="stylesheet" />


    <script src="{{ asset('assets/dashboard/js/layout.js') }}"></script>
    <link href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

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
    @stack('scripts')

</head>

<body>
    <div id="layout-wrapper">
        @include('dashboard.admin.layouts.header')
        @include('dashboard.admin.layouts.navigation')
        <div class="vertical-overlay"></div>
        <div class="main-content">
            <div class="page-content">
                <div class="notification-container">
                    @include('dashboard.components.notifications')
                </div>

                @yield('content')
            </div>
            @include('dashboard.admin.layouts.footer')
        </div>
    </div>

    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <script src="{{ asset('assets/dashboard/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js') }}"></script>

    <script src="{{ asset('assets/dashboard/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/dashboard/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/dashboard/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/dashboard/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('assets/dashboard/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}">
    </script>

    <script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
    <script>
        // Skrip inline Anda di sini (tidak terkait dengan meter readings JS)
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

    <script>
        // Pass PHP data to JavaScript
        window.monthlyRevenue = @json($monthlyRevenue ?? []);
        window.roomsWithTenants = {{ $roomsWithTenants ?? 0 }};
        window.roomsWithoutTenants = {{ $roomsWithoutTenants ?? 0 }};

        // Debug log
        console.log('PHP data passed to JS:', {
            monthlyRevenue: window.monthlyRevenue,
            roomsWithTenants: window.roomsWithTenants,
            roomsWithoutTenants: window.roomsWithoutTenants
        });
    </script>
    <script>
        // Global FilePond initializer: attach to any input with class "filepond"
        document.addEventListener('DOMContentLoaded', function() {
            if (!window.FilePond) return; // layout may include public assets; ensure present

            // Register plugins if available (safe-guard)
            try {
                // Register all available FilePond plugins that may be loaded via public assets.
                const plugins = [];
                if (window.FilePondPluginImagePreview) plugins.push(window.FilePondPluginImagePreview);
                if (window.FilePondPluginFileValidateSize) plugins.push(window.FilePondPluginFileValidateSize);
                if (window.FilePondPluginFileValidateType) plugins.push(window.FilePondPluginFileValidateType);
                // Intentionally do NOT register the FilePond File Encode plugin here.
                // The File Encode plugin converts files to base64 data URLs which we
                // explicitly disallow on the server. Keeping base64 off prevents
                // very long strings from being submitted as `filename` and avoids
                // database truncation errors.
                if (window.FilePondPluginImageExifOrientation) plugins.push(window
                    .FilePondPluginImageExifOrientation);

                if (plugins.length) {
                    FilePond.registerPlugin(...plugins);
                }
            } catch (e) {
                // plugins may already be registered or missing
                console.warn('FilePond plugin register error', e);
            }

            const inputs = document.querySelectorAll('input[type="file"].filepond');
            inputs.forEach((input) => {
                const opts = {
                    allowMultiple: input.hasAttribute('multiple'),
                    acceptedFileTypes: ['image/*'],
                    maxFileSize: '2MB',
                    // Disable File Encode explicitly so FilePond does not convert files
                    // to base64 strings. We prefer multipart form uploads or async
                    // server.process uploads.
                    allowFileEncode: false,
                    // Do not attempt to process files automatically (async). If you
                    // want async upload, configure server.process explicitly.
                    allowProcess: false,
                    labelIdle: 'Tarik & lepas atau <span class="filepond--label-action">Pilih</span>'
                };

                // Allow overriding max files via data attribute (e.g., data-max-files="5")
                const maxFiles = input.getAttribute('data-max-files');
                if (maxFiles && input.hasAttribute('multiple')) {
                    opts.maxFiles = parseInt(maxFiles, 10) || undefined;
                }

                try {
                    // avoid double-init
                    if (!FilePond.find(input)) {
                        // If input has a pre-existing file URL, include it as an initial local file so FilePond shows preview
                        const initialFile = input.getAttribute('data-initial-file');
                        if (initialFile) {
                            opts.files = [{
                                source: initialFile,
                                options: {
                                    type: 'local'
                                }
                            }];
                        }

                        FilePond.create(input, opts);
                    }
                } catch (e) {
                    // ignore initialization errors for non-supported inputs
                    console.warn('FilePond init error for', input, e);
                }
            });
        });
    </script>
    @yield('script')

</body>

</html>
