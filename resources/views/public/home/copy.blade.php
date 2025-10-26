@extends('public.layouts.app')

@section('content')
    <div data-bs-spy="scroll" data-bs-target="#navbar-example">

        <!-- Begin page -->
        <div class="layout-wrapper landing">

            <!-- start hero section -->
            <section class="section pb-0 hero-section" id="hero"
                style="background: linear-gradient(135deg, #2d5016 0%, #5a9216 50%, #7cb342 100%); position: relative; overflow: hidden; min-height: 100vh; display: flex; align-items: center;">
                <div class="bg-overlay"
                    style="opacity: 0.15; background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>

                <!-- Animated Rice Field Elements -->
                <div class="position-absolute" style="bottom: 0; left: 0; right: 0; height: 200px; opacity: 0.1;">
                    <svg viewBox="0 0 1440 200" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#ffffff" d="M0,100 Q360,50 720,100 T1440,100 L1440,200 L0,200 Z" opacity="0.3">
                            <animate attributeName="d" dur="10s" repeatCount="indefinite"
                                values="M0,100 Q360,50 720,100 T1440,100 L1440,200 L0,200 Z;
                                        M0,100 Q360,150 720,100 T1440,100 L1440,200 L0,200 Z;
                                        M0,100 Q360,50 720,100 T1440,100 L1440,200 L0,200 Z" />
                        </path>
                    </svg>
                </div>

                <div class="container position-relative" style="z-index: 1;">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mt-4 pt-2 animate-fade-in">
                                <!-- Badge -->
                                <div class="mb-3">
                                    <span class="badge px-4 py-2 fs-13 rounded-pill shadow-lg"
                                        style="background: rgba(255,255,255,0.95); color: #2d5016;">
                                        <i class="ri-leaf-line me-2 text-success"></i>Kos Asri di Area Persawahan Gresik
                                    </span>
                                </div>

                                <h1 class="fw-bold mb-3 lh-base text-white"
                                    style="font-size: clamp(1.8rem, 5vw, 3.5rem); text-shadow: 2px 4px 8px rgba(0,0,0,0.3);">
                                    Kos Asik, Nyaman & Asri di <span style="color: #ffd700;">KostASH</span>
                                </h1>

                                <p class="lead lh-base mb-4 text-white"
                                    style="font-size: clamp(0.95rem, 2.5vw, 1.15rem); text-shadow: 1px 2px 4px rgba(0,0,0,0.3); max-width: 700px; margin: 0 auto;">
                                    Hunian kost nyaman di Gresik dengan suasana persawahan yang asri. Cocok untuk pelajar,
                                    mahasiswa, dan pekerja yang mencari ketenangan.
                                </p>

                                <div class="d-flex gap-2 gap-md-3 justify-content-center mt-4 flex-wrap px-3">
                                    <a href="#room"
                                        class="btn btn-lg rounded-pill shadow-lg hover-lift flex-fill flex-md-grow-0"
                                        style="background: #ffd700; color: #2d5016; border: none; font-weight: 600; padding: 0.875rem 2rem;">
                                        <i class="ri-home-heart-line align-middle fs-18 me-2"></i>
                                        <span class="d-none d-sm-inline">Lihat</span> Kamar
                                    </a>
                                    <a href="https://wa.me/6281315793349?text=Halo,%20saya%20tertarik%20dengan%20KostASH"
                                        target="_blank"
                                        class="btn btn-lg rounded-pill shadow-lg hover-lift flex-fill flex-md-grow-0"
                                        style="background: rgba(255,255,255,0.95); color: #2d5016; border: none; font-weight: 600; padding: 0.875rem 2rem;">
                                        <i class="ri-whatsapp-line align-middle fs-18 me-2"></i>
                                        <span class="d-none d-sm-inline">Hubungi</span> WA
                                    </a>
                                </div>

                                <!-- Stats Section - Mobile Optimized -->
                                <div class="row mt-4 pt-3 g-3 mx-auto" style="max-width: 600px;">
                                    <div class="col-4">
                                        <div class="stat-card p-3 rounded-3"
                                            style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                                            <h2 class="fw-bold mb-1 text-white counter-value" data-target="6"
                                                style="font-size: clamp(1.5rem, 4vw, 2.5rem);">0</h2>
                                            <p class="text-white mb-0" style="font-size: clamp(0.75rem, 2vw, 0.9rem);">Kamar
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-card p-3 rounded-3"
                                            style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                                            <h2 class="fw-bold mb-1 text-white"
                                                style="font-size: clamp(1.5rem, 4vw, 2.5rem);">24/7</h2>
                                            <p class="text-white mb-0" style="font-size: clamp(0.75rem, 2vw, 0.9rem);">
                                                Support</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-card p-3 rounded-3"
                                            style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                                            <h2 class="fw-bold mb-1 text-white counter-value" data-target="100"
                                                style="font-size: clamp(1.5rem, 4vw, 2.5rem);">0</h2>
                                            <p class="text-white mb-0" style="font-size: clamp(0.75rem, 2vw, 0.9rem);">%
                                                Puas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Carousel - Mobile Optimized -->
                            <div class="mt-4 mt-md-5 pt-3 mb-n5 mb-md-n5">
                                <div class="carousel slide carousel-fade shadow-lg" data-bs-ride="carousel"
                                    id="heroCarousel"
                                    style="border-radius: 20px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3);">
                                    <div class="carousel-indicators" style="margin-bottom: 0.5rem;">
                                        @if (isset($viewGalleries) && $viewGalleries->isNotEmpty())
                                            @foreach ($viewGalleries as $i => $gallery)
                                                <button type="button" data-bs-target="#heroCarousel"
                                                    data-bs-slide-to="{{ $i }}"
                                                    class="{{ $i === 0 ? 'active' : '' }}"
                                                    style="width: 10px; height: 10px; border-radius: 50%; background-color: #ffd700;"></button>
                                            @endforeach
                                        @else
                                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0"
                                                class="active"
                                                style="width: 10px; height: 10px; border-radius: 50%; background-color: #ffd700;"></button>
                                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"
                                                style="width: 10px; height: 10px; border-radius: 50%; background-color: #ffd700;"></button>
                                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"
                                                style="width: 10px; height: 10px; border-radius: 50%; background-color: #ffd700;"></button>
                                        @endif
                                    </div>

                                    <div class="carousel-inner">
                                        @if (isset($viewGalleries) && $viewGalleries->isNotEmpty())
                                            @foreach ($viewGalleries as $i => $gallery)
                                                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}"
                                                    data-bs-interval="4000">
                                                    <img src="{{ asset('storage/' . $gallery->filename) }}"
                                                        class="d-block w-100" alt="{{ $gallery->title }}"
                                                        style="height: clamp(250px, 50vw, 450px); object-fit: cover;">
                                                    <div class="carousel-caption d-none d-md-block p-2 p-md-3 rounded-3"
                                                        style="background: rgba(45,80,22,0.85); backdrop-filter: blur(5px); bottom: 1rem; left: 50%; transform: translateX(-50%); width: auto; max-width: 80%;">
                                                        <h5 class="text-white fw-bold mb-0"
                                                            style="font-size: clamp(0.9rem, 2vw, 1.1rem);">
                                                            {{ $gallery->title }}</h5>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="carousel-item active" data-bs-interval="4000">
                                                <img src="{{ asset('assets/images/image-lp.jpg') }}" class="d-block w-100"
                                                    style="height: clamp(250px, 50vw, 450px); object-fit: cover;"
                                                    alt="KostASH">
                                            </div>
                                            <div class="carousel-item" data-bs-interval="4000">
                                                <img src="{{ asset('assets/images/image-lp2.jpg') }}"
                                                    class="d-block w-100"
                                                    style="height: clamp(250px, 50vw, 450px); object-fit: cover;"
                                                    alt="KostASH">
                                            </div>
                                            <div class="carousel-item" data-bs-interval="4000">
                                                <img src="{{ asset('assets/images/image-lp3.jpg') }}"
                                                    class="d-block w-100"
                                                    style="height: clamp(250px, 50vw, 450px); object-fit: cover;"
                                                    alt="KostASH">
                                            </div>
                                        @endif
                                    </div>

                                    @if (isset($viewGalleries) && $viewGalleries->isNotEmpty() && $viewGalleries->count() > 1)
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#heroCarousel" data-bs-slide="prev" style="width: 15%;">
                                            <span class="carousel-control-prev-icon rounded-circle p-2 p-md-3"
                                                style="background-color: rgba(45,80,22,0.8); backdrop-filter: blur(5px);"
                                                aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#heroCarousel" data-bs-slide="next" style="width: 15%;">
                                            <span class="carousel-control-next-icon rounded-circle p-2 p-md-3"
                                                style="background-color: rgba(45,80,22,0.8); backdrop-filter: blur(5px);"
                                                aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1440 120">
                        <path fill="#ffffff" d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z"></path>
                    </svg>
                </div>
            </section>
            <!-- end hero section -->

            <!-- start services -->
            <section class="section py-4 py-md-5" id="services"
                style="background: linear-gradient(to bottom, #ffffff 0%, #f1f8e9 100%);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mb-4 mb-md-5 animate-slide-up">
                                <span class="badge px-3 px-md-4 py-2 rounded-pill mb-3 shadow-sm"
                                    style="background: #e8f5e9; color: #2d5016; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                    <i class="ri-star-line me-1"></i>Layanan Terbaik
                                </span>
                                <h2 class="mb-3 fw-bold" style="color: #2d5016; font-size: clamp(1.5rem, 4vw, 2.5rem);">
                                    Fasilitas KostASH</h2>
                                <p class="text-muted" style="font-size: clamp(0.875rem, 2vw, 1rem);">Nyaman, Aman, dan
                                    Responsif untuk kenyamanan Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 g-md-4">
                        <!-- Service Cards - Mobile Optimized -->
                        <div class="col-6 col-lg-4">
                            <div class="card service-card border-0 shadow-sm h-100 hover-lift"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4 text-center">
                                    <div class="avatar-md mx-auto mb-3"
                                        style="width: clamp(50px, 12vw, 70px); height: clamp(50px, 12vw, 70px);">
                                        <div class="avatar-title rounded-circle h-100 w-100 d-flex align-items-center justify-content-center"
                                            style="background: #e8f5e9;">
                                            <i class="ri-customer-service-2-line text-success"
                                                style="font-size: clamp(1.5rem, 5vw, 2.25rem);"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-2"
                                        style="font-size: clamp(0.875rem, 2.5vw, 1.1rem); color: #2d5016;">Respon 24/7</h6>
                                    <p class="text-muted mb-2 small" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                        Siap membantu kapan saja</p>
                                    <span class="badge rounded-pill"
                                        style="background: #e8f5e9; color: #2d5016; font-size: 0.7rem;">Fast
                                        Response</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-4">
                            <div class="card service-card border-0 shadow-sm h-100 hover-lift"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4 text-center">
                                    <div class="avatar-md mx-auto mb-3"
                                        style="width: clamp(50px, 12vw, 70px); height: clamp(50px, 12vw, 70px);">
                                        <div class="avatar-title rounded-circle h-100 w-100 d-flex align-items-center justify-content-center"
                                            style="background: #e3f2fd;">
                                            <i class="ri-hotel-bed-line"
                                                style="color: #1976d2; font-size: clamp(1.5rem, 5vw, 2.25rem);"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-2"
                                        style="font-size: clamp(0.875rem, 2.5vw, 1.1rem); color: #2d5016;">Siap Pakai</h6>
                                    <p class="text-muted mb-2 small" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                        Kasur & rak lengkap</p>
                                    <span class="badge rounded-pill"
                                        style="background: #e3f2fd; color: #1976d2; font-size: 0.7rem;">Furnished</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-4">
                            <div class="card service-card border-0 shadow-sm h-100 hover-lift"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4 text-center">
                                    <div class="avatar-md mx-auto mb-3"
                                        style="width: clamp(50px, 12vw, 70px); height: clamp(50px, 12vw, 70px);">
                                        <div class="avatar-title rounded-circle h-100 w-100 d-flex align-items-center justify-content-center"
                                            style="background: #e1f5fe;">
                                            <i class="ri-showers-line"
                                                style="color: #0288d1; font-size: clamp(1.5rem, 5vw, 2.25rem);"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-2"
                                        style="font-size: clamp(0.875rem, 2.5vw, 1.1rem); color: #2d5016;">Air 24 Jam</h6>
                                    <p class="text-muted mb-2 small" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                        Selalu lancar</p>
                                    <span class="badge rounded-pill"
                                        style="background: #e1f5fe; color: #0288d1; font-size: 0.7rem;">Non-Stop</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-4">
                            <div class="card service-card border-0 shadow-sm h-100 hover-lift"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4 text-center">
                                    <div class="avatar-md mx-auto mb-3"
                                        style="width: clamp(50px, 12vw, 70px); height: clamp(50px, 12vw, 70px);">
                                        <div class="avatar-title rounded-circle h-100 w-100 d-flex align-items-center justify-content-center"
                                            style="background: #fff3e0;">
                                            <i class="ri-home-gear-line"
                                                style="color: #f57c00; font-size: clamp(1.5rem, 5vw, 2.25rem);"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-2"
                                        style="font-size: clamp(0.875rem, 2.5vw, 1.1rem); color: #2d5016;">Area Aman</h6>
                                    <p class="text-muted mb-2 small" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                        Berpagar & terjaga</p>
                                    <span class="badge rounded-pill"
                                        style="background: #fff3e0; color: #f57c00; font-size: 0.7rem;">Secure</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-4">
                            <div class="card service-card border-0 shadow-sm h-100 hover-lift"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4 text-center">
                                    <div class="avatar-md mx-auto mb-3"
                                        style="width: clamp(50px, 12vw, 70px); height: clamp(50px, 12vw, 70px);">
                                        <div class="avatar-title rounded-circle h-100 w-100 d-flex align-items-center justify-content-center"
                                            style="background: #fce4ec;">
                                            <i class="mdi mdi-hanger"
                                                style="color: #c2185b; font-size: clamp(1.5rem, 5vw, 2.25rem);"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-2"
                                        style="font-size: clamp(0.875rem, 2.5vw, 1.1rem); color: #2d5016;">Jemuran</h6>
                                    <p class="text-muted mb-2 small" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                        Area bersama</p>
                                    <span class="badge rounded-pill"
                                        style="background: #fce4ec; color: #c2185b; font-size: 0.7rem;">Shared</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-4">
                            <div class="card service-card border-0 shadow-sm h-100 hover-lift"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4 text-center">
                                    <div class="avatar-md mx-auto mb-3"
                                        style="width: clamp(50px, 12vw, 70px); height: clamp(50px, 12vw, 70px);">
                                        <div class="avatar-title rounded-circle h-100 w-100 d-flex align-items-center justify-content-center"
                                            style="background: #f3e5f5;">
                                            <i class="ri-delete-bin-line"
                                                style="color: #7b1fa2; font-size: clamp(1.5rem, 5vw, 2.25rem);"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-2"
                                        style="font-size: clamp(0.875rem, 2.5vw, 1.1rem); color: #2d5016;">Tempat Sampah
                                    </h6>
                                    <p class="text-muted mb-2 small" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                        Lingkungan bersih</p>
                                    <span class="badge rounded-pill"
                                        style="background: #f3e5f5; color: #7b1fa2; font-size: 0.7rem;">Clean</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="text-center mt-4 mt-md-5">
                        <a href="#room" class="text-decoration-none">
                            <div class="scroll-indicator mx-auto"
                                style="width: 30px; height: 50px; border: 2px solid #5a9216; border-radius: 20px; position: relative;">
                                <div class="scroll-dot"
                                    style="width: 6px; height: 6px; background: #5a9216; border-radius: 50%; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); animation: scroll-down 2s infinite;">
                                </div>
                            </div>
                            <p class="text-muted mt-2 small">Scroll untuk lihat kamar</p>
                        </a>
                    </div>
                </div>
            </section>
            <!-- end services -->

            <!-- start rooms section -->
            <section class="section py-4 py-md-5" id="room"
                style="background: linear-gradient(to bottom, #f1f8e9 0%, #ffffff 100%);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mb-4 mb-md-5 animate-slide-up">
                                <span class="badge px-3 px-md-4 py-2 rounded-pill mb-3 shadow-sm"
                                    style="background: #e8f5e9; color: #2d5016; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                    <i class="ri-home-heart-line me-1"></i>Pilihan Kamar
                                </span>
                                <h2 class="mb-3 fw-bold" style="color: #2d5016; font-size: clamp(1.5rem, 4vw, 2.5rem);">
                                    Kamar Tersedia</h2>
                                <p class="text-muted px-3" style="font-size: clamp(0.875rem, 2vw, 1rem);">Pilih kamar yang
                                    sesuai kebutuhan Anda. Info real-time!</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 g-md-4">
                        @foreach ($rooms->sortBy(function ($room) {
            preg_match('/\d+/', $room->name, $matches);
            return $matches ? (int) $matches[0] : 0;
        }) as $room)
                            @php
                                $tenant = $users->firstWhere('room_id', $room->id);
                                $isOccupied = $tenant !== null;
                            @endphp
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card room-card border-0 shadow-sm h-100 overflow-hidden hover-lift"
                                    style="border-radius: 20px;">
                                    <!-- Room Image -->
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top room-img"
                                            alt="{{ $room->name }}"
                                            style="height: clamp(180px, 40vw, 240px); object-fit: cover;">

                                        <!-- Status Badge -->
                                        <div class="position-absolute top-0 end-0 m-2 m-md-3">
                                            @if ($isOccupied)
                                                <span class="badge px-2 px-md-3 py-1 py-md-2 shadow"
                                                    style="background: rgba(220, 38, 38, 0.95); font-size: clamp(0.7rem, 2vw, 0.875rem);">
                                                    <i class="ri-close-circle-line me-1"></i> Terisi
                                                </span>
                                            @else
                                                <span class="badge px-2 px-md-3 py-1 py-md-2 shadow pulse-badge"
                                                    style="background: rgba(34, 197, 94, 0.95); font-size: clamp(0.7rem, 2vw, 0.875rem);">
                                                    <i class="ri-checkbox-circle-line me-1"></i> Tersedia
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quick View Badge -->
                                        <div class="position-absolute top-0 start-0 m-2 m-md-3">
                                            <span class="badge px-2 px-md-3 py-1 py-md-2 shadow"
                                                style="background: rgba(255, 215, 0, 0.95); color: #2d5016; font-size: clamp(0.7rem, 2vw, 0.875rem);">
                                                <i class="ri-star-fill me-1"></i> Premium
                                            </span>
                                        </div>
                                    </div>

                                    <div class="card-body p-3 p-md-4">
                                        <!-- Room Title -->
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded me-2 me-md-3 d-flex align-items-center justify-content-center"
                                                style="background: #e8f5e9; width: clamp(35px, 8vw, 45px); height: clamp(35px, 8vw, 45px);">
                                                <i class="ri-door-line text-success"
                                                    style="font-size: clamp(1rem, 3vw, 1.25rem);"></i>
                                            </div>
                                            <h5 class="card-title mb-0 fw-bold"
                                                style="color: #2d5016; font-size: clamp(1rem, 3vw, 1.25rem);">
                                                {{ $room->name }}</h5>
                                        </div>

                                        <!-- Room Info -->
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center text-muted mb-2"
                                                style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                                <i class="ri-ruler-line me-2" style="color: #5a9216;"></i>
                                                <span>3,5m x 5m</span>
                                            </div>
                                            <div class="d-flex align-items-center text-muted"
                                                style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                                <i class="ri-user-line me-2" style="color: #5a9216;"></i>
                                                <span>1-2 Orang</span>
                                            </div>
                                        </div>

                                        <!-- Status Box -->
                                        <div class="alert border-0 mb-3 p-2 p-md-3" role="alert"
                                            style="background: {{ $isOccupied ? 'rgba(220, 38, 38, 0.1)' : 'rgba(34, 197, 94, 0.1)' }};">
                                            <div class="d-flex align-items-center">
                                                <i class="{{ $isOccupied ? 'ri-lock-line' : 'ri-check-double-line' }} me-2"
                                                    style="font-size: clamp(1.25rem, 4vw, 1.5rem); color: {{ $isOccupied ? '#dc2626' : '#22c55e' }};"></i>
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold"
                                                        style="color: {{ $isOccupied ? '#dc2626' : '#22c55e' }}; font-size: clamp(0.875rem, 2vw, 1rem);">
                                                        {{ $isOccupied ? 'Tidak Tersedia' : 'Siap Dihuni' }}</div>
                                                    <div class="small text-muted"
                                                        style="font-size: clamp(0.7rem, 1.8vw, 0.8rem);">
                                                        {{ $isOccupied ? 'Sedang terisi' : 'Bisa disewa sekarang' }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        @if (!$isOccupied)
                                            <a href="https://wa.me/6281315793349?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($room->name) }}%20di%20KostASH%20Gresik"
                                                target="_blank"
                                                class="btn w-100 btn-label waves-effect waves-light shadow-sm hover-lift d-flex align-items-center justify-content-center"
                                                style="background: #22c55e; color: white; border: none; border-radius: 12px; padding: 0.75rem; font-weight: 600; font-size: clamp(0.875rem, 2vw, 1rem);">
                                                <i class="ri-whatsapp-line label-icon align-middle me-2"
                                                    style="font-size: clamp(1rem, 3vw, 1.25rem);"></i>
                                                Hubungi Sekarang
                                            </a>
                                        @else
                                            <button
                                                class="btn w-100 disabled d-flex align-items-center justify-content-center"
                                                disabled
                                                style="background: #e5e7eb; color: #6b7280; border: none; border-radius: 12px; padding: 0.75rem; font-size: clamp(0.875rem, 2vw, 1rem);">
                                                <i class="ri-information-line me-2"></i>
                                                Tidak Tersedia
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="card-footer bg-transparent border-top p-2 p-md-3">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <span class="text-muted d-flex align-items-center"
                                                style="font-size: clamp(0.7rem, 1.8vw, 0.8rem);">
                                                <i class="ri-price-tag-3-line me-1"></i>
                                                Harga Terjangkau
                                            </span>
                                            <span class="badge rounded-pill"
                                                style="background: #e8f5e9; color: #2d5016; font-size: clamp(0.7rem, 1.8vw, 0.75rem);">
                                                <i class="ri-map-pin-2-line me-1"></i>Strategis
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- end rooms -->

            <!-- start gallery -->
            <section class="section py-4 py-md-5" id="gallery" style="background: #f1f8e9;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mb-4 mb-md-5 animate-slide-up">
                                <span class="badge px-3 px-md-4 py-2 rounded-pill mb-3 shadow-sm"
                                    style="background: #e8f5e9; color: #2d5016; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                    <i class="ri-gallery-line me-1"></i>Dokumentasi
                                </span>
                                <h2 class="mb-3 fw-bold" style="color: #2d5016; font-size: clamp(1.5rem, 4vw, 2.5rem);">
                                    Galeri Foto</h2>
                                <p class="text-muted px-3" style="font-size: clamp(0.875rem, 2vw, 1rem);">Lihat foto kamar
                                    dan fasilitas lengkap kami</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <div class="btn-group flex-wrap gap-2 d-inline-flex" role="group" id="filter">
                            <button type="button" class="btn btn-sm rounded-pill px-3 px-md-4 filter-btn active"
                                data-filter="*"
                                style="background: #2d5016; color: white; border: none; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                <i class="ri-grid-line me-1"></i>Semua
                            </button>
                            <button type="button"
                                class="btn btn-sm btn-outline-success rounded-pill px-3 px-md-4 filter-btn"
                                data-filter=".room" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                <i class="ri-door-line me-1"></i>Kamar
                            </button>
                            <button type="button"
                                class="btn btn-sm btn-outline-success rounded-pill px-3 px-md-4 filter-btn"
                                data-filter=".facility" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                <i class="ri-tools-line me-1"></i>Fasilitas
                            </button>
                            <button type="button"
                                class="btn btn-sm btn-outline-success rounded-pill px-3 px-md-4 filter-btn"
                                data-filter=".surroundings" style="font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                <i class="ri-map-pin-line me-1"></i>Lingkungan
                            </button>
                        </div>
                    </div>

                    <div class="row gallery-wrapper g-3 g-md-4">
                        @forelse($galleries as $gallery)
                            @php
                                $categoryClasses = collect(
                                    is_array($gallery->categories)
                                        ? $gallery->categories
                                        : json_decode($gallery->categories ?? '[]'),
                                )
                                    ->map(fn($cat) => strtolower(trim($cat)))
                                    ->implode(' ');
                            @endphp

                            <div class="element-item col-6 col-md-4 col-lg-3 {{ $categoryClasses }}"
                                data-category="{{ $categoryClasses }}">
                                <div class="gallery-box card border-0 shadow-sm h-100 hover-lift"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <div class="gallery-container position-relative overflow-hidden">
                                        <a class="image-popup" href="{{ asset('storage/' . $gallery->filename) }}"
                                            title="{{ $gallery->title }}">
                                            <img class="gallery-img img-fluid w-100"
                                                src="{{ asset('storage/' . $gallery->filename) }}"
                                                alt="{{ $gallery->title }}"
                                                style="height: clamp(150px, 30vw, 220px); object-fit: cover;" />
                                            <div class="gallery-overlay">
                                                <div class="text-center">
                                                    <i class="ri-zoom-in-line text-white mb-2"
                                                        style="font-size: clamp(1.5rem, 5vw, 2rem);"></i>
                                                    <h6 class="overlay-caption text-white fw-bold mb-0"
                                                        style="font-size: clamp(0.8rem, 2vw, 1rem);">{{ $gallery->title }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="box-content p-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-1">
                                            <div class="text-muted d-flex align-items-center"
                                                style="font-size: clamp(0.65rem, 1.8vw, 0.75rem);">
                                                <i class="ri-user-line me-1"></i>
                                                <span
                                                    class="text-truncate">{{ \Illuminate\Support\Str::limit($gallery->uploader_name ?? 'Admin', 10) }}
                                                    </class=>
                                            </div>
                                            <div class="text-muted d-flex align-items-center"
                                                style="font-size: clamp(0.65rem, 1.8vw, 0.75rem);">
                                                <i class="ri-calendar-line me-1"></i>
                                                {{ \Carbon\Carbon::parse($gallery->created_at)->format('d/m/y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="mx-auto mb-4"
                                    style="width: clamp(60px, 15vw, 80px); height: clamp(60px, 15vw, 80px); background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="ri-image-line text-success"
                                        style="font-size: clamp(1.5rem, 5vw, 2.5rem);"></i>
                                </div>
                                <h6 class="text-muted">Belum ada gambar</h6>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
            <!-- end gallery -->

            <!-- start faqs -->
            <section class="section py-4 py-md-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mb-4 mb-md-5 animate-slide-up">
                                <span class="badge px-3 px-md-4 py-2 rounded-pill mb-3 shadow-sm"
                                    style="background: #fff3e0; color: #f57c00; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                    <i class="ri-question-answer-line me-1"></i>FAQ
                                </span>
                                <h3 class="mb-3 fw-bold" style="color: #2d5016; font-size: clamp(1.5rem, 4vw, 2.5rem);">
                                    Pertanyaan Umum</h3>
                                <p class="text-muted px-3 mb-4" style="font-size: clamp(0.875rem, 2vw, 1rem);">
                                    Punya pertanyaan? Hubungi kami langsung!
                                </p>
                                <div class="d-flex gap-2 gap-md-3 justify-content-center flex-wrap px-3">
                                    <a href="https://wa.me/6281315793349?text=Halo,%20saya%20mau%20tanya%20tentang%20KostASH"
                                        target="_blank"
                                        class="btn btn-lg rounded-pill shadow-lg hover-lift flex-fill flex-sm-grow-0"
                                        style="background: #22c55e; color: white; border: none; font-weight: 600; padding: 0.875rem 1.5rem; font-size: clamp(0.875rem, 2vw, 1rem); max-width: 250px;">
                                        <i class="ri-whatsapp-line align-middle me-2"
                                            style="font-size: clamp(1rem, 3vw, 1.25rem);"></i>
                                        WhatsApp
                                    </a>
                                    <a href="mailto:fikri225456@gmail.com"
                                        class="btn btn-lg rounded-pill shadow-lg hover-lift flex-fill flex-sm-grow-0"
                                        style="background: #2d5016; color: white; border: none; font-weight: 600; padding: 0.875rem 1.5rem; font-size: clamp(0.875rem, 2vw, 1rem); max-width: 250px;">
                                        <i class="ri-mail-line align-middle me-2"
                                            style="font-size: clamp(1rem, 3vw, 1.25rem);"></i>
                                        Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 g-md-4">
                        <div class="col-12 col-lg-6">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4">
                                    <div class="d-flex align-items-center mb-3 mb-md-4">
                                        <div class="rounded me-3 d-flex align-items-center justify-content-center"
                                            style="background: #e8f5e9; width: clamp(40px, 10vw, 50px); height: clamp(40px, 10vw, 50px);">
                                            <i class="ri-question-line text-success"
                                                style="font-size: clamp(1.25rem, 4vw, 1.5rem);"></i>
                                        </div>
                                        <h5 class="mb-0 fw-bold"
                                            style="color: #2d5016; font-size: clamp(1rem, 3vw, 1.25rem);">Info Umum</h5>
                                    </div>

                                    <div class="accordion accordion-flush" id="faq-kos">
                                        <div class="accordion-item border-0 mb-2"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqOne">
                                                <button class="accordion-button collapsed fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-home-line me-2" style="color: #5a9216;"></i>
                                                    Berapa jumlah kamar?
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                data-bs-parent="#faq-kos">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Kos kami memiliki 6 kamar yang nyaman dan strategis di Gresik dengan
                                                    suasana persawahan yang asri.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item border-0 mb-2"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqTwo">
                                                <button class="accordion-button fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-map-pin-line me-2" style="color: #5a9216;"></i>
                                                    Bisa lihat lokasi langsung?
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                                data-bs-parent="#faq-kos">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Tentu! Kunjungi kami langsung. Alamat lengkap ada di bagian "Lokasi" di
                                                    bawah.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item border-0 mb-2"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqThree">
                                                <button class="accordion-button collapsed fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-tools-line me-2" style="color: #5a9216;"></i>
                                                    Fasilitas apa saja?
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                data-bs-parent="#faq-kos">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Kamar mandi dalam, kasur lantai, rak baju, dan parkir motor yang aman.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item border-0 mb-2"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqFour">
                                                <button class="accordion-button collapsed fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-shopping-cart-line me-2" style="color: #5a9216;"></i>
                                                    Cara memesan kamar?
                                                </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse"
                                                data-bs-parent="#faq-kos">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Hubungi via WhatsApp atau datang langsung ke lokasi kami di Gresik.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item border-0"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqFive">
                                                <button class="accordion-button collapsed fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-ruler-line me-2" style="color: #5a9216;"></i>
                                                    Ukuran kamar?
                                                </button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse"
                                                data-bs-parent="#faq-kos">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    3,5m x 5m, cukup luas untuk 1-2 orang.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                                <div class="card-body p-3 p-md-4">
                                    <div class="d-flex align-items-center mb-3 mb-md-4">
                                        <div class="rounded me-3 d-flex align-items-center justify-content-center"
                                            style="background: #e3f2fd; width: clamp(40px, 10vw, 50px); height: clamp(40px, 10vw, 50px);">
                                            <i class="ri-shield-user-line"
                                                style="color: #1976d2; font-size: clamp(1.25rem, 4vw, 1.5rem);"></i>
                                        </div>
                                        <h5 class="mb-0 fw-bold"
                                            style="color: #2d5016; font-size: clamp(1rem, 3vw, 1.25rem);">Ketentuan</h5>
                                    </div>

                                    <div class="accordion accordion-flush" id="faq-others">
                                        <div class="accordion-item border-0 mb-2"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqk1">
                                                <button class="accordion-button fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsek1"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-group-line me-2" style="color: #1976d2;"></i>
                                                    Batasan tamu?
                                                </button>
                                            </h2>
                                            <div id="collapsek1" class="accordion-collapse collapse show"
                                                data-bs-parent="#faq-others">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Tamu lawan jenis tidak boleh menginap. Berkunjung sampai pukul 21.00
                                                    WIB.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item border-0 mb-2"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqk2">
                                                <button class="accordion-button collapsed fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsek2"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-bank-card-line me-2" style="color: #1976d2;"></i>
                                                    Pembayaran online?
                                                </button>
                                            </h2>
                                            <div id="collapsek2" class="accordion-collapse collapse"
                                                data-bs-parent="#faq-others">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Ya, via transfer bank atau QRIS. Nomor rekening akan diberikan setelah
                                                    konfirmasi.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item border-0 mb-2"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqk3">
                                                <button class="accordion-button collapsed fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsek3"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-water-flash-line me-2" style="color: #1976d2;"></i>
                                                    Air 24 jam?
                                                </button>
                                            </h2>
                                            <div id="collapsek3" class="accordion-collapse collapse"
                                                data-bs-parent="#faq-others">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Ya, air tersedia 24 jam penuh setiap hari, dijamin tidak mati.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item border-0"
                                            style="background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                                            <h2 class="accordion-header" id="faqk4">
                                                <button class="accordion-button collapsed fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsek4"
                                                    style="background: transparent; font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.875rem 1rem;">
                                                    <i class="ri-calendar-check-line me-2" style="color: #1976d2;"></i>
                                                    Minimal sewa?
                                                </button>
                                            </h2>
                                            <div id="collapsek4" class="accordion-collapse collapse"
                                                data-bs-parent="#faq-others">
                                                <div class="accordion-body"
                                                    style="font-size: clamp(0.8rem, 2vw, 0.9rem); padding: 0.875rem 1rem;">
                                                    Minimal 1 bulan. Tidak tersedia sistem harian/mingguan.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end faqs -->

            <!-- start location -->
            <section class="section py-4 py-md-5" id="lokasi" style="background: #f1f8e9;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center mb-4 mb-md-5 animate-slide-up">
                                <span class="badge px-3 px-md-4 py-2 rounded-pill mb-3 shadow-sm"
                                    style="background: #fce4ec; color: #c2185b; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                                    <i class="ri-map-pin-line me-1"></i>Lokasi Strategis
                                </span>
                                <h3 class="fw-bold" style="color: #2d5016; font-size: clamp(1.5rem, 4vw, 2.5rem);">Lokasi
                                    Kos</h3>
                                <p class="text-muted px-3" style="font-size: clamp(0.875rem, 2vw, 1rem);">
                                    Kos Bu Aspiyah - Gresik, Jawa Timur
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <div class="card border-0 shadow-lg overflow-hidden hover-lift" style="border-radius: 20px;">
                                <div class="card-body p-0">
                                    <div class="ratio ratio-16x9" style="min-height: 300px;">
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15831.170043738534!2d112.5880371!3d-7.2925238!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7807006753476d%3A0x34a76384b4491661!2sKos%20Bu%20Aspiyah!5e0!3m2!1sid!2sid!4v1746338914240!5m2!1sid!2sid"
                                            style="border:0;" allowfullscreen="" loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top p-3 p-md-4">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-start">
                                                <div class="rounded me-3 d-flex align-items-center justify-content-center"
                                                    style="background: #fce4ec; width: clamp(40px, 10vw, 50px); height: clamp(40px, 10vw, 50px); flex-shrink: 0;">
                                                    <i class="ri-map-pin-2-line"
                                                        style="color: #c2185b; font-size: clamp(1.25rem, 4vw, 1.5rem);"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-2"
                                                        style="font-size: clamp(0.9rem, 2.5vw, 1.1rem);">Kos Bu Aspiyah
                                                    </h6>
                                                    <p class="text-muted mb-0"
                                                        style="font-size: clamp(0.8rem, 2vw, 0.9rem);">Gresik, Jawa Timur
                                                    </p>
                                                    <p class="text-muted mb-0 mt-1"
                                                        style="font-size: clamp(0.75rem, 1.8vw, 0.85rem);">
                                                        <i class="ri-leaf-line me-1" style="color: #5a9216;"></i>Area
                                                        Persawahan Asri
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <a href="https://maps.app.goo.gl/your-maps-link" target="_blank"
                                                class="btn btn-lg rounded-pill w-100 w-md-auto hover-lift shadow-sm"
                                                style="background: #c2185b; color: white; border: none; font-weight: 600; padding: 0.75rem 1.5rem; font-size: clamp(0.875rem, 2vw, 1rem);">
                                                <i class="ri-navigation-line align-middle me-2"
                                                    style="font-size: clamp(1rem, 3vw, 1.25rem);"></i>
                                                Buka Maps
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Features - Mobile Optimized -->
                    <div class="row g-3 g-md-4 mt-3 mt-md-4">
                        <div class="col-6 col-md-4">
                            <div class="card border-0 shadow-sm text-center p-3 p-md-4 h-100 hover-lift"
                                style="border-radius: 15px;">
                                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width: clamp(50px, 12vw, 65px); height: clamp(50px, 12vw, 65px); background: #e3f2fd; border-radius: 50%;">
                                    <i class="ri-bus-line"
                                        style="color: #1976d2; font-size: clamp(1.5rem, 5vw, 2rem);"></i>
                                </div>
                                <h6 class="fw-semibold mb-2" style="font-size: clamp(0.875rem, 2.5vw, 1rem);">Transportasi
                                </h6>
                                <p class="text-muted mb-0 small" style="font-size: clamp(0.75rem, 2vw, 0.85rem);">Akses
                                    mudah ke angkutan umum</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card border-0 shadow-sm text-center p-3 p-md-4 h-100 hover-lift"
                                style="border-radius: 15px;">
                                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width: clamp(50px, 12vw, 65px); height: clamp(50px, 12vw, 65px); background: #e8f5e9; border-radius: 50%;">
                                    <i class="ri-shopping-bag-line text-success"
                                        style="font-size: clamp(1.5rem, 5vw, 2rem);"></i>
                                </div>
                                <h6 class="fw-semibold mb-2" style="font-size: clamp(0.875rem, 2.5vw, 1rem);">Fasilitas
                                </h6>
                                <p class="text-muted mb-0 small" style="font-size: clamp(0.75rem, 2vw, 0.85rem);">Dekat
                                    minimarket & warung</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card border-0 shadow-sm text-center p-3 p-md-4 h-100 hover-lift"
                                style="border-radius: 15px;">
                                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width: clamp(50px, 12vw, 65px); height: clamp(50px, 12vw, 65px); background: #fff3e0; border-radius: 50%;">
                                    <i class="ri-shield-check-line"
                                        style="color: #f57c00; font-size: clamp(1.5rem, 5vw, 2rem);"></i>
                                </div>
                                <h6 class="fw-semibold mb-2" style="font-size: clamp(0.875rem, 2.5vw, 1rem);">Lingkungan
                                </h6>
                                <p class="text-muted mb-0 small" style="font-size: clamp(0.75rem, 2vw, 0.85rem);">Area
                                    tenang & aman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end location -->

            <!-- Floating WhatsApp Button -->
            <a href="https://wa.me/6281315793349?text=Halo,%20saya%20tertarik%20dengan%20KostASH%20Gresik" target="_blank"
                class="floating-wa-btn shadow-lg"
                style="position: fixed; bottom: 20px; right: 20px; width: clamp(50px, 12vw, 60px); height: clamp(50px, 12vw, 60px); background: #22c55e; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 1000; text-decoration: none; transition: all 0.3s ease; animation: pulse-wa 2s infinite;">
                <i class="ri-whatsapp-line" style="font-size: clamp(1.5rem, 5vw, 2rem);"></i>
            </a>

        </div>
        <!-- end layout wrapper -->

        <!-- Custom Styles -->
        <style>
            /* Base Responsive Typography */
            * {
                -webkit-tap-highlight-color: transparent;
            }

            body {
                overflow-x: hidden;
            }

            /* Animations */
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-15px);
                }
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            @keyframes pulse-wa {

                0%,
                100% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
                }

                50% {
                    transform: scale(1.05);
                    box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
                }
            }

            @keyframes scroll-down {

                0%,
                100% {
                    transform: translateX(-50%) translateY(0);
                    opacity: 1;
                }

                50% {
                    transform: translateX(-50%) translateY(15px);
                    opacity: 0.5;
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.8s ease-out;
            }

            .animate-slide-up {
                animation: fadeIn 1s ease-out;
            }

            /* Hover Effects */
            .hover-lift {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .hover-lift:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 35px rgba(45, 80, 22, 0.2) !important;
            }

            @media (max-width: 768px) {
                .hover-lift:active {
                    transform: translateY(-4px);
                }
            }

            /* Stats Cards */
            .stat-card {
                transition: all 0.3s ease;
            }

            .stat-card:hover {
                transform: scale(1.05);
                background: rgba(255, 255, 255, 0.25) !important;
            }

            /* Service Cards */
            .service-card {
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .service-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.5s ease;
            }

            .service-card:hover::before {
                left: 100%;
            }

            .service-card:active {
                transform: scale(0.98);
            }

            /* Room Cards */
            .room-card {
                transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .room-img {
                transition: transform 0.5s ease;
            }

            .room-card:hover .room-img {
                transform: scale(1.1);
            }

            @media (max-width: 768px) {
                .room-card:active .room-img {
                    transform: scale(1.05);
                }
            }

            /* Pulse Badge */
            .pulse-badge {
                animation: pulse 2s ease-in-out infinite;
            }

            /* Gallery */
            .gallery-box {
                transition: all 0.3s ease;
            }

            .gallery-img {
                transition: transform 0.4s ease;
            }

            .gallery-box:hover .gallery-img {
                transform: scale(1.15);
            }

            .gallery-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(45, 80, 22, 0.92) 0%, rgba(90, 146, 22, 0.92) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .gallery-box:hover .gallery-overlay {
                opacity: 1;
            }

            .overlay-caption {
                transform: translateY(15px);
                transition: transform 0.3s ease;
            }

            .gallery-box:hover .overlay-caption {
                transform: translateY(0);
            }

            /* Filter Buttons */
            .filter-btn {
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .filter-btn:hover {
                transform: translateY(-2px);
            }

            .filter-btn.active {
                background: #2d5016 !important;
                color: white !important;
                border-color: #2d5016 !important;
            }

            /* Accordion */
            .accordion-button {
                transition: all 0.3s ease;
            }

            .accordion-button:not(.collapsed) {
                background: linear-gradient(135deg, #2d5016 0%, #5a9216 100%);
                /* color: white; */
                box-shadow: 0 4px 15px rgba(45, 80, 22, 0.3);
            }

            .accordion-button:not(.collapsed)::after {
                filter: brightness(0) invert(1);
            }

            .accordion-button:focus {
                box-shadow: none;
                border-color: transparent;
            }

            /* Floating WhatsApp */
            .floating-wa-btn:hover {
                transform: scale(1.1);
                box-shadow: 0 15px 40px rgba(34, 197, 94, 0.4) !important;
            }

            .floating-wa-btn:active {
                transform: scale(1.05);
            }

            /* Smooth Scrolling */
            html {
                scroll-behavior: smooth;
            }

            /* Touch Optimization for Mobile */
            @media (max-width: 768px) {

                .btn,
                .card,
                a {
                    -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1);
                }

                /* Increase touch targets */
                .btn {
                    min-height: 44px;
                }

                /* Optimize carousel for touch */
                .carousel-control-prev,
                .carousel-control-next {
                    opacity: 0.7;
                }

                .carousel-control-prev:active,
                .carousel-control-next:active {
                    opacity: 1;
                }
            }

            /* Loading States */
            img {
                transition: opacity 0.3s ease;
            }

            img:not([src]) {
                opacity: 0;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, #2d5016 0%, #5a9216 100%);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #2d5016;
            }

            /* Responsive Image Fixes */
            @media (max-width: 576px) {
                .carousel-item img {
                    min-height: 250px;
                    max-height: 350px;
                }
            }

            /* Prevent horizontal scroll */
            .container,
            .row {
                max-width: 100%;
            }

            /* Optimize for very small screens */
            @media (max-width: 360px) {
                .badge {
                    font-size: 0.7rem !important;
                    padding: 0.35rem 0.75rem !important;
                }
            }
        </style>

        <!-- Custom JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Counter Animation
                const counters = document.querySelectorAll('.counter-value');
                const observerOptions = {
                    threshold: 0.5,
                    rootMargin: '0px'
                };

                const counterObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                            entry.target.classList.add('counted');
                            const target = parseInt(entry.target.getAttribute('data-target'));
                            const duration = 2000;
                            const increment = target / (duration / 16);
                            let current = 0;

                            const updateCounter = () => {
                                if (current < target) {
                                    current += increment;
                                    entry.target.textContent = Math.ceil(current);
                                    requestAnimationFrame(updateCounter);
                                } else {
                                    entry.target.textContent = target;
                                }
                            };

                            updateCounter();
                        }
                    });
                }, observerOptions);

                counters.forEach(counter => counterObserver.observe(counter));

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        if (href !== '#' && href.length > 1) {
                            e.preventDefault();
                            const target = document.querySelector(href);
                            if (target) {
                                const offsetTop = target.offsetTop - 80;
                                window.scrollTo({
                                    top: offsetTop,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    });
                });

                // Animate elements on scroll
                const animateOnScroll = () => {
                    const elements = document.querySelectorAll('.animate-slide-up, .animate-fade-in');

                    const animateObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                                animateObserver.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    });

                    elements.forEach(element => {
                        element.style.opacity = '0';
                        element.style.transform = 'translateY(30px)';
                        element.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                        animateObserver.observe(element);
                    });
                };

                animateOnScroll();

                // Gallery Filter - Mobile Optimized
                const filterButtons = document.querySelectorAll('.filter-btn');
                const galleryItems = document.querySelectorAll('.element-item');

                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Update active state
                        filterButtons.forEach(btn => {
                            btn.classList.remove('active');
                            btn.style.background = '';
                            btn.style.color = '';
                        });

                        this.classList.add('active');
                        this.style.background = '#2d5016';
                        this.style.color = 'white';

                        const filterValue = this.getAttribute('data-filter');

                        galleryItems.forEach(item => {
                            if (filterValue === '*' || item.classList.contains(filterValue
                                    .replace('.', ''))) {
                                item.style.display = 'block';
                                item.style.animation = 'fadeIn 0.5s ease-out';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                });

                // Image Lazy Loading Enhancement
                const images = document.querySelectorAll('img[data-src]');
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    });
                }, {
                    rootMargin: '50px'
                });

                images.forEach(img => imageObserver.observe(img));

                // Touch-friendly carousel enhancement
                const carousel = document.querySelector('#heroCarousel');
                if (carousel) {
                    let touchStartX = 0;
                    let touchEndX = 0;

                    carousel.addEventListener('touchstart', (e) => {
                        touchStartX = e.changedTouches[0].screenX;
                    }, {
                        passive: true
                    });

                    carousel.addEventListener('touchend', (e) => {
                        touchEndX = e.changedTouches[0].screenX;
                        handleSwipe();
                    }, {
                        passive: true
                    });

                    function handleSwipe() {
                        const swipeThreshold = 50;
                        if (touchEndX < touchStartX - swipeThreshold) {
                            // Swipe left - next
                            const nextBtn = carousel.querySelector('.carousel-control-next');
                            if (nextBtn) nextBtn.click();
                        }
                        if (touchEndX > touchStartX + swipeThreshold) {
                            // Swipe right - prev
                            const prevBtn = carousel.querySelector('.carousel-control-prev');
                            if (prevBtn) prevBtn.click();
                        }
                    }
                }

                // Floating WhatsApp button hide on scroll down
                let lastScrollTop = 0;
                const floatingBtn = document.querySelector('.floating-wa-btn');

                window.addEventListener('scroll', () => {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                    if (scrollTop > lastScrollTop && scrollTop > 300) {
                        // Scrolling down
                        floatingBtn.style.transform = 'translateY(100px)';
                        floatingBtn.style.opacity = '0';
                    } else {
                        // Scrolling up
                        floatingBtn.style.transform = 'translateY(0)';
                        floatingBtn.style.opacity = '1';
                    }

                    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
                }, {
                    passive: true
                });

                // Optimize accordion for mobile
                const accordionButtons = document.querySelectorAll('.accordion-button');
                accordionButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Small delay for smooth animation
                        setTimeout(() => {
                            this.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest',
                                inline: 'nearest'
                            });
                        }, 300);
                    });
                });

                // Performance: Debounce scroll events
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                // Add scroll indicator animation
                const scrollIndicator = document.querySelector('.scroll-indicator');
                if (scrollIndicator) {
                    window.addEventListener('scroll', debounce(() => {
                        if (window.scrollY > 100) {
                            scrollIndicator.style.opacity = '0';
                        } else {
                            scrollIndicator.style.opacity = '1';
                        }
                    }, 100), {
                        passive: true
                    });
                }

                // Preload critical images
                const criticalImages = document.querySelectorAll('.room-img, .gallery-img');
                criticalImages.forEach(img => {
                    const src = img.getAttribute('src');
                    if (src) {
                        const preloadLink = document.createElement('link');
                        preloadLink.rel = 'preload';
                        preloadLink.as = 'image';
                        preloadLink.href = src;
                        document.head.appendChild(preloadLink);
                    }
                });

                // Add ripple effect to buttons on mobile
                const buttons = document.querySelectorAll('.btn');
                buttons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        const ripple = document.createElement('span');
                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        const x = e.clientX - rect.left - size / 2;
                        const y = e.clientY - rect.top - size / 2;

                        ripple.style.width = ripple.style.height = size + 'px';
                        ripple.style.left = x + 'px';
                        ripple.style.top = y + 'px';
                        ripple.style.position = 'absolute';
                        ripple.style.borderRadius = '50%';
                        ripple.style.background = 'rgba(255,255,255,0.5)';
                        ripple.style.transform = 'scale(0)';
                        ripple.style.animation = 'ripple 0.6s ease-out';
                        ripple.style.pointerEvents = 'none';

                        this.style.position = 'relative';
                        this.style.overflow = 'hidden';
                        this.appendChild(ripple);

                        setTimeout(() => ripple.remove(), 600);
                    });
                });

                // Add CSS for ripple animation
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);

                // Network-aware image loading
                if ('connection' in navigator) {
                    const connection = navigator.connection;
                    if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
                        // Reduce image quality for slow connections
                        document.querySelectorAll('img').forEach(img => {
                            img.loading = 'lazy';
                        });
                    }
                }

                // Add haptic feedback for mobile (if supported)
                if ('vibrate' in navigator) {
                    document.querySelectorAll('.btn, .card').forEach(element => {
                        element.addEventListener('click', () => {
                            navigator.vibrate(10);
                        });
                    });
                }

                // Optimize carousel for battery
                let carouselPaused = false;
                document.addEventListener('visibilitychange', () => {
                    const carousel = document.querySelector('#heroCarousel');
                    if (carousel) {
                        if (document.hidden) {
                            bootstrap.Carousel.getInstance(carousel)?.pause();
                            carouselPaused = true;
                        } else if (carouselPaused) {
                            bootstrap.Carousel.getInstance(carousel)?.cycle();
                            carouselPaused = false;
                        }
                    }
                });

                // Add loading indicator
                window.addEventListener('load', () => {
                    document.body.classList.add('loaded');
                });

                console.log('✅ KostASH - Optimized for Mobile');
            });

            // Service Worker for offline capability (optional enhancement)
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js').catch(() => {
                        // Silently fail if service worker not available
                    });
                });
            }
        </script>

    </div>
@endsection
