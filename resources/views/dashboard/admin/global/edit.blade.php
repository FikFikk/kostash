@extends('dashboard.admin.layouts.app')

@section('title', 'Edit Global Settings')

@push('styles')
    {{-- Custom styles to match the modern dashboard UI --}}
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-info: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.12);

            /* Light mode colors */
            --bg-card: #ffffff;
            --bg-secondary: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --nav-bg: #f1f5f9;
            --nav-hover: #e2e8f0;
            --form-border: #d1d5db;
            --form-focus: #667eea;
            --form-bg: #ffffff;
        }

        /* Dark mode variables */
        [data-bs-theme="dark"] {
            --bg-card: #1a1d20;
            --bg-secondary: #2a2f34;
            --text-primary: #e9ecef;
            --text-secondary: #adb5bd;
            --text-muted: #6c757d;
            --border-color: #495057;
            --nav-bg: #2a2f34;
            --nav-hover: #343a40;
            --form-border: #495057;
            --form-focus: #667eea;
            --form-bg: #2a2f34;
            --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .content-card {
            border: none;
            border-radius: 1rem;
            box-shadow: var(--shadow-elegant);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: var(--bg-card);
        }

        .content-card:hover {
            box-shadow: var(--shadow-hover);
        }

        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-tabs-modern {
            border: none;
            gap: 0.5rem;
        }

        .nav-tabs-modern .nav-link {
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--text-secondary);
            background: var(--nav-bg);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-tabs-modern .nav-link:hover {
            background: var(--nav-hover);
            color: var(--text-primary);
        }

        .nav-tabs-modern .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        /* Mobile responsive tabs */
        @media (max-width: 768px) {
            .nav-tabs-modern .nav-link {
                padding: 0.75rem;
                min-width: 50px;
                text-align: center;
            }

            .nav-tabs-modern .nav-link .tab-text {
                display: none;
            }

            .nav-tabs-modern .nav-link i {
                font-size: 1.2rem;
            }
        }

        @media (min-width: 769px) {
            .nav-tabs-modern .nav-link .tab-text {
                display: inline;
            }
        }

        .form-group-modern {
            margin-bottom: 1.5rem;
        }

        .form-label-modern {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-control-modern {
            border: 1px solid var(--form-border);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            background: var(--form-bg);
            color: var(--text-primary);
        }

        .form-control-modern:focus {
            border-color: var(--form-focus);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-group-icon {
            position: relative;
        }

        .input-group-icon .form-control {
            padding-left: 2.75rem;
        }

        .input-group-icon .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-edit-line me-2"></i>Edit Global Settings</h1>
                        <p class="text-muted mb-0" style="color: var(--text-muted) !important;">Configure your kost system
                            settings and preferences.</p>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-lg-0">
                        <a href="{{ route('dashboard.global.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line me-1"></i>Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <form action="{{ route('dashboard.global.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card content-card">
                <div class="card-body p-0">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs nav-tabs-modern p-3 mb-0" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing"
                                type="button" role="tab">
                                <i class="ri-money-dollar-circle-line me-2"></i><span class="tab-text">Pricing &
                                    Bills</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment"
                                type="button" role="tab">
                                <i class="ri-bank-card-line me-2"></i><span class="tab-text">Payment Gateway</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="oauth-tab" data-bs-toggle="tab" data-bs-target="#oauth"
                                type="button" role="tab">
                                <i class="ri-shield-user-line me-2"></i><span class="tab-text">OAuth & Social</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email"
                                type="button" role="tab">
                                <i class="ri-mail-line me-2"></i><span class="tab-text">Email & SMTP</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                type="button" role="tab">
                                <i class="ri-search-line me-2"></i><span class="tab-text">SEO Settings</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                                type="button" role="tab">
                                <i class="ri-information-line me-2"></i><span class="tab-text">General Info</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content p-4" id="settingsTabContent"
                        style="background: var(--bg-card); color: var(--text-primary);">
                        <!-- Pricing & Bills Tab -->
                        <div class="tab-pane fade show active" id="pricing" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-home-8-line me-2 text-primary"></i>Monthly Room Price (Rp)
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-money-dollar-circle-line"></i>
                                            <input type="number" name="monthly_room_price"
                                                class="form-control form-control-modern"
                                                value="{{ old('monthly_room_price', $global->monthly_room_price) }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-water-flash-line me-2 text-info"></i>Water Price per Cubic (Rp)
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-money-dollar-circle-line"></i>
                                            <input type="number" name="water_price"
                                                class="form-control form-control-modern"
                                                value="{{ old('water_price', $global->water_price) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-flashlight-line me-2 text-warning"></i>Electric Price per KwH (Rp)
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-money-dollar-circle-line"></i>
                                            <input type="number" name="electric_price"
                                                class="form-control form-control-modern"
                                                value="{{ old('electric_price', $global->electric_price) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-safe-line me-2 text-success"></i>Deposit Amount (Rp)
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-money-dollar-circle-line"></i>
                                            <input type="number" name="deposit_amount"
                                                class="form-control form-control-modern"
                                                value="{{ old('deposit_amount', $global->deposit_amount) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-alarm-warning-line me-2 text-warning"></i>Late Fee Percentage (%)
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-percent-line"></i>
                                            <input type="number" step="0.01" name="late_fee_percentage"
                                                class="form-control form-control-modern"
                                                value="{{ old('late_fee_percentage', $global->late_fee_percentage) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-file-list-2-line me-2 text-purple"></i>Admin Fee (Rp)
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-money-dollar-circle-line"></i>
                                            <input type="number" name="admin_fee"
                                                class="form-control form-control-modern"
                                                value="{{ old('admin_fee', $global->admin_fee) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Gateway Tab -->
                        <div class="tab-pane fade" id="payment" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-key-line me-2 text-primary"></i>Mayar API Key
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-key-line"></i>
                                            <textarea name="mayar_api_key" rows="3" class="form-control form-control-modern"
                                                placeholder="Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9...">{{ old('mayar_api_key', $global->mayar_api_key) }}</textarea>
                                        </div>
                                        <div class="form-text text-muted">
                                            <small><i class="ri-information-line me-1"></i>API Key dari Mayar dashboard
                                                (format: Bearer token)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-shield-keyhole-line me-2 text-warning"></i>Webhook Token
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-shield-keyhole-line"></i>
                                            <input type="text" name="mayar_webhook_token"
                                                class="form-control form-control-modern"
                                                placeholder="2614b16cd03b270989abe8c0fdf5e3be57e34bb37d65f370f9de155cfd013c16b3a338db777e446f41f3f25af86ac0d89dd472f2e365c2531d9e68560338751f"
                                                value="{{ old('mayar_webhook_token', $global->mayar_webhook_token) }}">
                                        </div>
                                        <div class="form-text text-muted">
                                            <small><i class="ri-information-line me-1"></i>Token untuk validasi webhook
                                                dari Mayar</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-external-link-line me-2 text-info"></i>Redirect URL
                                        </label>
                                        <div class="input-group-icon">
                                            <i class="input-icon ri-external-link-line"></i>
                                            <input type="url" name="mayar_redirect_url"
                                                class="form-control form-control-modern"
                                                placeholder="https://yourdomain.com/payment/success"
                                                value="{{ old('mayar_redirect_url', $global->mayar_redirect_url) }}">
                                        </div>
                                        <div class="form-text text-muted">
                                            <small><i class="ri-information-line me-1"></i>URL redirect setelah pembayaran
                                                berhasil</small>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-bank-card-line me-2 text-purple"></i>Payment Type
                                        </label>
                                        <select name="payment_type" class="form-control form-control-modern">
                                            <option value="mayar"
                                                {{ old('payment_type', $global->payment_type) == 'mayar' ? 'selected' : '' }}>
                                                Mayar</option>
                                        </select>
                                        <div class="form-text text-muted">
                                            <small><i class="ri-information-line me-1"></i>Sistem pembayaran menggunakan
                                                Mayar</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-shield-check-line me-2 text-success"></i>Mayar Environment
                                        </label>
                                        <select name="mayar_sandbox" class="form-control form-control-modern">
                                            <option value="1"
                                                {{ old('mayar_sandbox', $global->mayar_sandbox) == '1' ? 'selected' : '' }}>
                                                Sandbox (https://api.mayar.club/hl/v1)</option>
                                            <option value="0"
                                                {{ old('mayar_sandbox', $global->mayar_sandbox) == '0' ? 'selected' : '' }}>
                                                Production (https://api.mayar.id/hl/v1)</option>
                                        </select>
                                        <div class="form-text text-muted">
                                            <small><i class="ri-information-line me-1"></i>Pilih environment Mayar yang
                                                akan digunakan</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Webhook Information -->
                                <div class="col-12">
                                    <hr class="my-4">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="ri-webhook-line me-2"></i>Webhook Information
                                    </h6>
                                    <div class="alert alert-info border-0">
                                        <h6 class="alert-heading"><i class="ri-information-line me-2"></i>Webhook URL
                                            untuk Mayar:</h6>
                                        <p class="mb-2"><strong>URL:</strong> <code>{{ url('/mayar/webhook') }}</code>
                                        </p>
                                        <p class="mb-0"><strong>Method:</strong> <span
                                                class="badge bg-success">POST</span></p>
                                        <hr class="my-2">
                                        <small class="text-muted">
                                            <i class="ri-arrow-right-line me-1"></i>Copy URL ini ke dashboard Mayar Anda
                                            untuk menerima notifikasi pembayaran.<br>
                                            <i class="ri-arrow-right-line me-1"></i>Pastikan webhook token di atas sudah
                                            diatur di dashboard Mayar.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OAuth & Social Tab -->
                        <div class="tab-pane fade" id="oauth" role="tabpanel">
                            <div class="row g-4">
                                <!-- Google OAuth -->
                                <div class="col-12">
                                    <h6 class="fw-bold text-primary mb-3"><i class="ri-google-line me-2"></i>Google OAuth
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Client ID</label>
                                        <input type="text" name="google_client_id"
                                            class="form-control form-control-modern"
                                            value="{{ old('google_client_id', $global->google_client_id) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Client Secret</label>
                                        <input type="text" name="google_client_secret"
                                            class="form-control form-control-modern"
                                            value="{{ old('google_client_secret', $global->google_client_secret) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Redirect URI</label>
                                        <input type="url" name="google_redirect_uri"
                                            class="form-control form-control-modern"
                                            value="{{ old('google_redirect_uri', $global->google_redirect_uri) }}">
                                    </div>
                                </div>

                                <!-- Facebook OAuth -->
                                <div class="col-12">
                                    <h6 class="fw-bold text-info mb-3"><i class="ri-facebook-line me-2"></i>Facebook OAuth
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Client ID</label>
                                        <input type="text" name="facebook_client_id"
                                            class="form-control form-control-modern"
                                            value="{{ old('facebook_client_id', $global->facebook_client_id) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Client Secret</label>
                                        <input type="text" name="facebook_client_secret"
                                            class="form-control form-control-modern"
                                            value="{{ old('facebook_client_secret', $global->facebook_client_secret) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Redirect URI</label>
                                        <input type="url" name="facebook_redirect_uri"
                                            class="form-control form-control-modern"
                                            value="{{ old('facebook_redirect_uri', $global->facebook_redirect_uri) }}">
                                    </div>
                                </div>

                                <!-- Twitter OAuth -->
                                <div class="col-12">
                                    <h6 class="fw-bold text-success mb-3"><i class="ri-twitter-line me-2"></i>Twitter
                                        OAuth</h6>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Client ID</label>
                                        <input type="text" name="twitter_client_id"
                                            class="form-control form-control-modern"
                                            value="{{ old('twitter_client_id', $global->twitter_client_id) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Client Secret</label>
                                        <input type="text" name="twitter_client_secret"
                                            class="form-control form-control-modern"
                                            value="{{ old('twitter_client_secret', $global->twitter_client_secret) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">Redirect URI</label>
                                        <input type="url" name="twitter_redirect_uri"
                                            class="form-control form-control-modern"
                                            value="{{ old('twitter_redirect_uri', $global->twitter_redirect_uri) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email & SMTP Tab -->
                        <div class="tab-pane fade" id="email" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-server-line me-2 text-primary"></i>SMTP Host
                                        </label>
                                        <input type="text" name="email_host" class="form-control form-control-modern"
                                            value="{{ old('email_host', $global->email_host) }}"
                                            placeholder="smtp.gmail.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-plug-line me-2 text-info"></i>SMTP Port
                                        </label>
                                        <input type="number" name="email_port" class="form-control form-control-modern"
                                            value="{{ old('email_port', $global->email_port) }}" placeholder="587">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-user-line me-2 text-success"></i>SMTP Username
                                        </label>
                                        <input type="text" name="email_username"
                                            class="form-control form-control-modern"
                                            value="{{ old('email_username', $global->email_username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-lock-line me-2 text-warning"></i>SMTP Password
                                        </label>
                                        <input type="password" name="email_password"
                                            class="form-control form-control-modern"
                                            value="{{ old('email_password', $global->email_password) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-shield-check-line me-2 text-purple"></i>Encryption
                                        </label>
                                        <select name="email_encryption" class="form-control form-control-modern">
                                            <option value="">None</option>
                                            <option value="ssl"
                                                {{ old('email_encryption', $global->email_encryption) == 'ssl' ? 'selected' : '' }}>
                                                SSL</option>
                                            <option value="tls"
                                                {{ old('email_encryption', $global->email_encryption) == 'tls' ? 'selected' : '' }}>
                                                TLS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-mail-line me-2 text-info"></i>From Address
                                        </label>
                                        <input type="email" name="email_from_address"
                                            class="form-control form-control-modern"
                                            value="{{ old('email_from_address', $global->email_from_address) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-user-3-line me-2 text-success"></i>From Name
                                        </label>
                                        <input type="text" name="email_from_name"
                                            class="form-control form-control-modern"
                                            value="{{ old('email_from_name', $global->email_from_name) }}"
                                            placeholder="Kost Management System">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings Tab -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-text me-2 text-primary"></i>Site Title
                                        </label>
                                        <input type="text" name="site_title" class="form-control form-control-modern"
                                            value="{{ old('site_title', $global->site_title) }}"
                                            placeholder="Kost Management System">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-user-line me-2 text-info"></i>Meta Author
                                        </label>
                                        <input type="text" name="meta_author" class="form-control form-control-modern"
                                            value="{{ old('meta_author', $global->meta_author) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-search-line me-2 text-success"></i>Meta Robots
                                        </label>
                                        <select name="meta_robots" class="form-control form-control-modern">
                                            <option value="index,follow"
                                                {{ old('meta_robots', $global->meta_robots) == 'index,follow' ? 'selected' : '' }}>
                                                Index, Follow</option>
                                            <option value="index,nofollow"
                                                {{ old('meta_robots', $global->meta_robots) == 'index,nofollow' ? 'selected' : '' }}>
                                                Index, No Follow</option>
                                            <option value="noindex,follow"
                                                {{ old('meta_robots', $global->meta_robots) == 'noindex,follow' ? 'selected' : '' }}>
                                                No Index, Follow</option>
                                            <option value="noindex,nofollow"
                                                {{ old('meta_robots', $global->meta_robots) == 'noindex,nofollow' ? 'selected' : '' }}>
                                                No Index, No Follow</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-image-line me-2 text-warning"></i>OG Image URL
                                        </label>
                                        <input type="url" name="og_image" class="form-control form-control-modern"
                                            value="{{ old('og_image', $global->og_image) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-key-line me-2 text-purple"></i>Meta Keywords
                                        </label>
                                        <textarea name="site_keywords" class="form-control form-control-modern" rows="3"
                                            placeholder="kost, boarding house, room rental, student accommodation">{{ old('site_keywords', $global->site_keywords) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-file-text-line me-2 text-info"></i>Site Description
                                        </label>
                                        <textarea name="site_description" class="form-control form-control-modern" rows="3"
                                            placeholder="Professional boarding house management system">{{ old('site_description', $global->site_description) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-facebook-line me-2 text-primary"></i>OG Description
                                        </label>
                                        <textarea name="og_description" class="form-control form-control-modern" rows="2"
                                            placeholder="Description for social media sharing">{{ old('og_description', $global->og_description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- General Info Tab -->
                        <div class="tab-pane fade" id="general" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-building-line me-2 text-primary"></i>Application Name
                                        </label>
                                        <input type="text" name="app_name" class="form-control form-control-modern"
                                            value="{{ old('app_name', $global->app_name) }}"
                                            placeholder="Kost Management">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-time-zone-line me-2 text-info"></i>Timezone
                                        </label>
                                        <select name="timezone" class="form-control form-control-modern">
                                            <option value="Asia/Jakarta"
                                                {{ old('timezone', $global->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>
                                                Asia/Jakarta (WIB)</option>
                                            <option value="Asia/Makassar"
                                                {{ old('timezone', $global->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>
                                                Asia/Makassar (WITA)</option>
                                            <option value="Asia/Jayapura"
                                                {{ old('timezone', $global->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>
                                                Asia/Jayapura (WIT)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-phone-line me-2 text-success"></i>Kost Phone Number
                                        </label>
                                        <input type="text" name="kost_phone" class="form-control form-control-modern"
                                            value="{{ old('kost_phone', $global->kost_phone) }}"
                                            placeholder="+62812345678">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-mail-line me-2 text-warning"></i>Kost Email
                                        </label>
                                        <input type="email" name="kost_email" class="form-control form-control-modern"
                                            value="{{ old('kost_email', $global->kost_email) }}"
                                            placeholder="info@kost.com">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-map-pin-line me-2 text-purple"></i>Kost Address
                                        </label>
                                        <textarea name="kost_address" class="form-control form-control-modern" rows="3"
                                            placeholder="Complete address of the boarding house">{{ old('kost_address', $global->kost_address) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label form-label-modern">
                                            <i class="ri-file-text-line me-2 text-info"></i>Description
                                        </label>
                                        <textarea name="description" class="form-control form-control-modern" rows="4"
                                            placeholder="General description about your boarding house">{{ old('description', $global->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card-footer bg-transparent border-0 d-flex justify-content-end gap-2 p-4">
                    <a href="{{ route('dashboard.global.index') }}" class="btn btn-secondary">
                        <i class="ri-close-line me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-save-line me-1"></i>Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
