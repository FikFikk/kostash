@extends('dashboard.admin.layouts.app')

@section('title', 'Visit Logs')

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
        .visits-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .visits-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border: none;
        }

        .visits-card-body {
            padding: 0;
        }

        /* Filter Section */
        .filter-section {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .filter-btn {
            background: white;
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-btn:hover {
            border-color: #667eea;
            color: #667eea;
            text-decoration: none;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
        }

        .filter-btn.danger.active {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .filter-btn.success.active {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        }

        .filter-btn.warning.active {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
        }

        /* Visit Item Styling */
        .visit-item {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .visit-item:hover {
            background: var(--bg-secondary);
        }

        .visit-item:last-child {
            border-bottom: none;
        }

        .visit-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .visit-avatar.bot {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .visit-avatar.suspicious {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
        }

        .visit-avatar.real {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
        }

        .visit-avatar.unknown {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .visit-info {
            flex: 1;
            min-width: 0;
        }

        .visit-ip {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .visit-url {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 400px;
        }

        .visit-meta {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .visit-badges {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
        }

        .visit-type-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .badge-real {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .badge-bot {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .badge-suspicious {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .badge-unknown {
            background: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
        }

        .visit-actions {
            margin-top: 0.5rem;
        }

        .btn-view {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .stats-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stats-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filter-buttons {
                flex-direction: column;
            }

            .filter-btn {
                width: 100%;
                justify-content: center;
            }

            .visit-item {
                padding: 1rem;
            }

            .visit-avatar {
                width: 40px;
                height: 40px;
                margin-right: 0.75rem;
            }

            .visit-badges {
                align-items: flex-start;
                margin-top: 0.75rem;
            }
        }

        /* Pagination Styling */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            color: var(--text-secondary);
            background-color: var(--bg-card);
            border-color: var(--border-color);
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 6px !important;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            color: #667eea;
            background-color: var(--bg-secondary);
            border-color: #667eea;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .pagination .page-item.disabled .page-link {
            color: var(--text-muted);
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        /* Dark mode pagination */
        [data-bs-theme="dark"] .pagination .page-link {
            color: var(--text-secondary);
            background-color: var(--bg-card);
            border-color: var(--border-color);
        }

        [data-bs-theme="dark"] .pagination .page-link:hover {
            color: #667eea;
            background-color: var(--bg-secondary);
        }

        [data-bs-theme="dark"] .pagination .page-item.disabled .page-link {
            color: var(--text-muted);
            background-color: var(--bg-secondary);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="visits-card">
                    <div class="visits-card-header">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-chart-line me-3"></i>
                            Visit Logs & Analytics
                        </h4>
                    </div>

                    <div class="filter-section">
                        <!-- Stats Overview -->
                        <div class="row mb-4">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number text-success">{{ $stats['real_visitors'] ?? 0 }}</div>
                                    <div class="stats-label">Real People</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number text-danger">{{ $stats['bots'] ?? 0 }}</div>
                                    <div class="stats-label">Bots</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number text-warning">{{ $stats['suspicious'] ?? 0 }}</div>
                                    <div class="stats-label">Suspicious</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number text-info">{{ $stats['total'] ?? 0 }}</div>
                                    <div class="stats-label">Total Visits</div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="filter-buttons">
                            <a href="{{ route('dashboard.visits.index') }}"
                                class="filter-btn {{ !request('filter') ? 'active' : '' }}">
                                <i class="fas fa-list"></i>
                                All Visits
                            </a>
                            <a href="{{ route('dashboard.visits.index', ['filter' => 'real']) }}"
                                class="filter-btn success {{ request('filter') === 'real' ? 'active success' : '' }}">
                                <i class="fas fa-user-check"></i>
                                Real People
                            </a>
                            <a href="{{ route('dashboard.visits.index', ['filter' => 'bots']) }}"
                                class="filter-btn danger {{ request('filter') === 'bots' ? 'active danger' : '' }}">
                                <i class="fas fa-robot"></i>
                                Bots Only
                            </a>
                            <a href="{{ route('dashboard.visits.index', ['filter' => 'suspicious']) }}"
                                class="filter-btn warning {{ request('filter') === 'suspicious' ? 'active warning' : '' }}">
                                <i class="fas fa-exclamation-triangle"></i>
                                Suspicious
                            </a>
                        </div>

                        <!-- Search and Per Page -->
                        <form class="d-flex gap-2" method="GET" action="{{ route('dashboard.visits.index') }}">
                            @if (request('filter'))
                                <input type="hidden" name="filter" value="{{ request('filter') }}">
                            @endif
                            <input type="search" name="q" class="form-control"
                                placeholder="Search IP, URL, or User Agent..." value="{{ request('q') }}"
                                style="flex: 1;">
                            <select name="per_page" class="form-select" style="width: auto;">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <button class="btn btn-gradient" type="submit">
                                <i class="fas fa-search me-1"></i>
                                Search
                            </button>
                        </form>
                    </div>

                    <div class="visits-card-body">
                        @forelse($visits as $visit)
                            @php
                                $isBot = $labels[$visit->id]['text'] === 'bot' ?? false;
                                $isSuspicious = empty($visit->accept_language) || ($ipCounts[$visit->ip] ?? 0) > 3;
                                $isReal = !$isBot && !$isSuspicious && !empty($visit->accept_language);

                                $avatarClass = $isBot
                                    ? 'bot'
                                    : ($isSuspicious
                                        ? 'suspicious'
                                        : ($isReal
                                            ? 'real'
                                            : 'unknown'));
                                $badgeClass = $isBot
                                    ? 'badge-bot'
                                    : ($isSuspicious
                                        ? 'badge-suspicious'
                                        : ($isReal
                                            ? 'badge-real'
                                            : 'badge-unknown'));
                                $badgeText = $isBot
                                    ? 'Bot'
                                    : ($isSuspicious
                                        ? 'Suspicious'
                                        : ($isReal
                                            ? 'Real Person'
                                            : 'Unknown'));
                            @endphp

                            <div class="visit-item">
                                <div class="d-flex align-items-start">
                                    <div class="visit-avatar {{ $avatarClass }}">
                                        @if ($isBot)
                                            <i class="fas fa-robot"></i>
                                        @elseif($isSuspicious)
                                            <i class="fas fa-exclamation-triangle"></i>
                                        @elseif($isReal)
                                            <i class="fas fa-user"></i>
                                        @else
                                            <i class="fas fa-question"></i>
                                        @endif
                                    </div>

                                    <div class="visit-info">
                                        <div class="visit-ip">
                                            {{ $visit->ip }}
                                            @if (($ipCounts[$visit->ip] ?? 0) > 1)
                                                <span class="badge bg-secondary ms-2">x{{ $ipCounts[$visit->ip] }}</span>
                                            @endif
                                        </div>
                                        <div class="visit-url">{{ $visit->url }}</div>
                                        <div class="visit-meta">
                                            {{ \Carbon\Carbon::parse($visit->date)->diffForHumans() }}
                                            @if ($visit->accept_language)
                                                • {{ $visit->accept_language }}
                                            @endif
                                        </div>
                                        <div class="visit-meta mt-1">
                                            <small>{{ \Illuminate\Support\Str::limit($visit->user_agent, 80) }}</small>
                                        </div>
                                    </div>

                                    <div class="visit-badges">
                                        <span class="visit-type-badge {{ $badgeClass }}">
                                            {{ $badgeText }}
                                        </span>

                                        @php $friendlyLang = $languages[$visit->id] ?? null; @endphp
                                        @if ($friendlyLang)
                                            <span class="badge bg-success">{{ $friendlyLang }}</span>
                                        @elseif($visit->accept_language)
                                            <span class="badge bg-success">{{ $visit->accept_language }}</span>
                                        @endif

                                        <div class="visit-actions">
                                            <a href="{{ route('dashboard.visits.show', $visit->id) }}" class="btn-view">
                                                <i class="fas fa-eye me-1"></i>
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-chart-line"></i>
                                <h5>No visits found</h5>
                                <p>Try adjusting your filters or check back later.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($visits->hasPages())
                        <div class="card-footer bg-transparent border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Showing {{ $visits->firstItem() ?? 0 }} - {{ $visits->lastItem() ?? 0 }}
                                    of {{ $visits->total() }} visits
                                </small>
                                <div>
                                    {{ $visits->withQueryString()->links('dashboard.admin.layouts.pagination') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
                try {
                    new bootstrap.Tooltip(el);
                } catch (e) {
                    /* ignore if bootstrap not available */
                }
            });

            // Auto-submit search on enter
            document.querySelector('input[name="q"]').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.closest('form').submit();
                }
            });
        });
    </script>
@endpush
