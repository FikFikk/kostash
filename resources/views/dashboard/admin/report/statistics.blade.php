@extends('dashboard.admin.layouts.app')

@section('title', 'Statistik Laporan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Card Statistik Utama -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Laporan</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $stats['total_reports'] }}">0</span></h4>
                            <a href="{{ route('dashboard.report.index') }}" class="text-decoration-underline">Lihat semua laporan</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                <i class="ri-file-text-line text-white"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
             <div class="card card-animate bg-warning-subtle border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Laporan Menunggu</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $stats['pending_reports'] }}">0</span></h4>
                            <a href="{{ route('dashboard.report.index', ['status' => 'pending']) }}" class="text-decoration-underline">Lihat laporan menunggu</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="ri-time-line text-white"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
             <div class="card card-animate bg-info-subtle border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Sedang Diproses</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $stats['in_progress_reports'] }}">0</span></h4>
                             <a href="{{ route('dashboard.report.index', ['status' => 'in_progress']) }}" class="text-decoration-underline">Lihat laporan diproses</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="ri-loader-2-line text-white"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
             <div class="card card-animate bg-success-subtle border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Laporan Selesai</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $stats['completed_reports'] }}">0</span></h4>
                             <a href="{{ route('dashboard.report.index', ['status' => 'completed']) }}" class="text-decoration-underline">Lihat laporan selesai</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="ri-checkbox-circle-line text-white"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Terbaru & Berdasarkan Kategori -->
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">5 Laporan Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Pelapor</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_reports'] as $report)
                                <tr>
                                    {{-- PERBAIKAN: Menggunakan namespace lengkap untuk Str --}}
                                    <td><a href="{{ route('dashboard.report.show', $report->id) }}">{{ \Illuminate\Support\Str::limit($report->title, 35) }}</a></td>
                                    <td>{{ $report->user->name ?? 'N/A' }}</td>
                                    <td><span class="badge bg-{{ $report->status_color }}">{{ $report->status_label }}</span></td>
                                    <td>{{ $report->reported_at ? $report->reported_at->diffForHumans() : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Laporan Berdasarkan Kategori</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($stats['reports_by_category'] as $category => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $categories[$category] ?? ucfirst($category) }}
                                <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
