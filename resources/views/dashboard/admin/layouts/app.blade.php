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
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/k-logo.png') }}">
        
        <!-- jsvectormap css -->
        <link href="{{ asset('assets/dashboard/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Filepond css -->
        <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/filepond/filepond.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">

        <!--Swiper slider css-->
        <link href="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/dashboard/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" />

        
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
        @stack('styles')
    </head>
    <body>
        <div id="layout-wrapper">
            @include('admin.dashboard.layouts.header')
            @include('admin.dashboard.layouts.navigation')
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>
            <div class="main-content">
                <div class="page-content">
                    @yield('content')
                </div>
                @include('admin.dashboard.layouts.footer')
            </div>
        </div>
        @yield('script')

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
        <script src="{{ asset('assets/dashboard/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/jsvectormap/maps/world-merc.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/prismjs/prism.js') }}"></script>
        <script src="{{ asset('assets/dashboard/js/pages/dashboard-ecommerce.init.js') }}"></script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js') }}"></script>

        <!-- dropzone min -->
        <script src="{{ asset('assets/dashboard/libs/dropzone/dropzone-min.js') }}"></script>
        <!-- filepond js -->
        <script src="{{ asset('assets/dashboard/libs/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

        <script src="{{ asset('assets/dashboard/js/pages/form-file-upload.init.js') }}"></script>
        
        <script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
        <script>
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
        </script>
    </body>
</html>
