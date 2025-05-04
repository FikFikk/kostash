@extends('public.layouts.app')

@section('content')
<div data-bs-spy="scroll" data-bs-target="#navbar-example">

    <!-- Begin page -->
    <div class="layout-wrapper landing">

        <!-- start hero section -->
        <section class="section pb-0 hero-section" id="hero">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-sm-10">
                        <div class="text-center mt-lg-5 pt-5">
                            <!-- <h1 class="display-6 fw-semibold mb-3 lh-base">Kos asik, Bayar tinggal klik! di <span -->
                            <h1 class="display-6 fw-semibold mb-3 lh-base">Kos asik, Nyaman & Praktis di <span
                                    class="text-success">KostASH </span></h1>
                            <p class="lead text-muted lh-base">KostASH adalah hunian kost yang nyaman dan strategis, cocok untuk pelajar, mahasiswa, dan pekerja. Dapatkan informasi lengkap tentang ketersediaan kamar, fasilitas, dan lokasi hanya dalam sekali klik.</p>

                            <div class="d-flex gap-2 justify-content-center mt-4">
                                <a href="#gallery" class="btn btn-primary">Lihat Kamar <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                                <a href="#services" class="btn btn-danger">Cek Layanan <i class="ri-eye-line align-middle ms-1"></i></a>
                            </div>
                        </div>

                        <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                            <div class="demo-img-patten-top d-none d-sm-block">
                                <img src="{{ asset('assets/dashboard/images/landing/img-pattern.png') }}" class="d-block img-fluid" alt="...">
                            </div>
                            <div class="demo-img-patten-bottom d-none d-sm-block">
                                <img src="{{ asset('assets/dashboard/images/landing/img-pattern.png') }}" class="d-block img-fluid" alt="...">
                            </div>
                            <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                    <div class="carousel-item active" data-bs-interval="3000">
                                        <img src="{{ asset('assets/images/image-lp.jpg') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="3000">
                                        <img src="{{ asset('assets/images/image-lp2.jpg') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="3000">
                                        <img src="{{ asset('assets/images/image-lp3.jpg') }}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
            <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                        <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                        </path>
                    </g>
                </svg>
            </div>
            <!-- end shape -->
        </section>
        <!-- end hero section -->

        <!-- start services -->
        <section class="section" id="services">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="mb-3 ff-secondary fw-semibold lh-base">Layanan KostASH – Nyaman, Aman, dan Responsif</h1>
                            <p class="text-muted">Kami memberikan berbagai fasilitas dan dukungan untuk memastikan kenyamanan dan keamanan penghuni setiap hari.</p>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-customer-service-2-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Respon Cepat 24/7</h5>
                                <p class="text-muted my-3 ff-secondary">Kami selalu siap membantu jika ada kendala, cukup hubungi pengelola kapan saja.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-hotel-bed-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Fasilitas Kamar Siap Pakai</h5>
                                <p class="text-muted my-3 ff-secondary">Kamar dilengkapi kasur lantai dan rak baju, langsung bisa digunakan tanpa repot.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-showers-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Air Selalu Tersedia</h5>
                                <p class="text-muted my-3 ff-secondary">Air bersih tersedia setiap saat untuk kebutuhan mandi dan mencuci.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-home-gear-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Area Aman dengan Pagar</h5>
                                <p class="text-muted my-3 ff-secondary">Lingkungan tertutup dan dilindungi pagar untuk menjaga keamanan penghuni.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="mdi mdi-hanger fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Jemuran Bersama</h5>
                                <p class="text-muted my-3 ff-secondary">Tersedia gantungan besi untuk menjemur pakaian di area depan kost.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-delete-bin-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Tempat Sampah Disediakan</h5>
                                <p class="text-muted my-3 ff-secondary">Tempat sampah tersedia. Penghuni diharapkan menjaga kebersihan, termasuk membakar sampah secara mandiri.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end services -->

        <!-- Swiper -->
        <div class="swiper effect-coverflow-swiper rounded pb-5">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('assets/images/image-lp.jpg') }}" alt="" class="img-fluid" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('assets/images/image-lp2.jpg') }}" alt="" class="img-fluid" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('assets/images/image-lp.jpg') }}" alt="" class="img-fluid" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('assets/images/image-lp.jpg') }}" alt="" class="img-fluid" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('assets/images/image-lp.jpg') }}" alt="" class="img-fluid" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('assets/images/image-lp.jpg') }}" alt="" class="img-fluid" />
                </div>
            </div>
            <div class="swiper-pagination swiper-pagination-dark"></div>
        </div>

        <!-- start plan -->
        <section class="section bg-light" id="gallery">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h2 class="mb-3 fw-semibold">Galeri</h2>
                            <p class="text-muted mb-4">Lihat berbagai foto dan dokumentasi kamar serta fasilitas kos kami. Transparan dan tanpa biaya tersembunyi.</p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <ul class="list-inline categories-filter animation-nav" id="filter">
                                                <li class="list-inline-item"><a class="categories active" data-filter="*">All</a></li>
                                                <li class="list-inline-item"><a class="categories" data-filter=".project">Project</a></li>
                                                <li class="list-inline-item"><a class="categories" data-filter=".designing">Designing</a></li>
                                                <li class="list-inline-item"><a class="categories" data-filter=".photography">Photography</a></li>
                                                <li class="list-inline-item"><a class="categories" data-filter=".development">Development</a></li>
                                            </ul>
                                        </div>
        
                                        <div class="row gallery-wrapper">
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development"  data-category="designing development">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Glasses and laptop from above</h5>
                                                            </div>
                                                        </a>
                                                    </div>
    
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Ron Mackie</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 2.2K
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3K
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Working at a coffee shop</h5>
                                                            </div>
                                                        </a>
                                                        
                                                    </div>
    
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Nancy Martino</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 3.2K
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.1K
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project development" data-category="development">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Photo was taken in Beach</h5>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Elwood Arter</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 2.1K
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1K
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing" data-category="project designing">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Drawing a sketch</h5>
                                                            </div>
                                                        </a>
                                                        
                                                    </div>
    
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Jason McQuaid</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 825
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 101
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing" data-category="project designing">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Working from home little spot</h5>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Henry Baird</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 632
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 95
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Project discussion with team</h5>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Erica Kernan</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 3.4K
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3k
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development"  data-category="designing development">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Sunrise above a beach</h5>
                                                            </div>
                                                        </a>
                                                    </div>
    
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">James Ballard</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 735
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 150
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Glasses and laptop from above</h5>
                                                            </div>
                                                        </a>
                                                    </div>
    
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Ruby Griffin</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 1.5k
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 250
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development"  data-category="designing development">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Dramatic clouds at the Golden Gate Bridge</h5>
                                                            </div>
                                                        </a>
                                                    </div>
    
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Ron Mackie</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 2.2K
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3K
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing" data-category="project designing">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Fun day at the Hill Station</h5>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Henry Baird</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 632
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 95
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">Cycling in the countryside</h5>
                                                            </div>
                                                        </a>
                                                        
                                                    </div>
    
                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Nancy Martino</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 3.2K
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.1K
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ asset('assets/images/image-lp.jpg') }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" src="{{ asset('assets/images/image-lp.jpg') }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">A mix of friends and strangers heading off to find an adventure.</h5>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="box-content">
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Erica Kernan</a></div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-3">
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 3.4K
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                        <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3k
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- ene card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end plan -->

        <!-- start faqs -->
        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">Pertanyaan yang Sering Diajukan</h3>
                            <p class="text-muted mb-4 ff-secondary">
                                Berikut beberapa pertanyaan umum tentang kos kami. Jika masih ada yang ingin ditanyakan, silakan hubungi kami langsung.
                            </p>
                            <div>
                                <a href="https://wa.me/6281315793349" target="_blank" class="btn btn-success btn-label rounded-pill">
                                    <i class="ri-whatsapp-line label-icon align-middle rounded-pill fs-16 me-2"></i> Hubungi via WhatsApp
                                </a>
                                <a href="mailto:fikri225456@gmail.com.com" class="btn btn-primary btn-label rounded-pill">
                                    <i class="ri-mail-line label-icon align-middle rounded-pill fs-16 me-2"></i> Kirim Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-lg-5 g-4">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-1">
                                <i class="ri-question-line fs-24 align-middle text-success me-1"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fw-semibold">Informasi Umum</h5>
                            </div>
                        </div>
                        <div class="accordion" id="faq-kos">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        Berapa jumlah kamar dan statusnya?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faq-kos">
                                    <div class="accordion-body">
                                        Kos kami memiliki 6 kamar.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        Apakah bisa melihat langsung lokasi kos?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#faq-kos">
                                    <div class="accordion-body">
                                        Tentu! Silakan kunjungi kami langsung. Alamat lengkap bisa Anda lihat di bagian "Kontak" di bawah halaman ini.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        Fasilitas apa saja yang tersedia?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faq-kos">
                                    <div class="accordion-body">
                                        Kami menyediakan kamar mandi dalam, Kasur Lantai, Rak Baju, tempat parkir motor.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                        Bagaimana cara memesan kamar?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faq-kos">
                                    <div class="accordion-body">
                                        Anda bisa memesan atau menanyakan ketersediaan kamar langsung melalui WhatsApp atau datang langsung ke lokasi.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                        Berapa ukuran kamar di kos ini?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faq-kos">
                                <div class="accordion-body">
                                    Setiap kamar berukuran 3,5 meter x 5 meter, cukup luas dan nyaman untuk ditinggali sendiri maupun berdua.
                                </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-1">
                                <i class="ri-shield-user-line fs-24 align-middle text-success me-1"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fw-semibold">Ketentuan & Lain-lain</h5>
                            </div>
                        </div>
                        <div class="accordion" id="faq-others">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqk1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsek1">
                                        Apakah ada batasan untuk tamu?
                                    </button>
                                </h2>
                                <div id="collapsek1" class="accordion-collapse collapse show" data-bs-parent="#faq-others">
                                    <div class="accordion-body">
                                        Demi kenyamanan bersama, tamu lawan jenis tidak diperbolehkan menginap. Tamu hanya diperbolehkan berkunjung sampai pukul 21.00 WIB.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqk2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsek2">
                                        Apakah ada pembayaran online?
                                    </button>
                                </h2>
                                <div id="collapsek2" class="accordion-collapse collapse" data-bs-parent="#faq-others">
                                    <div class="accordion-body">
                                        Untuk saat ini, pembayaran bisa dilakukan via transfer bank atau QRIS. Informasi nomor rekening akan diberikan setelah konfirmasi.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqk3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsek3">
                                    Apakah air tersedia 24 jam?
                                </button>
                                </h2>
                                <div id="collapsek3" class="accordion-collapse collapse" data-bs-parent="#faq-others">
                                <div class="accordion-body">
                                    Ya, air di kos kami dijamin tidak akan mati dan tersedia 24 jam penuh setiap hari.
                                </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqk4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsek4">
                                    Berapa minimal waktu sewa?
                                    </button>
                                </h2>
                                <div id="collapsek4" class="accordion-collapse collapse" data-bs-parent="#faq-others">
                                    <div class="accordion-body">
                                    Minimal sewa adalah 1 bulan. Tidak tersedia sistem harian/mingguan.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end faqs -->

        <!-- SECTION: Lokasi Kos -->
        <section class="section bg-light" id="lokasi">
        <div class="container">
            <div class="text-center mb-4">
            <h3 class="fw-semibold">Lokasi Kos</h3>
            <p class="text-muted ff-secondary">
                Berikut adalah lokasi Kos Bu Aspiyah. Klik peta untuk membuka di Google Maps.
            </p>
            </div>

            <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15831.170043738534!2d112.5880371!3d-7.2925238!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7807006753476d%3A0x34a76384b4491661!2sKos%20Bu%20Aspiyah!5e0!3m2!1sid!2sid!4v1746338914240!5m2!1sid!2sid"
                        width="600"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            </div>
        </div>
        </section>


    </div>
    <!-- end layout wrapper -->


  
</div>
@endsection



