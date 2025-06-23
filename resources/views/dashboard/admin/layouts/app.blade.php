<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    <head>
        <meta charset="utf-8" />
        <title>
            @hasSection('title')
                @yield('title') | {{ config('app.name') }}
            @else
                {{ config('app.name') }}
            @endif
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="KostASH" />
        <meta name="kaywords" content="KostASH" />
        <meta name="author" content="KostASH.id" />

        <script src="{{ asset('assets/js/dark-mode.js') }}"></script>

        <link rel="shortcut icon" href="{{ asset('assets/images/k-logo.png') }}">

        <link href="{{ asset('assets/dashboard/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/filepond/filepond.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">

        <link href="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/dashboard/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" />


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

        {{-- INI ADALAH PERUBAHAN UTAMA: Memuat skrip lebih awal --}}
        {{-- Pastikan ini dimuat SETELAH Bootstrap JS di bagian akhir body,
             atau jika hanya script halaman ini, letakkan di head sebagai prioritas.
             Jika Bootstrap JS Anda dimuat di bagian bawah <body>, maka
             kita perlu memastikan bahwa modal Bootstrap sudah tersedia.

             Mari kita ubah @yield('script') di `app.blade.php` menjadi
             @stack('scripts_before_body_end') dan biarkan skrip inti
             Bootstrap di akhir body. Lalu, di meter/index.blade.php,
             kita gunakan @push('scripts_before_body_end').
        --}}
        @stack('scripts') {{-- Jika Anda ingin script khusus halaman masuk ke head --}}

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

        {{-- Ini adalah skrip global yang dimuat di bagian paling bawah body --}}
        <script src="{{ asset('assets/dashboard/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/dashboard/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        {{-- Pastikan bootstrap.bundle.min.js dimuat sebelum skrip Anda yang lain --}}
        <script src="{{ asset('assets/dashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/jsvectormap/maps/world-merc.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/prismjs/prism.js') }}"></script>
        <script src="{{ asset('assets/dashboard/js/pages/dashboard-ecommerce.init.js') }}"></script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js') }}"></script>

        <script src="{{ asset('assets/dashboard/libs/dropzone/dropzone-min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

        <script src="{{ asset('assets/dashboard/js/pages/form-file-upload.init.js') }}"></script>

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

    </body>
</html>