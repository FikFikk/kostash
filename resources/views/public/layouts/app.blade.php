<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Home') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KostASH" />
    <meta name="keywords" content="KostASH" />
    <meta name="author" content="KostASH.id" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ secure_asset('assets/images/k-logo.png') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/dashboard/js/layout.js') }}"></script>

    <!-- glightbox css -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/glightbox/css/glightbox.min.css') }}">

    <!-- CSS Assets -->
    <link href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- CDN Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    @stack('styles')
</head>

<body>
    <div id="layout-wrapper">
        @include('public.layouts.header')
        @include('public.layouts.navigation')
        <div class="">
            <div class="">
                @yield('content')
            </div>
            @include('public.layouts.footer')
        </div>
    </div>

    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <!-- JavaScript Assets -->
    <script src="{{ asset('assets/dashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/pages/landing.init.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/pages/swiper.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- glightbox js -->
    <script src="{{ asset('assets/dashboard/libs/glightbox/js/glightbox.min.js') }}"></script>

    <!-- isotope-layout -->
    <script src="{{ asset('assets/dashboard/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <script src="{{ asset('assets/dashboard/js/pages/gallery.init.js') }}"></script>

    <script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
</body>

</html>
