@extends('dashboard.admin.layouts.app')

@section('title', 'Meter Readings')

@push('styles')
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
        --radius-lg: 1rem;
    }
    
    .content-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-elegant);
        background-color: var(--bs-card-bg);
    }
    
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .room-filter-btn {
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .room-filter-btn.active {
        background: var(--gradient-primary);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        color: white !important;
    }
    
    .metric-card {
        border-left: 4px solid var(--color, #dee2e6);
        transition: transform 0.2s ease;
    }
    
    .metric-card:hover {
        transform: translateY(-2px);
    }
    
    .table-condensed td {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
    
    .month-header {
        writing-mode: vertical-lr;
        text-orientation: mixed;
        min-width: 40px;
        font-size: 0.8rem;
    }
    
    .usage-cell {
        text-align: center;
        font-weight: 500;
    }
    
    .no-data {
        color: #9ca3af;
        font-style: italic;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold text-gradient mb-1">
                        <i class="ri-dashboard-2-line me-2"></i>Meter Readings
                    </h1>
                    <p class="text-muted mb-0">Monitor water and electricity usage across all rooms</p>
                </div>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="{{ route('dashboard.meter.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add Reading
                    </a>
                    <button class="btn btn-outline-primary" id="viewToggleBtn" onclick="toggleView()">
                        <i class="ri-layout-grid-line me-1"></i> <span id="viewToggleText">Grid View</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card content-card">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.meter.index') }}" id="year-filter-form">
                        <div class="input-group">
                            <label for="year-select" class="input-group-text">
                                <i class="ri-calendar-line"></i>
                            </label>
                            <select name="year" id="year-select" class="form-select" onchange="this.form.submit()">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ request('year', now()->year) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="room" value="{{ request('room', 'all') }}">
                            <input type="hidden" name="view_mode" value="{{ request('view_mode', 'table') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card content-card metric-card" style="--color: #3b82f6;">
                        <div class="card-body text-center">
                            <i class="ri-water-flash-line text-info fs-3 mb-2"></i>
                            <h4 class="mb-1">{{ number_format($yearlyStats['total_water'] ?? 0) }}</h4>
                            <small class="text-muted">Total Water (m³)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card content-card metric-card" style="--color: #f59e0b;">
                        <div class="card-body text-center">
                            <i class="ri-flashlight-line text-warning fs-3 mb-2"></i>
                            <h4 class="mb-1">{{ number_format($yearlyStats['total_electric'] ?? 0) }}</h4>
                            <small class="text-muted">Total Electric (kWh)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card content-card metric-card" style="--color: #10b981;">
                        <div class="card-body text-center">
                            <i class="ri-file-list-3-line text-success fs-3 mb-2"></i>
                            <h4 class="mb-1">{{ $totalReadings ?? 0 }}</h4>
                            <small class="text-muted">Total Readings</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card content-card mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="text-muted me-2">Filter by room:</span>
                <button type="button" class="btn btn-sm btn-outline-primary room-filter-btn {{ request('room', 'all') == 'all' ? 'active' : '' }}" data-room="all">
                    All Rooms
                </button>
                @foreach($rooms as $room)
                    <button type="button" class="btn btn-sm btn-outline-primary room-filter-btn {{ request('room') == $room->id ? 'active' : '' }}" data-room="{{ $room->id }}">
                        {{ $room->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div id="tableView" class="card content-card {{ request('view_mode', 'table') == 'grid' ? 'd-none' : '' }}">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Room</th>
                            @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $monthName)
                                <th class="text-center month-header">{{ $monthName }}</th>
                            @endforeach
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            <tr class="room-row" data-room="{{ $room->id }}">
                                <td class="fw-medium">
                                    <i class="ri-home-4-line me-2 text-primary"></i>
                                    {{ $room->name }}
                                </td>
                                @for($month = 1; $month <= 12; $month++)
                                    @php
                                        $reading = ($roomMeters[$room->id] ?? collect())->firstWhere('month', $month);
                                    @endphp
                                    <td class="usage-cell">
                                        @if($reading)
                                            <div class="d-flex flex-column">
                                                <small class="text-info">
                                                    <i class="ri-water-flash-line"></i>
                                                    {{ $reading->total_water }}
                                                </small>
                                                <small class="text-warning">
                                                    <i class="ri-flashlight-line"></i>
                                                    {{ $reading->total_electric }}
                                                </small>
                                            </div>
                                        @else
                                            <span class="no-data">-</span>
                                        @endif
                                    </td>
                                @endfor
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="ri-more-2-line"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('dashboard.meter.create', ['room' => $room->id]) }}">
                                                <i class="ri-add-line me-2"></i>Add Reading
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="showRoomDetails('{{ $room->id }}')">
                                                <i class="ri-eye-line me-2"></i>View Details
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center text-muted py-3">
                                    <i class="ri-file-list-line fs-4 mb-2 d-block"></i>
                                    No rooms found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="gridView" class="row {{ request('view_mode', 'table') == 'table' ? 'd-none' : '' }}">
        @forelse($rooms as $room)
            <div class="col-lg-6 col-xl-4 mb-4 room-card" data-room="{{ $room->id }}">
                <div class="card content-card h-100">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0">
                            <i class="ri-home-4-line me-2"></i>{{ $room->name }}
                            <span class="badge bg-primary-subtle text-primary ms-2">
                                {{ count($roomMeters[$room->id] ?? []) }} readings
                            </span>
                        </h6>
                    </div>
                    <div class="card-body">
                        @if(!empty($roomMeters[$room->id]))
                            <div class="table-responsive">
                                <table class="table table-sm table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Period</th>
                                            <th class="text-center">Water</th>
                                            <th class="text-center">Electric</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(collect($roomMeters[$room->id])->take(6) as $meter)
                                            <tr>
                                                <td class="small">{{ \Carbon\Carbon::parse($meter->period)->format('M Y') }}</td>
                                                <td class="text-center small text-info">{{ $meter->total_water }}</td>
                                                <td class="text-center small text-warning">{{ $meter->total_electric }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="viewMeterDetail('{{ $meter->id }}')">
                                                            <i class="ri-eye-line"></i>
                                                        </button>
                                                        <a href="{{ route('dashboard.meter.edit', $meter->id) }}" class="btn btn-outline-warning btn-sm">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($roomMeters[$room->id]) > 6)
                                <div class="text-center mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="showAllReadings('{{ $room->id }}')">
                                        View All ({{ count($roomMeters[$room->id]) }})
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="ri-file-list-line fs-4 mb-2 d-block"></i>
                                No readings for {{ request('year', now()->year) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-4">
                    <i class="ri-file-list-line fs-1 text-muted mb-3 d-block"></i>
                    <h6 class="text-muted">No rooms found.</h6>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const MeterApp = {
    modal: null,
    modalContent: null,
    modalTitle: null,

    init() {
        this.modal = new bootstrap.Modal(document.getElementById('detailModal'));
        this.modalContent = document.getElementById('modalContent');
        this.modalTitle = document.getElementById('detailModalLabel');
        this.bindEvents();
        this.initializeFilters();
    },

    bindEvents() {
        document.querySelectorAll('.room-filter-btn').forEach(button => {
            button.addEventListener('click', (e) => this.handleRoomFilter(e));
        });
    },

    initializeFilters() {
        const urlParams = new URLSearchParams(window.location.search);
        const currentRoomFilter = urlParams.get('room') || 'all';
        this.applyRoomFilter(currentRoomFilter);
    },

    handleRoomFilter(event) {
        const selectedRoom = event.target.dataset.room;
        
        const url = new URL(window.location.href);
        url.searchParams.set('room', selectedRoom);
        window.history.pushState({ path: url.href }, '', url.href);

        document.querySelectorAll('.room-filter-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        this.applyRoomFilter(selectedRoom);
    },

    applyRoomFilter(selectedRoom) {
        const elements = [...document.querySelectorAll('.room-row'), ...document.querySelectorAll('.room-card')];
        
        elements.forEach(element => {
            element.style.display = (selectedRoom === 'all' || element.dataset.room === selectedRoom) ? '' : 'none';
        });
    },

    showLoadingInModal(title = "Loading Details...") {
        this.modalTitle.textContent = title;
        this.modalContent.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading content...</p>
            </div>
        `;
        this.modal.show();
    },

    async fetchData(url) {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Fetch error:', error);
            throw error;
        }
    },

    showError(message, details = '') {
        this.modalContent.innerHTML = `
            <div class="alert alert-danger" role="alert">
                <i class="ri-error-warning-line me-2"></i>
                <strong>Error!</strong> ${message}
                ${details ? `<br><small class="text-muted">${details}</small>` : ''}
            </div>
        `;
    }
};

window.viewMeterDetail = async function(meterId) {
    MeterApp.showLoadingInModal("Meter Reading Details");
    const url = '{{ route("dashboard.meter.details", ":id") }}'.replace(':id', meterId);

    try {
        const data = await MeterApp.fetchData(url);
        MeterApp.modalContent.innerHTML = data.html || '<p>No details available.</p>';
    } catch (error) {
        MeterApp.showError('Could not load meter details', error.message);
    }
};

window.showRoomDetails = window.showAllReadings = async function(roomId) {
    const yearSelect = document.getElementById('year-select');
    const currentYear = yearSelect ? yearSelect.value : new Date().getFullYear();
    
    const roomRow = document.querySelector(`[data-room="${roomId}"]`);
    const roomName = roomRow ? roomRow.querySelector('.fw-medium')?.textContent?.trim().replace(/^\S+\s*/, '') : `Room ${roomId}`;
    
    MeterApp.showLoadingInModal(`${roomName} - ${currentYear} Readings`);
    
    const url = '{{ route("dashboard.meter.room.details", ":roomId") }}'.replace(':roomId', encodeURIComponent(roomId)) + `?year=${currentYear}`;

    try {
        const data = await MeterApp.fetchData(url);
        MeterApp.modalContent.innerHTML = data.html || '<p>No room details available.</p>';
    } catch (error) {
        MeterApp.showError('Could not load room details', `Room ID: ${roomId}`);
    }
};

window.toggleView = function() {
    const tableView = document.getElementById('tableView');
    const gridView = document.getElementById('gridView');
    const viewToggleText = document.getElementById('viewToggleText');

    if (tableView.classList.contains('d-none')) {
        tableView.classList.remove('d-none');
        gridView.classList.add('d-none');
        viewToggleText.textContent = 'Grid View';
    } else {
        tableView.classList.add('d-none');
        gridView.classList.remove('d-none');
        viewToggleText.textContent = 'Table View';
    }
};

document.addEventListener('DOMContentLoaded', () => MeterApp.init());
</script>
@endpush
@endsection
