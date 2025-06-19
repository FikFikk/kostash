@extends('dashboard.admin.layouts.app')

@section('title', 'Statistik Laporan')

@push('styles')
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    [data-bs-theme="dark"] {
        --gradient-primary: linear-gradient(135deg, #4c63d2 0%, #5a4fcf 100%);
        --gradient-warning: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
        --gradient-info: linear-gradient(135deg, #42a5f5 0%, #26c6da 100%);
        --gradient-success: linear-gradient(135deg, #66bb6a 0%, #26a69a 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.3);
        --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.4);
    }

    .stats-card {
        background: var(--bs-card-bg);
        border: none;
        border-radius: 20px;
        box-shadow: var(--shadow-elegant);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(10px);
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transition: all 0.3s ease;
    }

    .stats-card.warning-card::before {
        background: var(--gradient-warning);
    }

    .stats-card.info-card::before {
        background: var(--gradient-info);
    }

    .stats-card.success-card::before {
        background: var(--gradient-success);
    }

    .stats-card:hover::before {
        height: 6px;
    }

    .stats-icon {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gradient-primary);
        color: white;
        font-size: 1.8rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .warning-card .stats-icon {
        background: var(--gradient-warning);
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
    }

    .info-card .stats-icon {
        background: var(--gradient-info);
        box-shadow: 0 8px 25px rgba(66, 165, 245, 0.3);
    }

    .success-card .stats-icon {
        background: var(--gradient-success);
        box-shadow: 0 8px 25px rgba(102, 187, 106, 0.3);
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin: 0;
    }

    .warning-card .stats-number {
        background: var(--gradient-warning);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .info-card .stats-number {
        background: var(--gradient-info);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .success-card .stats-number {
        background: var(--gradient-success);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-label {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--bs-secondary);
        margin-bottom: 1rem;
    }

    .stats-link {
        color: var(--bs-primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .stats-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background: var(--gradient-primary);
        transition: width 0.3s ease;
    }

    .stats-link:hover::after {
        width: 100%;
    }

    .stats-link:hover {
        color: var(--bs-primary);
        transform: translateX(5px);
    }

    .content-card {
        background: var(--bs-card-bg);
        border: none;
        border-radius: 20px;
        box-shadow: var(--shadow-elegant);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .content-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .card-header-modern {
        background: transparent;
        border-bottom: 2px solid var(--bs-border-color-translucent);
        padding: 1.5rem;
        position: relative;
    }

    .card-header-modern::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 1.5rem;
        width: 60px;
        height: 3px;
        background: var(--gradient-primary);
        border-radius: 2px;
    }

    .card-title-modern {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--bs-heading-color);
        margin: 0;
    }

    .table-modern {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-modern th {
        background: var(--bs-tertiary-bg);
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
    }

    .table-modern td {
        padding: 1rem;
        border-bottom: 1px solid var(--bs-border-color-translucent);
        vertical-align: middle;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background: var(--bs-tertiary-bg);
        transform: scale(1.01);
    }

    .report-link {
        color: var(--bs-heading-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .report-link:hover {
        color: var(--bs-primary);
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }

    .category-item {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color-translucent);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.8rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .category-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gradient-primary);
        transition: width 0.3s ease;
    }

    .category-item:hover {
        transform: translateX(8px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .category-item:hover::before {
        width: 6px;
    }

    .category-name {
        font-weight: 600;
        color: var(--bs-heading-color);
        margin-bottom: 0;
    }

    .category-count {
        background: var(--gradient-primary);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
        min-width: 40px;
        text-align: center;
    }

    .animate-in {
        animation: slideInUp 0.6s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .counter-value {
        animation: countUp 2s ease-out;
    }

    @keyframes countUp {
        from {
            opacity: 0;
            transform: scale(0.5);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Dark mode specific adjustments */
    [data-bs-theme="dark"] .stats-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .content-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .category-item {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .table-modern th {
        background: rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .table-modern tbody tr:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-number {
            font-size: 2rem;
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .stats-card {
            margin-bottom: 1rem;
        }
        
        .content-card {
            margin-bottom: 1rem;
        }
        
        .card-header-modern {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .stats-number {
            font-size: 1.8rem;
        }
        
        .stats-label {
            font-size: 0.8rem;
        }
        
        .table-modern th,
        .table-modern td {
            padding: 0.75rem 0.5rem;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 fw-bold text-gradient mb-1">📊 Statistik Laporan</h1>
                    <p class="text-muted mb-0">Dashboard overview laporan dan statistik terkini</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="ri-refresh-line me-1"></i>Refresh
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i class="ri-download-line me-1"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card animate-in" style="animation-delay: 0.1s">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-2">Total Laporan</p>
                            <h2 class="stats-number mb-0">
                                <span class="counter-value" data-target="{{ $stats['total_reports'] }}">0</span>
                            </h2>
                        </div>
                        <div class="stats-icon">
                            <i class="ri-file-text-line"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.report.index') }}" class="stats-link">
                        <i class="ri-arrow-right-line me-1"></i>Lihat semua laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning-card animate-in" style="animation-delay: 0.2s">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-2">Menunggu Review</p>
                            <h2 class="stats-number mb-0">
                                <span class="counter-value" data-target="{{ $stats['pending_reports'] }}">0</span>
                            </h2>
                        </div>
                        <div class="stats-icon">
                            <i class="ri-time-line"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.report.index', ['status' => 'pending']) }}" class="stats-link">
                        <i class="ri-arrow-right-line me-1"></i>Review sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card info-card animate-in" style="animation-delay: 0.3s">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-2">Sedang Diproses</p>
                            <h2 class="stats-number mb-0">
                                <span class="counter-value" data-target="{{ $stats['in_progress_reports'] }}">0</span>
                            </h2>
                        </div>
                        <div class="stats-icon">
                            <i class="ri-loader-2-line"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.report.index', ['status' => 'in_progress']) }}" class="stats-link">
                        <i class="ri-arrow-right-line me-1"></i>Pantau progress
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card success-card animate-in" style="animation-delay: 0.4s">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-2">Selesai</p>
                            <h2 class="stats-number mb-0">
                                <span class="counter-value" data-target="{{ $stats['completed_reports'] }}">0</span>
                            </h2>
                        </div>
                        <div class="stats-icon">
                            <i class="ri-checkbox-circle-line"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.report.index', ['status' => 'completed']) }}" class="stats-link">
                        <i class="ri-arrow-right-line me-1"></i>Lihat riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Cards -->
    <div class="row g-4 mb-4">
        <!-- Recent Reports -->
        <div class="col-lg-8">
            <div class="content-card animate-in" style="animation-delay: 0.5s">
                <div class="card-header-modern">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title-modern">🕒 Laporan Terbaru</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="ri-filter-line"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="ri-more-2-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Laporan</th>
                                    <th>Pelapor</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_reports'] as $report)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3 flex-shrink-0">
                                                <div class="avatar-title bg-light text-primary rounded-circle">
                                                    <i class="ri-file-text-line"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{ route('dashboard.report.show', $report->id) }}" class="report-link">
                                                    {{ \Illuminate\Support\Str::limit($report->title, 40) }}
                                                </a>
                                                <div class="text-muted small">ID: #{{ $report->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                    {{ substr($report->user->name ?? 'N', 0, 1) }}
                                                </div>
                                            </div>
                                            <span class="fw-medium">{{ $report->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-modern bg-{{ $report->status_color }}">
                                            {{ $report->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            {{ $report->reported_at ? $report->reported_at->diffForHumans() : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Statistics -->
        <div class="col-lg-4">
            <div class="content-card animate-in" style="animation-delay: 0.6s">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">📁 Kategori Laporan</h5>
                </div>
                <div class="card-body">
                    <div class="category-list">
                        @foreach($stats['reports_by_category'] as $category => $count)
                        <div class="category-item">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="category-name">
                                    {{ $categories[$category] ?? ucfirst($category) }}
                                </div>
                                <div class="category-count">
                                    {{ $count }}
                                </div>
                            </div>
                        </div>
                        @endforeach
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
    // Counter animation
    const counters = document.querySelectorAll('.counter-value');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 50);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 50);
    };
    
    // Intersection Observer for counter animation
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target.querySelector('.counter-value');
                if (counter && !counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            }
        });
    }, observerOptions);
    
    // Observe stats cards
    document.querySelectorAll('.stats-card').forEach(card => {
        observer.observe(card);
    });
    
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading states to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.dataset.loading !== 'false') {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="ri-loader-2-line spinner-border spinner-border-sm me-1"></i>Loading...';
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            }
        });
    });
    
    // Enhanced hover effects
    document.querySelectorAll('.stats-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Auto-refresh functionality
    const refreshBtn = document.querySelector('.btn-outline-primary');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            // Add refresh logic here
            this.querySelector('i').classList.add('ri-refresh-line');
            setTimeout(() => {
                location.reload();
            }, 500);
        });
    }
});

// Add CSS animation classes dynamically
const style = document.createElement('style');
style.textContent = `
    .spinner-border-sm {
        animation: spinner-border 0.75s linear infinite;
    }
    
    @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
    }
    
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
`;
document.head.appendChild(style);
</script>
@endpush
