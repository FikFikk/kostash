@extends('dashboard.admin.layouts.app')

@section('title', 'Visit Detail')

@push('styles')
    <style>
        /* Modern Design Variables */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-card: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #adb5bd;
            --border-color: #dee2e6;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Dark Mode Variables */
        [data-bs-theme="dark"] {
            --bg-primary: #1a1d20;
            --bg-secondary: #2a2f34;
            --bg-card: #2a2f34;
            --text-primary: #e9ecef;
            --text-secondary: #adb5bd;
            --text-muted: #6c757d;
            --border-color: #495057;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.25);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.4);
        }

        /* Card Styling */
        .detail-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .detail-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border: none;
        }

        .detail-card-body {
            padding: 2rem;
        }

        /* Detail Items */
        .detail-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            color: var(--text-primary);
            font-size: 1rem;
            word-break: break-all;
        }

        .detail-value.code {
            font-family: 'Courier New', monospace;
            background: var(--bg-secondary);
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            white-space: pre-wrap;
            font-size: 0.875rem;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.bot {
            background: #f8d7da;
            color: #721c24;
        }

        .status-badge.suspicious {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.real {
            background: #d4edda;
            color: #155724;
        }

        /* Back Button */
        .btn-back {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-card-body {
                padding: 1rem;
            }

            .detail-value.code {
                font-size: 0.75rem;
                padding: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-eye me-3"></i>
                            Visit Detail
                        </h4>
                    </div>

                    <div class="detail-card-body">
                        <!-- Back Button -->
                        <div class="mb-4">
                            <a href="{{ route('dashboard.visits.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i>
                                Back to Visits
                            </a>
                        </div>

                        <!-- Visit Status -->
                        <div class="mb-4">
                            @php
                                $ua = $visit->user_agent ?? '';
                                $isBot = preg_match('/bot|spider|crawl|curl|wget|python-requests/i', $ua);
                                $isSuspicious = empty($visit->accept_language) || $isBot;
                                $isReal = !$isBot && !$isSuspicious;

                                $statusClass = $isBot ? 'bot' : ($isSuspicious ? 'suspicious' : 'real');
                                $statusText = $isBot ? 'Bot/Robot' : ($isSuspicious ? 'Suspicious' : 'Real Person');
                                $statusIcon = $isBot
                                    ? 'fas fa-robot'
                                    : ($isSuspicious
                                        ? 'fas fa-exclamation-triangle'
                                        : 'fas fa-user');
                            @endphp

                            <div class="status-badge {{ $statusClass }}">
                                <i class="{{ $statusIcon }}"></i>
                                {{ $statusText }}
                            </div>
                        </div>

                        <!-- Visit Details -->
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-calendar me-2"></i>
                                Visit Date & Time
                            </div>
                            <div class="detail-value">
                                {{ \Carbon\Carbon::parse($visit->date)->format('l, F j, Y \a\t g:i A') }}
                                <small
                                    class="text-muted">({{ \Carbon\Carbon::parse($visit->date)->diffForHumans() }})</small>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-globe me-2"></i>
                                IP Address
                            </div>
                            <div class="detail-value">
                                {{ $visit->ip }}
                                <small class="text-muted">(Click to copy)</small>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-link me-2"></i>
                                URL Visited
                            </div>
                            <div class="detail-value">
                                <a href="{{ $visit->url }}" target="_blank" class="text-decoration-none">
                                    {{ $visit->url }}
                                    <i class="fas fa-external-link-alt ms-1 small"></i>
                                </a>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-language me-2"></i>
                                Accept Language
                            </div>
                            <div class="detail-value">
                                @if ($visit->accept_language)
                                    {{ $visit->accept_language }}
                                @else
                                    <span class="text-muted">Not provided (suspicious)</span>
                                @endif
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-desktop me-2"></i>
                                User Agent
                            </div>
                            <div class="detail-value code">
                                {{ $visit->user_agent }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-code me-2"></i>
                                Headers (JSON)
                            </div>
                            <div class="detail-value code">
                                {{ $visit->headers_json ?? '{}' }}
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="mb-2">
                                <i class="fas fa-info-circle me-2"></i>
                                Analysis
                            </h6>
                            <ul class="mb-0 small">
                                <li><strong>Bot Detection:</strong>
                                    {{ $isBot ? 'Yes - User agent contains bot keywords' : 'No - Appears to be human' }}
                                </li>
                                <li><strong>Language Header:</strong>
                                    {{ $visit->accept_language ? 'Present' : 'Missing (potentially suspicious)' }}</li>
                                <li><strong>Visit Type:</strong> {{ $statusText }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy IP address functionality
            const ipElement = document.querySelector('.detail-value');
            if (ipElement && ipElement.textContent.includes('Click to copy')) {
                ipElement.style.cursor = 'pointer';
                ipElement.addEventListener('click', function() {
                    const ip = '{{ $visit->ip }}';
                    navigator.clipboard.writeText(ip).then(function() {
                        // Show temporary feedback
                        const original = ipElement.innerHTML;
                        ipElement.innerHTML = ip + ' <small class="text-success">(Copied!)</small>';
                        setTimeout(() => {
                            ipElement.innerHTML = original;
                        }, 2000);
                    });
                });
            }
        });
    </script>
@endpush
