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

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-1 small">Total Pendapatan</p>
                            <h3 class="mb-0 text-primary fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                            <div class="d-flex align-items-center mt-2">
                                <span class="badge bg-{{ $revenueGrowthPercent >= 0 ? 'success' : 'danger' }}-subtle text-{{ $revenueGrowthPercent >= 0 ? 'success' : 'danger' }} me-2">
                                    <i class="ri-arrow-{{ $revenueGrowthPercent >= 0 ? 'up' : 'down' }}-line"></i>
                                    {{ number_format(abs($revenueGrowthPercent), 1) }}%
                                </span>
                                <small class="text-muted">dari bulan lalu</small>
                            </div>
                        </div>
                        <div class="avatar-lg bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center">
                            <i class="ri-money-dollar-circle-line text-primary fs-24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-1 small">Total Penghuni</p>
                            <h3 class="mb-0 text-success fw-bold">{{ $totalTenants }}</h3>
                            <div class="d-flex align-items-center mt-2">
                                <span class="badge bg-{{ $growthPercent >= 0 ? 'success' : 'danger' }}-subtle text-{{ $growthPercent >= 0 ? 'success' : 'danger' }} me-2">
                                    <i class="ri-arrow-{{ $growthPercent >= 0 ? 'up' : 'down' }}-line"></i>
                                    {{ number_format(abs($growthPercent), 1) }}%
                                </span>
                                <small class="text-muted">penghuni baru</small>
                            </div>
                        </div>
                        <div class="avatar-lg bg-success-subtle rounded-3 d-flex align-items-center justify-content-center">
                            <i class="ri-group-line text-success fs-24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-1 small">Tingkat Hunian</p>
                            <h3 class="mb-0 text-info fw-bold">{{ number_format($occupancyRate, 1) }}%</h3>
                            <div class="d-flex align-items-center mt-2">
                                <small class="text-muted">{{ $roomsWithTenants }}/{{ $totalRooms }} kamar terisi</small>
                            </div>
                        </div>
                        <div class="avatar-lg bg-info-subtle rounded-3 d-flex align-items-center justify-content-center">
                            <i class="ri-building-line text-info fs-24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-1 small">Tagihan Pending</p>
                            <h3 class="mb-0 text-warning fw-bold">{{ $totalPendingTransactionsCount }}</h3>
                            <div class="d-flex align-items-center mt-2">
                                <small class="text-muted">Rp {{ number_format($totalPendingTransactions, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        <div class="avatar-lg bg-warning-subtle rounded-3 d-flex align-items-center justify-content-center">
                            <i class="ri-bill-line text-warning fs-24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Tren Pendapatan</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                    type="button" 
                                    id="period-dropdown" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false">
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
                                <li><hr class="dropdown-divider"></li>
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
                    <div class="row mt-3">
                        <div class="col-6 text-center">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted small">Terisi</span>
                            </div>
                            <h6 class="mb-0">{{ $roomsWithTenants ?? 0 }}</h6>
                        </div>
                        <div class="col-6 text-center">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="bg-secondary rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted small">Kosong</span>
                            </div>
                            <h6 class="mb-0">{{ $roomsWithoutTenants ?? 0 }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="ri-money-dollar-circle-line text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Pendapatan Bulan Ini</h6>
                            <h4 class="text-primary mb-0">Rp {{ number_format($totalRevenueThisMonth ?? 0, 0, ',', '.') }}</h4>
                            <small class="text-muted">
                                @if(($revenueGrowth ?? 0) > 0)
                                    <i class="ri-arrow-up-line text-success"></i> {{ number_format($revenueGrowth, 1) }}%
                                @elseif(($revenueGrowth ?? 0) < 0)
                                    <i class="ri-arrow-down-line text-danger"></i> {{ number_format(abs($revenueGrowth), 1) }}%
                                @else
                                    <i class="ri-subtract-line text-secondary"></i> 0%
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="ri-bill-line text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Tagihan Belum Lunas</h6>
                            <h4 class="text-warning mb-0">Rp {{ number_format($totalOutstanding ?? 0, 0, ',', '.') }}</h4>
                            <small class="text-muted">{{ $overdueBills ?? 0 }} tagihan terlambat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="ri-home-4-line text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Tingkat Hunian</h6>
                            <h4 class="text-info mb-0">{{ number_format($occupancyRate ?? 0, 1) }}%</h4>
                            <small class="text-muted">{{ $roomsWithTenants ?? 0 }} dari {{ $totalRooms ?? 0 }} kamar</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="ri-percent-line text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Tingkat Penagihan</h6>
                            <h4 class="text-success mb-0">{{ number_format($collectionRate ?? 0, 1) }}%</h4>
                            <small class="text-muted">Bulan ini</small>
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
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

.space-y-3 > * + * {
    margin-top: 1rem;
}
</style>
@endsection

@section('script')
<script>
// Greeting script
document.addEventListener("DOMContentLoaded", function () {
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
            document.querySelectorAll('[data-period]').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update dropdown button text
            const dropdownButton = document.querySelector('#period-dropdown');
            if (dropdownButton) {
                dropdownButton.innerHTML = `<i class="ri-calendar-line me-1"></i> ${periodText}`;
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

        console.log('Initial chart data:', { labels: revenueLabels, values: revenueValues });

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

        // Room Status Chart - Get data from PHP variables
        let roomsWithTenants = 0;
        let roomsWithoutTenants = 0;
        
        // These variables should be passed from the PHP controller
        if (typeof window.roomsWithTenants !== 'undefined') {
            roomsWithTenants = window.roomsWithTenants;
        }
        if (typeof window.roomsWithoutTenants !== 'undefined') {
            roomsWithoutTenants = window.roomsWithoutTenants;
        }

        const roomStatusOptions = {
            series: [roomsWithTenants, roomsWithoutTenants],
            chart: {
                type: 'donut',
                height: '100%'
            },
            labels: ['Terisi', 'Kosong'],
            colors: ['#198754', '#6c757d'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Kamar',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                show: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    }
                }
            }]
        };

        if (document.querySelector("#room-status-chart")) {
            roomChart = new ApexCharts(document.querySelector("#room-status-chart"), roomStatusOptions);
            roomChart.render();
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
            console.log('Received data:', data); // Debug log
            
            if (data.monthlyRevenue && data.monthlyRevenue.length > 0 && revenueChart) {
                const labels = data.monthlyRevenue.map(item => item.month);
                const values = data.monthlyRevenue.map(item => parseFloat(item.revenue) || 0);
                
                console.log('Updating chart with:', { labels, values }); // Debug log
                
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
            } else {
                console.warn('No data received or chart not initialized:', data);
            }
            
            // Remove loading state
            if (chartContainer) {
                chartContainer.style.opacity = '1';
            }
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
            
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
        // ApexCharts automatically handles resize, but we can force it if needed
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
