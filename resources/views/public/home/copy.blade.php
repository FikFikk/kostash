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
                                <p class="lead text-muted lh-base">KostASH adalah hunian kost yang nyaman dan strategis,
                                    cocok untuk pelajar, mahasiswa, dan pekerja. Dapatkan informasi lengkap tentang
                                    ketersediaan kamar, fasilitas, dan lokasi hanya dalam sekali klik.</p>

                                <div class="d-flex gap-2 justify-content-center mt-4">
                                    <a href="#room" class="btn btn-primary">Lihat Kamar <i
                                            class="ri-arrow-right-line align-middle ms-1"></i></a>
                                    <a href="#services" class="btn btn-danger">Cek Layanan <i
                                            class="ri-eye-line align-middle ms-1"></i></a>
                                </div>
                            </div>

                            <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                                <div class="demo-img-patten-top d-none d-sm-block">
                                    <img src="{{ asset('assets/dashboard/images/landing/img-pattern.png') }}"
                                        class="d-block img-fluid" alt="...">
                                </div>
                                <div class="demo-img-patten-bottom d-none d-sm-block">
                                    <img src="{{ asset('assets/dashboard/images/landing/img-pattern.png') }}"
                                        class="d-block img-fluid" alt="...">
                                </div>

                                <div class="carousel slide carousel-fade" data-bs-ride="carousel" id="heroCarousel">
                                    <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                        @if (isset($viewGalleries) && $viewGalleries->isNotEmpty())
                                            @foreach ($viewGalleries as $i => $gallery)
                                                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}"
                                                    data-bs-interval="3000">
                                                    <img src="{{ asset('storage/' . $gallery->filename) }}"
                                                        class="d-block w-100" alt="{{ $gallery->title }}">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="carousel-item active" data-bs-interval="3000">
                                                <img src="{{ asset('assets/images/image-lp.jpg') }}" class="d-block w-100"
                                                    alt="...">
                                            </div>
                                            <div class="carousel-item" data-bs-interval="3000">
                                                <img src="{{ asset('assets/images/image-lp2.jpg') }}" class="d-block w-100"
                                                    alt="...">
                                            </div>
                                            <div class="carousel-item" data-bs-interval="3000">
                                                <img src="{{ asset('assets/images/image-lp3.jpg') }}" class="d-block w-100"
                                                    alt="...">
                                            </div>
                                        @endif
                                    </div>

                                    @if (isset($viewGalleries) && $viewGalleries->isNotEmpty() && $viewGalleries->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
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
                                <h1 class="mb-3 ff-secondary fw-semibold lh-base">Layanan KostASH – Nyaman, Aman, dan
                                    Responsif</h1>
                                <p class="text-muted">Kami memberikan berbagai fasilitas dan dukungan untuk memastikan
                                    kenyamanan dan keamanan penghuni setiap hari.</p>
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
                                    <p class="text-muted my-3 ff-secondary">Kami selalu siap membantu jika ada kendala,
                                        cukup hubungi pengelola kapan saja.</p>
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
                                    <p class="text-muted my-3 ff-secondary">Kamar dilengkapi kasur lantai dan rak baju,
                                        langsung bisa digunakan tanpa repot.</p>
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
                                    <p class="text-muted my-3 ff-secondary">Air bersih tersedia setiap saat untuk kebutuhan
                                        mandi dan mencuci.</p>
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
                                    <p class="text-muted my-3 ff-secondary">Lingkungan tertutup dan dilindungi pagar untuk
                                        menjaga keamanan penghuni.</p>
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
                                    <p class="text-muted my-3 ff-secondary">Tersedia gantungan besi untuk menjemur pakaian
                                        di area depan kost.</p>
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
                                    <p class="text-muted my-3 ff-secondary">Tempat sampah tersedia. Penghuni diharapkan
                                        menjaga kebersihan, termasuk membakar sampah secara mandiri.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end services -->

            <!-- start swiper -->
            <div class="swiper effect-coverflow-swiper rounded pb-5">
                <div class="swiper-wrapper">
                    @forelse($viewGalleries as $gallery)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $gallery->filename) }}" alt="{{ $gallery->title }}"
                                class="img-fluid" />
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <img src="{{ asset('assets/images/kostash-logo-tp.png') }}" alt="No Image"
                                class="img-fluid" />
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination swiper-pagination-dark"></div>
            </div>
            <!-- end swiper -->

            <!-- start gallery -->
            <section class="section bg-light" id="gallery">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h2 class="mb-3 fw-semibold">Galeri</h2>
                                <p class="text-muted mb-4">Lihat berbagai foto dan dokumentasi kamar serta fasilitas kos
                                    kami. Transparan dan tanpa biaya tersembunyi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <ul class="list-inline categories-filter animation-nav" id="filter">
                            <li class="list-inline-item"><a class="categories active" data-filter="*">Semua</a></li>
                            <li class="list-inline-item"><a class="categories" data-filter=".room">Kamar</a></li>
                            <li class="list-inline-item"><a class="categories" data-filter=".facility">Fasilitas</a></li>
                            <li class="list-inline-item"><a class="categories" data-filter=".surroundings">Lingkungan
                                    Sekitar</a></li>
                        </ul>
                    </div>

                    <div class="row gallery-wrapper">
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

                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 {{ $categoryClasses }}"
                                data-category="{{ $categoryClasses }}">
                                <div class="gallery-box card">
                                    <div class="gallery-container">
                                        <a class="image-popup" href="{{ asset('storage/' . $gallery->filename) }}"
                                            title="{{ $gallery->title }}">
                                            <img class="gallery-img img-fluid mx-auto"
                                                src="{{ asset('storage/' . $gallery->filename) }}"
                                                alt="{{ $gallery->title }}" />
                                            <div class="gallery-overlay">
                                                <h5 class="overlay-caption">{{ $gallery->title }}</h5>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="box-content">
                                        <div class="d-flex align-items-center mt-1 justify-content-between">
                                            <div class="text-muted">
                                                by <a href="#"
                                                    class="text-body text-truncate">{{ $gallery->uploader_name ?? 'Admin' }}</a>
                                            </div>
                                            <div class="text-muted">
                                                <i class="ri-calendar-line me-1 align-middle"></i>
                                                {{ \Carbon\Carbon::parse($gallery->created_at)->translatedFormat('d F Y') }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <p class="text-muted">Belum ada gambar yang tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
            <!-- end gallery -->


            <section class="section bg-light" id="room">
                <div class="container"> {{-- Removed extra padding class py-5 --}}
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h2 class="mb-3 fw-semibold">Pilih Kamar Anda</h2>
                                <p class="text-muted mb-4">Temukan kamar yang sesuai dengan kebutuhan Anda. Semua informasi
                                    ketersediaan diperbarui secara real-time.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($rooms->sortBy(function ($room) {
            preg_match('/\d+/', $room->name, $matches);
            return $matches ? (int) $matches[0] : 0;
        }) as $room)
                            @php
                                $tenant = $users->firstWhere('room_id', $room->id);
                                $isOccupied = $tenant !== null;
                            @endphp
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm room-card">
                                    <!-- Room Image with Status Badge -->
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top room-img"
                                            alt="{{ $room->name }}">

                                        <!-- Status Badge -->
                                        <div class="position-absolute top-0 end-0 m-3">
                                            @if ($isOccupied)
                                                <span class="badge bg-danger px-3 py-2">
                                                    <i class="ri-close-circle-line me-1"></i> Terisi
                                                </span>
                                            @else
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="ri-checkbox-circle-line me-1"></i> Tersedia
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-body p-4">
                                        <!-- Room Title -->
                                        <h5 class="card-title mb-3 fw-bold text-dark">{{ $room->name }}</h5>

                                        <!-- Status Info -->
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-4 p-3 rounded {{ $isOccupied ? 'bg-danger-subtle' : 'bg-success-subtle' }}">
                                            <div>
                                                <p class="mb-0 small text-muted">Status</p>
                                                <p
                                                    class="mb-0 fw-semibold {{ $isOccupied ? 'text-danger' : 'text-success' }}">
                                                    {{ $isOccupied ? 'Tidak Tersedia' : 'Siap Dihuni' }}
                                                </p>
                                            </div>
                                            <div>
                                                <i
                                                    class="{{ $isOccupied ? 'ri-lock-line text-danger' : 'ri-check-line text-success' }} fs-24"></i>
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        @if (!$isOccupied)
                                            <a href="https://wa.me/6281315793349?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($room->name) }}"
                                                target="_blank"
                                                class="btn btn-success w-100 btn-label waves-effect waves-light">
                                                <i class="ri-whatsapp-line label-icon align-middle fs-16 me-2"></i>
                                                Hubungi Kami
                                            </a>
                                        @else
                                            <button class="btn btn-light w-100 disabled text-muted" disabled>
                                                <i class="ri-information-line me-2"></i>
                                                Tidak Tersedia
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- start faqs -->
            <section class="section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h3 class="mb-3 fw-semibold">Pertanyaan yang Sering Diajukan</h3>
                                <p class="text-muted mb-4 ff-secondary">
                                    Berikut beberapa pertanyaan umum tentang kos kami. Jika masih ada yang ingin ditanyakan,
                                    silakan hubungi kami langsung.
                                </p>
                                <div>
                                    <a href="https://wa.me/6281315793349" target="_blank"
                                        class="btn btn-success btn-label rounded-pill">
                                        <i class="ri-whatsapp-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                        Hubungi via WhatsApp
                                    </a>
                                    <a href="mailto:fikri225456@gmail.com.com"
                                        class="btn btn-primary btn-label rounded-pill">
                                        <i class="ri-mail-line label-icon align-middle rounded-pill fs-16 me-2"></i> Kirim
                                        Email
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
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne">
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
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                            Apakah bisa melihat langsung lokasi kos?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse show"
                                        data-bs-parent="#faq-kos">
                                        <div class="accordion-body">
                                            Tentu! Silakan kunjungi kami langsung. Alamat lengkap bisa Anda lihat di bagian
                                            "Kontak" di bawah halaman ini.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                            Fasilitas apa saja yang tersedia?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-kos">
                                        <div class="accordion-body">
                                            Kami menyediakan kamar mandi dalam, Kasur Lantai, Rak Baju, tempat parkir motor.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqFour">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                            Bagaimana cara memesan kamar?
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faq-kos">
                                        <div class="accordion-body">
                                            Anda bisa memesan atau menanyakan ketersediaan kamar langsung melalui WhatsApp
                                            atau datang langsung ke lokasi.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqFive">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                            Berapa ukuran kamar di kos ini?
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faq-kos">
                                        <div class="accordion-body">
                                            Setiap kamar berukuran 3,5 meter x 5 meter, cukup luas dan nyaman untuk
                                            ditinggali sendiri maupun berdua.
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
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsek1">
                                            Apakah ada batasan untuk tamu?
                                        </button>
                                    </h2>
                                    <div id="collapsek1" class="accordion-collapse collapse show"
                                        data-bs-parent="#faq-others">
                                        <div class="accordion-body">
                                            Demi kenyamanan bersama, tamu lawan jenis tidak diperbolehkan menginap. Tamu
                                            hanya diperbolehkan berkunjung sampai pukul 21.00 WIB.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqk2">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsek2">
                                            Apakah ada pembayaran online?
                                        </button>
                                    </h2>
                                    <div id="collapsek2" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-others">
                                        <div class="accordion-body">
                                            Untuk saat ini, pembayaran bisa dilakukan via transfer bank atau QRIS. Informasi
                                            nomor rekening akan diberikan setelah konfirmasi.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqk3">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsek3">
                                            Apakah air tersedia 24 jam?
                                        </button>
                                    </h2>
                                    <div id="collapsek3" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-others">
                                        <div class="accordion-body">
                                            Ya, air di kos kami dijamin tidak akan mati dan tersedia 24 jam penuh setiap
                                            hari.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqk4">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsek4">
                                            Berapa minimal waktu sewa?
                                        </button>
                                    </h2>
                                    <div id="collapsek4" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-others">
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
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
        <!-- end layout wrapper -->



        <style>
            .room-card {
                transition: all 0.3s ease;
            }

            .room-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            }

            .room-img {
                height: 220px;
                object-fit: cover;
                transition: transform 0.4s ease;
            }

            .room-card:hover .room-img {
                transform: scale(1.08);
            }
        </style>

    </div>
@endsection
