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

    <!-- Advanced Floating Chat Widget with Smart Auto Reply -->
    <style>
        .floating-chat {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: .5rem;
            align-items: flex-end
        }

        .floating-chat .chat-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            cursor: pointer;
            border: 3px solid #fff;
            transition: all 0.3s;
            position: relative;
        }

        .floating-chat .chat-button:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
        }

        .floating-chat .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }
        }

        .floating-chat .chat-panel {
            width: 380px;
            max-width: calc(100vw - 40px);
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: none;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating-chat .chat-panel.open {
            display: block
        }

        .floating-chat .chat-header {
            padding: 18px 16px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .floating-chat .chat-avatar {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
            font-size: 22px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .floating-chat .chat-header-info {
            flex: 1;
        }

        .floating-chat .chat-header-info strong {
            display: block;
            font-size: 16px;
            font-weight: 700;
        }

        .floating-chat .chat-header-info .status {
            font-size: 12px;
            opacity: 0.95;
            margin-top: 2px;
        }

        .floating-chat .online-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            margin-right: 5px;
            animation: blink 2s infinite;
            box-shadow: 0 0 5px rgba(34, 197, 94, 0.8);
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        .floating-chat .chat-body {
            padding: 16px;
            max-height: 400px;
            overflow-y: auto;
            background: #f8faf9;
        }

        .floating-chat .chat-body::-webkit-scrollbar {
            width: 6px;
        }

        .floating-chat .chat-body::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 10px;
        }

        .floating-chat .chat-message {
            margin-bottom: 12px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating-chat .chat-message.bot {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .floating-chat .chat-message.bot .avatar {
            width: 30px;
            height: 30px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            flex-shrink: 0;
        }

        .floating-chat .chat-message.bot .message-bubble {
            background: white;
            padding: 10px 14px;
            border-radius: 12px 12px 12px 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 75%;
            line-height: 1.5;
        }

        .floating-chat .chat-message.user {
            display: flex;
            justify-content: flex-end;
        }

        .floating-chat .chat-message.user .message-bubble {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 10px 14px;
            border-radius: 12px 12px 4px 12px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
            max-width: 75%;
            line-height: 1.5;
        }

        .floating-chat .message-time {
            font-size: 10px;
            opacity: 0.6;
            margin-top: 4px;
            margin-left: 38px;
        }

        .floating-chat .user .message-time {
            text-align: right;
            margin-left: 0;
            margin-right: 8px;
        }

        .floating-chat .typing-indicator {
            display: none;
            padding: 10px 14px;
            background: white;
            border-radius: 12px;
            width: fit-content;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .floating-chat .typing-indicator.active {
            display: flex;
            gap: 4px;
            align-items: center;
            margin-left: 38px;
        }

        .floating-chat .typing-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: bounce 1.4s infinite;
        }

        .floating-chat .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .floating-chat .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-8px);
            }
        }

        .floating-chat .quick-replies {
            padding: 12px;
            display: flex;
            gap: 8px;
            overflow-x: auto;
            background: white;
            border-top: 1px solid #e5e7eb;
            scrollbar-width: thin;
        }

        .floating-chat .quick-replies::-webkit-scrollbar {
            height: 4px;
        }

        .floating-chat .quick-replies::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 10px;
        }

        .floating-chat .quick-reply-btn {
            padding: 8px 14px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
            color: #166534;
            font-weight: 500;
        }

        .floating-chat .quick-reply-btn:hover {
            background: #10b981;
            color: white;
            border-color: #10b981;
            transform: translateY(-2px);
        }

        .floating-chat .chat-footer {
            padding: 14px;
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 10px;
            background: white;
        }

        .floating-chat .chat-footer input {
            flex: 1;
            padding: 10px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 25px;
            outline: none;
            font-size: 14px;
            transition: all 0.2s;
        }

        .floating-chat .chat-footer input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .floating-chat .chat-footer button {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .floating-chat .chat-footer button:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .floating-chat .chat-footer button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .floating-chat .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 8px;
        }

        .floating-chat .action-btn {
            padding: 10px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            justify-content: center;
        }

        .floating-chat .btn-whatsapp {
            background: #25D366;
            color: white;
        }

        .floating-chat .btn-whatsapp:hover {
            background: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        }

        .floating-chat .btn-location {
            background: #3b82f6;
            color: white;
        }

        .floating-chat .btn-location:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        @media (max-width:480px) {
            .floating-chat .chat-panel {
                width: calc(100vw - 40px);
                max-height: calc(100vh - 140px);
            }

            .floating-chat .chat-body {
                max-height: calc(100vh - 340px);
            }
        }
    </style>

    <div class="floating-chat" id="floatingChat">
        <div class="chat-panel" id="chatPanel" aria-hidden="true">
            <div class="chat-header">
                <div class="chat-avatar">
                    <i class="ri-customer-service-2-line"></i>
                </div>
                <div class="chat-header-info">
                    <strong>Kos Bu Aspiyah Support</strong>
                    <div class="status">
                        <span class="online-dot"></span>
                        Online - Siap Membantu
                    </div>
                </div>
                <button class="btn btn-sm btn-light" id="chatCloseBtn" aria-label="Tutup"
                    style="width: 32px; height: 32px; padding: 0; border-radius: 50%;">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div class="chat-body" id="chatBody">
                <div class="chat-message bot">
                    <div class="avatar">
                        <i class="ri-robot-line"></i>
                    </div>
                    <div class="message-bubble">
                        Halo! 👋 Selamat datang di <strong>Kos Bu Aspiyah</strong>.<br>
                        Ada yang bisa kami bantu hari ini?
                    </div>
                </div>
                <div class="message-time">Baru saja</div>

                <div class="typing-indicator" id="typingIndicator">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            </div>

            <div class="quick-replies">
                <button class="quick-reply-btn" onclick="sendQuickReply('Cari kost')">🏠 Cari Kost</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Info harga')">💰 Harga</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Lokasi kost')">📍 Lokasi</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Fasilitas')">⭐ Fasilitas</button>
            </div>

            <div class="chat-footer">
                <input type="text" id="chatInput" placeholder="Ketik pesan Anda..." autocomplete="off">
                <button id="chatSendBtn" title="Kirim">
                    <i class="ri-send-plane-2-fill"></i>
                </button>
            </div>
        </div>

        <button class="chat-button" id="chatToggleBtn" title="Chat dengan Kos Bu Aspiyah">
            <i class="ri-message-3-line fs-20"></i>
            <span class="notification-badge">1</span>
        </button>
    </div>

    <script>
        (function() {
            const chatToggle = document.getElementById('chatToggleBtn');
            const chatPanel = document.getElementById('chatPanel');
            const chatClose = document.getElementById('chatCloseBtn');
            const chatSend = document.getElementById('chatSendBtn');
            const chatInput = document.getElementById('chatInput');
            const chatBody = document.getElementById('chatBody');
            const typingIndicator = document.getElementById('typingIndicator');
            const notificationBadge = chatToggle.querySelector('.notification-badge');

            const WA_NUMBER = '6281315793349';
            const CHAT_WEBHOOK_URL = {!! json_encode($global->n8n_webhook_url ?? '') !!};
            const GOOGLE_MAPS_URL = 'https://maps.google.com/?q=Menganti+Gresik+Jawa+Timur';

            // Knowledge base for auto-reply
            const knowledgeBase = {
                'harga|biaya|sewa|bayar|tarif': {
                    response: `💰 <strong>Info Harga Kos Bu Aspiyah:</strong><br><br>
                    • Sewa per bulan: Rp 400.000<br>
                    • Minimal sewa: 1 bulan<br>
                    • Pembayaran: Transfer bank atau Cash<br><br>`,
                    showActions: true
                },
                'lokasi|alamat|dimana|tempat|posisi': {
                    response: `📍 <strong>Lokasi Kos Bu Aspiyah:</strong><br><br>
                    Jl . Pahlawan Darkun Menganti Gresik JawaTimur RT02 RW01 61174<br><br>
                    📌 Dekat dengan:<br>
                    • Sekolah Sunan Giri (SMP, SMK, SMA)<br>
                    • Al-Azhar (PAUD, SD, SMP, SMK, SMA, Kampus)<br>
                    • Pasar Menganti<br>
                    • Berbagai UMKM (warung makan, laundry, toko kelontong)<br>
                    • Akses transportasi mudah<br><br>
                    <a href="#lokasi" style="color: #10b981; text-decoration: underline;">👆 Lihat di Google Maps</a><br><br>
                    Ada peta interaktif di halaman ini!`,
                    showActions: true
                },
                'fasilitas|lengkap|ada apa|tersedia': {
                    response: `⭐ <strong>Fasilitas Kos Bu Aspiyah:</strong><br><br>
                    ✅ Kamar Mandi Dalam<br>
                    ✅ Kasur Lantai<br>
                    ✅ Rak Baju<br>
                    ✅ Tempat Parkir Motor<br>
                    ✅ Air 24 Jam<br>
                    ✅ Lingkungan Aman & Nyaman`,
                    showActions: false
                },
                'kamar|tipe|jenis|pilihan|tersedia|jumlah': {
                    response: `🏠 <strong>Info Kamar Kos Bu Aspiyah:</strong><br><br>
                    • Total kamar: 6 kamar<br>
                    • Ukuran kamar: 3,5 meter x 5 meter<br>
                    • Cocok untuk: 1-2 orang<br><br>
                    <a href="#room" style="color: #10b981; text-decoration: underline;">👆 Lihat Detail & Status Kamar</a><br><br>
                    Cek status ketersediaan kamar di halaman ini!`,
                    showActions: true
                },
                'status|kosong|available|tersedia|cek kamar': {
                    response: `🔍 <strong>Cek Status Kamar Kos Bu Aspiyah:</strong><br><br>
                    Lihat status real-time kamar di bagian "Kamar":<br>
                    <span class="badge bg-success">Available</span> = Kamar kosong, siap disewa<br>
                    <span class="badge bg-danger">Terisi</span> = Kamar sudah ada penghuni<br><br>
                    <a href="#room" style="color: #10b981; text-decoration: underline;">👆 Cek Status Kamar Sekarang</a><br><br>
                    Klik link di atas untuk lihat kamar yang tersedia!`,
                    showActions: true
                },
                'booking|pesan|reservasi|sewa|cara pesan': {
                    response: `📝 <strong>Cara Booking Kos Bu Aspiyah:</strong><br><br>
                    1. <strong>Cek ketersediaan kamar</strong> di bagian "Kamar" di halaman ini<br>
                    2. Lihat status: <span class="badge bg-success">Available</span> = tersedia<br>
                    3. Hubungi admin via WhatsApp untuk booking<br>
                    4. Konfirmasi & transfer DP<br><br>
                    <a href="#room" style="color: #10b981; text-decoration: underline;">👆 Lihat Kamar Tersedia</a><br><br>
                    Yuk cek dulu kamar yang available! 😊`,
                    showActions: true
                },
                'syarat|ketentuan|aturan|peraturan|tamu|pengunjung': {
                    response: `📋 <strong>Syarat & Ketentuan Kos Bu Aspiyah:</strong><br><br>
                    • Minimal sewa: 1 bulan<br>
                    • Tamu lawan jenis: Tidak diperbolehkan menginap<br>
                    • Kunjungan tamu: Maksimal pukul 21.00 WIB<br>
                    • Pembayaran: Transfer bank atau QRIS<br><br>
                    Ada pertanyaan lain?`,
                    showActions: true
                },
                'kontak|hubungi|admin|telpon|whatsapp|wa|email': {
                    response: `📱 <strong>Kontak Kos Bu Aspiyah:</strong><br><br>
                    WhatsApp: 081315793349<br>
                    Email: fikri225456@gmail.com<br><br>
                    Jam operasional: 08:00 - 21:00 WIB`,
                    showActions: true
                },
                'terima kasih|thanks|makasih': {
                    response: `Sama-sama! 😊 Senang bisa membantu.<br>Jika ada pertanyaan lagi, jangan ragu untuk chat ya!`,
                    showActions: false
                },
                'hai|halo|hello|hi|pagi|siang|sore|malam': {
                    response: `Halo! 👋 Selamat datang di Kos Bu Aspiyah!<br>Ada yang bisa kami bantu hari ini? 😊`,
                    showActions: false
                }
            };

            function openPanel() {
                chatPanel.classList.add('open');
                chatPanel.setAttribute('aria-hidden', 'false');
                notificationBadge.style.display = 'none';
                chatInput.focus();
            }

            function closePanel() {
                chatPanel.classList.remove('open');
                chatPanel.setAttribute('aria-hidden', 'true');
            }

            function getTimeString() {
                return new Date().toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function appendMessage(text, sender, showActions = false) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${sender}`;

                const time = getTimeString();

                if (sender === 'bot') {
                    messageDiv.innerHTML = `
                    <div class="avatar">
                        <i class="ri-robot-line"></i>
                    </div>
                    <div class="message-bubble">${text}</div>
                `;

                    const timeDiv = document.createElement('div');
                    timeDiv.className = 'message-time';
                    timeDiv.textContent = time;

                    chatBody.insertBefore(messageDiv, typingIndicator);
                    chatBody.insertBefore(timeDiv, typingIndicator);

                    if (showActions) {
                        const actionsDiv = document.createElement('div');
                        actionsDiv.className = 'action-buttons';
                        actionsDiv.style.marginLeft = '38px';
                        actionsDiv.innerHTML = `
                        <a href="https://wa.me/${WA_NUMBER}?text=Halo%20KostASH,%20saya%20mau%20tanya%20lebih%20lanjut" 
                           target="_blank" 
                           class="action-btn btn-whatsapp">
                            <i class="ri-whatsapp-line"></i>
                            Chat via WhatsApp
                        </a>
                        <a href="${GOOGLE_MAPS_URL}" 
                           target="_blank" 
                           class="action-btn btn-location">
                            <i class="ri-map-pin-line"></i>
                            Lihat Lokasi di Maps
                        </a>
                    `;
                        chatBody.insertBefore(actionsDiv, typingIndicator);
                    }
                } else {
                    messageDiv.innerHTML = `
                    <div class="message-bubble">${text}</div>
                `;
                    const timeDiv = document.createElement('div');
                    timeDiv.className = 'message-time user';
                    timeDiv.textContent = time;

                    chatBody.insertBefore(messageDiv, typingIndicator);
                    chatBody.insertBefore(timeDiv, typingIndicator);
                }

                chatBody.scrollTop = chatBody.scrollHeight;
            }

            function findAnswer(message) {
                const lowerMessage = message.toLowerCase();

                for (const [pattern, data] of Object.entries(knowledgeBase)) {
                    const regex = new RegExp(pattern, 'i');
                    if (regex.test(lowerMessage)) {
                        return data;
                    }
                }

                return null;
            }

            function showTypingIndicator() {
                typingIndicator.classList.add('active');
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            function hideTypingIndicator() {
                typingIndicator.classList.remove('active');
            }

            async function processMessage(text) {
                const page = window.location.href;

                // Try to find answer in knowledge base
                const answer = findAnswer(text);

                showTypingIndicator();

                // Simulate thinking delay
                await new Promise(resolve => setTimeout(resolve, 1000));

                hideTypingIndicator();

                if (answer) {
                    // Found answer in knowledge base
                    appendMessage(answer.response, 'bot', answer.showActions);
                } else {
                    // No answer found - send to webhook if available or show default
                    if (CHAT_WEBHOOK_URL) {
                        try {
                            const response = await fetch(CHAT_WEBHOOK_URL, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    message: text,
                                    page: page,
                                    timestamp: new Date().toISOString()
                                })
                            });

                            const data = await response.json();
                            const botReply = data.reply || data.message || getDefaultResponse();
                            appendMessage(botReply, 'bot', true);
                        } catch (error) {
                            console.error('Webhook error:', error);
                            appendMessage(getDefaultResponse(), 'bot', true);
                        }
                    } else {
                        appendMessage(getDefaultResponse(), 'bot', true);
                    }
                }
            }

            function getDefaultResponse() {
                return `Terima kasih atas pertanyaannya! 🙏<br><br>
                    Untuk informasi lebih detail, silakan:<br>
                    • Chat langsung via WhatsApp, atau<br>
                    • Kunjungi lokasi kami<br><br>
                    Admin kami siap membantu Anda! 😊`;
            }

            async function sendMessage() {
                const text = (chatInput.value || '').trim();
                if (!text) return;

                appendMessage(text, 'user');
                chatInput.value = '';
                chatSend.disabled = true;

                await processMessage(text);

                chatSend.disabled = false;
                chatInput.focus();
            }

            window.sendQuickReply = async function(text) {
                appendMessage(text, 'user');
                await processMessage(text);
            };

            chatToggle.addEventListener('click', function() {
                if (chatPanel.classList.contains('open')) {
                    closePanel();
                } else {
                    openPanel();
                }
            });

            chatClose.addEventListener('click', closePanel);
            chatSend.addEventListener('click', sendMessage);

            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    sendMessage();
                }
            });

            chatBody.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' && e.target.getAttribute('href').startsWith('#')) {
                    closePanel();
                }
            });

            // Show notification after 3 seconds
            setTimeout(() => {
                notificationBadge.style.display = 'flex';
            }, 3000);
        })();
    </script>

    @stack('scripts')
</body>

</html>
