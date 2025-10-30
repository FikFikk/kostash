@extends('dashboard.admin.layouts.app')

@section('title', 'Global Settings')

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
            --setting-bg: #f8fafc;
            --setting-hover: #f1f5f9;
            --setting-border: #e2e8f0;
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
            --setting-bg: #2a2f34;
            --setting-hover: #343a40;
            --setting-border: #495057;
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

        .setting-item {
            padding: 1.25rem;
            border-radius: 0.75rem;
            background: var(--setting-bg);
            border: 1px solid var(--setting-border);
            transition: all 0.3s ease;
        }

        .setting-item:hover {
            background: var(--setting-hover);
            border-color: var(--border-color);
        }

        .setting-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .setting-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .setting-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .icon-primary {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .icon-success {
            background: rgba(67, 233, 123, 0.1);
            color: #43e97b;
        }

        .icon-warning {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .icon-info {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .icon-purple {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .icon-pink {
            background: rgba(236, 72, 153, 0.1);
            color: #ec4899;
        }

        /* Dark mode icon adjustments */
        [data-bs-theme="dark"] .icon-primary {
            background: rgba(102, 126, 234, 0.2);
        }

        [data-bs-theme="dark"] .icon-success {
            background: rgba(67, 233, 123, 0.2);
        }

        [data-bs-theme="dark"] .icon-warning {
            background: rgba(251, 191, 36, 0.2);
        }

        [data-bs-theme="dark"] .icon-info {
            background: rgba(59, 130, 246, 0.2);
        }

        [data-bs-theme="dark"] .icon-purple {
            background: rgba(139, 92, 246, 0.2);
        }

        [data-bs-theme="dark"] .icon-pink {
            background: rgba(236, 72, 153, 0.2);
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
                        <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-settings-3-line me-2"></i>Global Settings
                        </h1>
                        <p class="text-muted mb-0" style="color: var(--text-muted) !important;">Manage your kost system
                            configuration and preferences.</p>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-lg-0">
                        <a href="{{ route('dashboard.global.edit') }}" class="btn btn-primary"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);">
                            <i class="ri-edit-line me-1"></i>Edit Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Tabs -->
        <div class="card content-card">
            <div class="card-body p-0">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs nav-tabs-modern p-3 mb-0" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing"
                            type="button" role="tab">
                            <i class="ri-money-dollar-circle-line me-2"></i><span class="tab-text">Pricing & Bills</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment"
                            type="button" role="tab">
                            <i class="ri-bank-card-line me-2"></i><span class="tab-text">Payment Gateway</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="oauth-tab" data-bs-toggle="tab" data-bs-target="#oauth" type="button"
                            role="tab">
                            <i class="ri-shield-user-line me-2"></i><span class="tab-text">OAuth & Social</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button"
                            role="tab">
                            <i class="ri-mail-line me-2"></i><span class="tab-text">Email & SMTP</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button"
                            role="tab">
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
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-primary">
                                        <i class="ri-home-8-line"></i>
                                    </div>
                                    <div class="setting-label">Monthly Room Price</div>
                                    <div class="setting-value">Rp {{ number_format($global->monthly_room_price ?? 0) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-info">
                                        <i class="ri-water-flash-line"></i>
                                    </div>
                                    <div class="setting-label">Water Price per Cubic</div>
                                    <div class="setting-value">Rp {{ number_format($global->water_price ?? 0) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-warning">
                                        <i class="ri-flashlight-line"></i>
                                    </div>
                                    <div class="setting-label">Electric Price per KwH</div>
                                    <div class="setting-value">Rp {{ number_format($global->electric_price ?? 0) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-success">
                                        <i class="ri-safe-line"></i>
                                    </div>
                                    <div class="setting-label">Deposit Amount</div>
                                    <div class="setting-value">
                                        {{ $global->deposit_amount ? 'Rp ' . number_format($global->deposit_amount) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-warning">
                                        <i class="ri-alarm-warning-line"></i>
                                    </div>
                                    <div class="setting-label">Late Fee Percentage</div>
                                    <div class="setting-value">{{ $global->late_fee_percentage ?? 0 }}%</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-purple">
                                        <i class="ri-file-list-2-line"></i>
                                    </div>
                                    <div class="setting-label">Admin Fee</div>
                                    <div class="setting-value">
                                        {{ $global->admin_fee ? 'Rp ' . number_format($global->admin_fee) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Gateway Tab -->
                    <div class="tab-pane fade" id="payment" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-primary">
                                        <i class="ri-key-line"></i>
                                    </div>
                                    <div class="setting-label">Mayar API Key</div>
                                    <div class="setting-value">
                                        {{ $global->mayar_api_key ? '••••••••••••' . substr($global->mayar_api_key, -6) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-warning">
                                        <i class="ri-shield-keyhole-line"></i>
                                    </div>
                                    <div class="setting-label">Webhook Token</div>
                                    <div class="setting-value">
                                        {{ $global->mayar_webhook_token ? '••••••••••••' . substr($global->mayar_webhook_token, -6) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-success">
                                        <i class="ri-shield-check-line"></i>
                                    </div>
                                    <div class="setting-label">Environment</div>
                                    <div class="setting-value">{{ $global->mayar_sandbox ? 'Sandbox' : 'Production' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-purple">
                                        <i class="ri-bank-card-line"></i>
                                    </div>
                                    <div class="setting-label">Payment Type</div>
                                    <div class="setting-value">
                                        {{ $global->payment_type ? ucfirst($global->payment_type) : 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-info">
                                        <i class="ri-external-link-line"></i>
                                    </div>
                                    <div class="setting-label">Redirect URL</div>
                                    <div class="setting-value">
                                        {{ $global->mayar_redirect_url ? \Illuminate\Support\Str::limit($global->mayar_redirect_url, 30) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-success">
                                        <i class="ri-webhook-line"></i>
                                    </div>
                                    <div class="setting-label">Webhook URL</div>
                                    <div class="setting-value">
                                        <code class="small">{{ url('/mayar/webhook') }}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OAuth & Social Tab -->
                    <div class="tab-pane fade" id="oauth" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-primary">
                                        <i class="ri-google-line"></i>
                                    </div>
                                    <div class="setting-label">Google OAuth</div>
                                    <div class="setting-value">{{ $global->google_client_id ? 'Configured' : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-info">
                                        <i class="ri-facebook-line"></i>
                                    </div>
                                    <div class="setting-label">Facebook OAuth</div>
                                    <div class="setting-value">
                                        {{ $global->facebook_client_id ? 'Configured' : 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-success">
                                        <i class="ri-twitter-line"></i>
                                    </div>
                                    <div class="setting-label">Twitter OAuth</div>
                                    <div class="setting-value">{{ $global->twitter_client_id ? 'Configured' : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email & SMTP Tab -->
                    <div class="tab-pane fade" id="email" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-primary">
                                        <i class="ri-server-line"></i>
                                    </div>
                                    <div class="setting-label">SMTP Host</div>
                                    <div class="setting-value">{{ $global->email_host ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-info">
                                        <i class="ri-plug-line"></i>
                                    </div>
                                    <div class="setting-label">SMTP Port</div>
                                    <div class="setting-value">{{ $global->email_port ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-success">
                                        <i class="ri-shield-check-line"></i>
                                    </div>
                                    <div class="setting-label">Encryption</div>
                                    <div class="setting-value">
                                        {{ $global->email_encryption ? strtoupper($global->email_encryption) : 'None' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-warning">
                                        <i class="ri-mail-line"></i>
                                    </div>
                                    <div class="setting-label">From Address</div>
                                    <div class="setting-value">{{ $global->email_from_address ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-purple">
                                        <i class="ri-user-line"></i>
                                    </div>
                                    <div class="setting-label">From Name</div>
                                    <div class="setting-value">{{ $global->email_from_name ?? 'Not Set' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings Tab -->
                    <div class="tab-pane fade" id="seo" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-primary">
                                        <i class="ri-text"></i>
                                    </div>
                                    <div class="setting-label">Site Title</div>
                                    <div class="setting-value">{{ $global->site_title ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon icon-info">
                                        <i class="ri-search-line"></i>
                                    </div>
                                    <div class="setting-label">Meta Robots</div>
                                    <div class="setting-value">{{ $global->meta_robots ?? 'index,follow' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="setting-item">
                                    <div class="setting-icon icon-success">
                                        <i class="ri-file-text-line"></i>
                                    </div>
                                    <div class="setting-label">Site Description</div>
                                    <div class="setting-value">
                                        {{ $global->site_description ? \Illuminate\Support\Str::limit($global->site_description, 100) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="setting-item">
                                    <div class="setting-icon icon-warning">
                                        <i class="ri-key-line"></i>
                                    </div>
                                    <div class="setting-label">Keywords</div>
                                    <div class="setting-value">
                                        {{ $global->site_keywords ? \Illuminate\Support\Str::limit($global->site_keywords, 100) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- General Info Tab -->
                    <div class="tab-pane fade" id="general" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-primary">
                                        <i class="ri-building-line"></i>
                                    </div>
                                    <div class="setting-label">App Name</div>
                                    <div class="setting-value">{{ $global->app_name ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-info">
                                        <i class="ri-phone-line"></i>
                                    </div>
                                    <div class="setting-label">Kost Phone</div>
                                    <div class="setting-value">{{ $global->kost_phone ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="setting-item">
                                    <div class="setting-icon icon-success">
                                        <i class="ri-mail-line"></i>
                                    </div>
                                    <div class="setting-label">Kost Email</div>
                                    <div class="setting-value">{{ $global->kost_email ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="setting-item">
                                    <div class="setting-icon icon-warning">
                                        <i class="ri-map-pin-line"></i>
                                    </div>
                                    <div class="setting-label">Kost Address</div>
                                    <div class="setting-value">{{ $global->kost_address ?? 'Not Set' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="setting-item">
                                    <div class="setting-icon icon-purple">
                                        <i class="ri-file-text-line"></i>
                                    </div>
                                    <div class="setting-label">Description</div>
                                    <div class="setting-value">
                                        {{ $global->description ? \Illuminate\Support\Str::limit($global->description, 150) : 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
