@extends('dashboard.admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800 fw-bold" id="greeting-text">Selamat datang!</h1>
                        <p class="text-muted mb-0">Kelola koskosan Anda dengan mudah dan efisien</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="ri-download-line me-1"></i> Export Data
                        </button>
                        <button class="btn btn-primary btn-sm">
                            <i class="ri-add-line me-1"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Atas: Kotak kecil, grid responsif, tidak scroll horizontal -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted mb-1 small">Total Pendapatan</p>
                                <!-- Komentar: Total pendapatan = semua tagihan bulan ini (paid + unpaid + partial), payment gateway masih pending -->
                                <h3 class="mb-0 text-primary fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                                </h3>
                                <div class="d-flex align-items-center mt-2">
                                    <span
                                        class="badge bg-{{ $revenueGrowthPercent >= 0 ? 'success' : 'danger' }}-subtle text-{{ $revenueGrowthPercent >= 0 ? 'success' : 'danger' }} me-2">
                                        <i class="ri-arrow-{{ $revenueGrowthPercent >= 0 ? 'up' : 'down' }}-line"></i>
                                        {{ number_format(abs($revenueGrowthPercent), 1) }}%
                                    </span>
                                    <small class="text-muted">dari bulan lalu</small>
                                </div>
                            </div>
                            <div
                                class="avatar-lg bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center">
                                <i class="ri-money-dollar-circle-line text-primary fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted mb-1 small">Pengunjung Hari Ini</p>
                                <!-- Komentar: Implementasi tracking pengunjung bisa pakai DB/tabel visits -->
                                <h3 class="mb-0 text-success fw-bold">{{ $visitorToday }}</h3>
                                <div class="d-flex align-items-center mt-2">
                                    <small class="text-muted">Orang unik yang mengakses website hari ini</small>
                                </div>
                            </div>
                            <div
                                class="avatar-lg bg-success-subtle rounded-3 d-flex align-items-center justify-content-center">
                                <i class="ri-eye-line text-success fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted mb-1 small">Tingkat Hunian</p>
                                <h3
                                    class="mb-0 fw-bold {{ number_format($occupancyRate, 1) == 100.0 ? 'text-danger' : 'text-info' }}">
                                    {{ number_format($occupancyRate, 1) }}%</h3>
                                <div class="d-flex align-items-center mt-2">
                                    <small class="text-muted">{{ $roomsWithTenants }}/{{ $totalRooms }} kamar
                                        terisi</small>
                                </div>
                            </div>
                            <div
                                class="avatar-lg {{ number_format($occupancyRate, 1) == 100.0 ? 'bg-danger-subtle' : 'bg-info-subtle' }} rounded-3 d-flex align-items-center justify-content-center">
                                <i
                                    class="ri-building-line {{ number_format($occupancyRate, 1) == 100.0 ? 'text-danger' : 'text-info' }} fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted mb-1 small">Total Pengunjung Selama Ini</p>
                                <!-- Komentar: Implementasi tracking pengunjung bisa pakai DB/tabel visits -->
                                <h3 class="mb-0 text-warning fw-bold">{{ $visitorTotal }}</h3>
                                <div class="d-flex align-items-center mt-2">
                                    <small class="text-muted">Orang unik yang pernah mengakses website ini</small>
                                </div>
                            </div>
                            <div
                                class="avatar-lg bg-warning-subtle rounded-3 d-flex align-items-center justify-content-center">
                                <i class="ri-eye-2-line text-warning fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            @media (max-width: 768px) {
                .row.g-4.mb-4>.col-6 {
                    padding-right: 8px;
                    padding-left: 8px;
                }

                .card.hover-card {
                    min-width: 0;
                    max-width: 100%;
                    padding: 0.5rem 0.5rem;
                    font-size: 0.95em;
                }

                .card-body h3,
                .card-body h4 {
                    font-size: 1.1em !important;
                }

                .avatar-lg {
                    width: 38px;
                    height: 38px;
                    font-size: 1.2em;
                }

                .card-body p,
                .card-body small {
                    font-size: 0.92em !important;
                }
            }
        </style>

        <div class="row">
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Tren Pendapatan</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    id="period-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-calendar-line me-1"></i> 12 Bulan Terakhir
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="period-dropdown">
                                    <li>
                                        <a class="dropdown-item" href="#" data-period="6_months">
                                            <i class="ri-calendar-2-line me-2"></i>6 Bulan Terakhir
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item active" href="#" data-period="12_months">
                                            <i class="ri-calendar-line me-2"></i>12 Bulan Terakhir
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-period="ytd">
                                            <i class="ri-calendar-check-line me-2"></i>Year to Date
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-period="1_year">
                                            <i class="ri-calendar-event-line me-2"></i>1 Tahun
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-period="3_years">
                                            <i class="ri-calendar-todo-line me-2"></i>3 Tahun
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-period="5_years">
                                            <i class="ri-time-line me-2"></i>5 Tahun
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="revenue-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title mb-0">Status Kamar</h5>
                    </div>
                    <div class="card-body">
                        <div id="room-status-chart" style="height: 300px;"></div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->

        <!-- Additional Revenue Cards: Last Month & All-time -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-secondary bg-opacity-10 p-3 rounded">
                                    <i class="ri-calendar-2-line text-secondary fs-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Pendapatan Bulan Kemarin</h6>
                                <h4 class="text-secondary mb-0">Rp
                                    {{ number_format($revenueLastMonth ?? 0, 0, ',', '.') }}
                                </h4>
                                <small class="text-muted">Periode:
                                    {{ \Carbon\Carbon::now()->subMonth()->format('F Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="ri-stack-line text-primary fs-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Pendapatan All-time</h6>
                                <h4 class="text-primary mb-0">Rp {{ number_format($revenueAllTime ?? 0, 0, ',', '.') }}
                                </h4>
                                <small class="text-muted">Total semua tagihan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .avatar-lg {
            width: 60px;
            height: 60px;
        }

        .avatar-sm {
            width: 35px;
            height: 35px;
        }

        .card {
            border-radius: 12px;
        }

        .btn {
            border-radius: 8px;
        }

        .badge {
            border-radius: 6px;
        }

        .space-y-3>*+* {
            margin-top: 1rem;
        }
    </style>
@endsection

@section('script')
    <script>
        // Greeting script
        document.addEventListener("DOMContentLoaded", function() {
            const now = new Date();
            const hour = now.getHours();
            let greeting = "Selamat Pagi";

            if (hour >= 11 && hour < 15) {
                greeting = "Selamat Siang";
            } else if (hour >= 15 && hour < 18) {
                greeting = "Selamat Sore";
            } else if (hour >= 18 || hour < 4) {
                greeting = "Selamat Malam";
            }

            const userName = @json(auth()->user()->name ?? 'Admin');
            document.getElementById("greeting-text").innerText = `${greeting}, ${userName}!`;
        });

        // Include the JavaScript code from the previous artifact here
        document.addEventListener('DOMContentLoaded', function() {
            let revenueChart = null;
            let roomChart = null;
            let initialChartData = null;

            // Get initial chart data from PHP (passed from controller)
            if (typeof monthlyRevenue !== 'undefined') {
                initialChartData = monthlyRevenue;
            }

            // Initialize charts with actual data from controller
            initializeCharts();

            // Add event listeners for filter buttons
            document.querySelectorAll('[data-period]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const period = this.getAttribute('data-period');
                    const periodText = this.textContent.trim();

                    // Update active button
                    document.querySelectorAll('[data-period]').forEach(btn => btn.classList.remove(
                        'active'));
                    this.classList.add('active');

                    // Update dropdown button text
                    const dropdownButton = document.querySelector('#period-dropdown');
                    if (dropdownButton) {
                        dropdownButton.innerHTML =
                            `<i class="ri-calendar-line me-1"></i> ${periodText}`;
                    }

                    // Close dropdown
                    const dropdownElement = document.querySelector('#period-dropdown');
                    if (dropdownElement) {
                        const dropdown = bootstrap.Dropdown.getInstance(dropdownElement);
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }

                    // Fetch new data and update chart
                    fetchChartData(period);
                });
            });

            function initializeCharts() {
                // Use actual data from controller or fallback to sample data
                let revenueLabels = [];
                let revenueValues = [];

                if (initialChartData && initialChartData.length > 0) {
                    // Use actual data from controller
                    revenueLabels = initialChartData.map(item => item.month);
                    revenueValues = initialChartData.map(item => parseFloat(item.revenue) || 0);
                } else {
                    // Fallback to sample data if no data available
                    revenueLabels = ['Jan 2025', 'Feb 2025', 'Mar 2025', 'Apr 2025', 'May 2025', 'Jun 2025'];
                    revenueValues = [2500000, 3200000, 2800000, 3500000, 4100000, 3800000];
                }

                const revenueOptions = {
                    series: [{
                        name: 'Pendapatan',
                        data: revenueValues
                    }],
                    chart: {
                        type: 'area',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.3,
                        }
                    },
                    colors: ['#0d6efd'],
                    xaxis: {
                        categories: revenueLabels,
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                }
                                if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                }
                                return 'Rp ' + (value ? value.toLocaleString('id-ID') : '0');
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                };

                if (document.querySelector("#revenue-chart")) {
                    revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), revenueOptions);
                    revenueChart.render();
                }

                // Enhanced Room Status Chart - Beautiful Donut Chart
                let roomsWithTenants = 6;
                let roomsWithoutTenants = 0;

                // Try to get data from PHP variables with multiple fallback methods
                if (typeof window.roomsWithTenants !== 'undefined') {
                    roomsWithTenants = parseInt(window.roomsWithTenants) || 0;
                } else if (typeof roomsWithTenants !== 'undefined') {
                    roomsWithTenants = parseInt(roomsWithTenants) || 0;
                }

                if (typeof window.roomsWithoutTenants !== 'undefined') {
                    roomsWithoutTenants = parseInt(window.roomsWithoutTenants) || 0;
                } else if (typeof roomsWithoutTenants !== 'undefined') {
                    roomsWithoutTenants = parseInt(roomsWithoutTenants) || 0;
                }

                const roomStatusOptions = {
                    series: [roomsWithTenants, roomsWithoutTenants],
                    chart: {
                        type: 'donut',
                        height: 320,
                        width: '100%',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 1000,
                            animateGradually: {
                                enabled: true,
                                delay: 150
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 350
                            }
                        },
                        dropShadow: {
                            enabled: true,
                            top: 2,
                            left: 2,
                            blur: 4,
                            opacity: 0.1
                        }
                    },
                    labels: ['Terisi', 'Kosong'],
                    colors: ['#28a745', '#dc3545'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '18px',
                                        fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, sans-serif',
                                        fontWeight: 500,
                                        color: '#374151',
                                        offsetY: -15,
                                        formatter: function(val) {
                                            return val
                                        }
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '32px',
                                        fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, sans-serif',
                                        fontWeight: 700,
                                        color: '#1f2937',
                                        offsetY: 5,
                                        formatter: function(val) {
                                            return parseInt(val)
                                        }
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'Total Kamar',
                                        fontSize: '16px',
                                        fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, sans-serif',
                                        fontWeight: 500,
                                        color: '#6b7280',
                                        formatter: function(w) {
                                            const total = w.globals.seriesTotals.reduce((a, b) => {
                                                return a + b
                                            }, 0);
                                            return total
                                        }
                                    }
                                }
                            },
                            expandOnClick: true
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        fontSize: '14px',
                        fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, sans-serif',
                        fontWeight: 500,
                        offsetY: 10,
                        labels: {
                            colors: '#374151',
                            useSeriesColors: false
                        },
                        markers: {
                            width: 14,
                            height: 14,
                            radius: 7,
                            offsetX: -2,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 15,
                            vertical: 8
                        },
                        formatter: function(seriesName, opts) {
                            return seriesName + ': ' + opts.w.globals.series[opts.seriesIndex] + ' kamar'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        colors: ['#ffffff']
                    },
                    tooltip: {
                        enabled: true,
                        theme: 'light',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, sans-serif'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' kamar'
                            }
                        },
                        fillSeriesColor: false,
                        custom: function({
                            series,
                            seriesIndex,
                            dataPointIndex,
                            w
                        }) {
                            const percentage = ((series[seriesIndex] / series.reduce((a, b) => a + b, 0)) *
                                100).toFixed(1);
                            return `
                        <div class="custom-tooltip" style="background: white; padding: 12px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb;">
                            <div style="font-weight: 600; color: #1f2937; margin-bottom: 4px;">
                                ${w.globals.labels[seriesIndex]}
                            </div>
                            <div style="color: #6b7280; font-size: 13px;">
                                ${series[seriesIndex]} kamar (${percentage}%)
                            </div>
                        </div>
                    `;
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'lighten',
                                value: 0.1
                            }
                        },
                        active: {
                            filter: {
                                type: 'darken',
                                value: 0.1
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                width: '100%',
                                height: 280
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        labels: {
                                            name: {
                                                fontSize: '16px'
                                            },
                                            value: {
                                                fontSize: '28px'
                                            },
                                            total: {
                                                fontSize: '14px'
                                            }
                                        }
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom',
                                offsetY: 5
                            }
                        }
                    }, {
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%',
                                height: 260
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '70%',
                                        labels: {
                                            name: {
                                                fontSize: '14px'
                                            },
                                            value: {
                                                fontSize: '24px'
                                            },
                                            total: {
                                                fontSize: '12px'
                                            }
                                        }
                                    }
                                }
                            },
                            legend: {
                                fontSize: '12px'
                            }
                        }
                    }]
                };

                // Initialize room chart with better error handling
                const roomChartElement = document.querySelector("#room-status-chart");
                if (roomChartElement) {
                    try {
                        roomChartElement.innerHTML = '';
                        roomChart = new ApexCharts(roomChartElement, roomStatusOptions);
                        roomChart.render();
                    } catch (error) {
                        roomChartElement.innerHTML = `
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-center">
                            <div class="mb-3">
                                <span class="badge bg-success me-2">Terisi: ${roomsWithTenants}</span>
                                <span class="badge bg-secondary">Kosong: ${roomsWithoutTenants}</span>
                            </div>
                            <p class="text-muted">Chart tidak dapat dimuat</p>
                        </div>
                    </div>
                `;
                    }
                }
            }

            function fetchChartData(period) {
                // Show loading state
                const chartContainer = document.querySelector("#revenue-chart");
                if (chartContainer) {
                    chartContainer.style.opacity = '0.5';
                }

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                const token = csrfToken ? csrfToken.getAttribute('content') : '';

                // Make AJAX request to get filtered data
                fetch(`${window.location.pathname}?period=${period}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.monthlyRevenue && data.monthlyRevenue.length > 0 && revenueChart) {
                            const labels = data.monthlyRevenue.map(item => item.month);
                            const values = data.monthlyRevenue.map(item => parseFloat(item.revenue) || 0);

                            // Update chart with new data
                            revenueChart.updateOptions({
                                xaxis: {
                                    categories: labels,
                                    labels: {
                                        style: {
                                            fontSize: '12px'
                                        }
                                    }
                                }
                            }, false, true);

                            revenueChart.updateSeries([{
                                name: 'Pendapatan',
                                data: values
                            }], true);
                        }

                        // Remove loading state
                        if (chartContainer) {
                            chartContainer.style.opacity = '1';
                        }
                    })
                    .catch(error => {
                        // Show error message to user
                        const chartContainer = document.querySelector("#revenue-chart");
                        if (chartContainer) {
                            chartContainer.innerHTML = `
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-center">
                            <i class="ri-error-warning-line text-danger fs-1"></i>
                            <p class="text-muted mt-2">Gagal memuat data chart</p>
                            <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                                <i class="ri-refresh-line me-1"></i>Muat Ulang
                            </button>
                        </div>
                    </div>
                `;
                        }
                    });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (revenueChart) {
                    setTimeout(() => {
                        revenueChart.updateOptions({}, false, true);
                    }, 100);
                }
                if (roomChart) {
                    setTimeout(() => {
                        roomChart.updateOptions({}, false, true);
                    }, 100);
                }
            });
        });
    </script>
@endsection
