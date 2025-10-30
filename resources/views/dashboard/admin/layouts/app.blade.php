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


    {{-- FilePond Core CSS --}}
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet">

    {{-- FilePond Plugins CSS --}}
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    {{-- Optional: FilePond Image Edit CSS (jika ingin fitur edit gambar) --}}
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet">


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

    {{-- FilePond Core JS --}}
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    {{-- FilePond Plugins (pilih sesuai kebutuhan) --}}

    {{-- Plugin untuk preview gambar --}}
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    {{-- Plugin untuk orientasi gambar --}}
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
    </script>

    {{-- Plugin untuk validasi ukuran file --}}
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>

    {{-- Plugin untuk validasi tipe file --}}
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

    {{-- Plugins untuk crop, resize, dan transform gambar --}}
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

    {{-- Optional: Plugin untuk edit gambar (crop, rotate, dll) --}}
    {{-- <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script> --}}

    {{-- Optional: Plugin untuk encode file --}}
    {{-- <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script> --}}
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
    @yield('script')

</body>

</html>
