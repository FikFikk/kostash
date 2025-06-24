<div class="mb-4">
    <h4 class="text-gradient mb-2">
        <i class="ri-dashboard-2-line me-2"></i>Meter Reading Details
        <small class="text-muted d-inline-block ms-2">{{ \Carbon\Carbon::parse($meter->period)->format('F Y') }}</small>
    </h4>
    <p class="text-muted mb-0">Detailed information for the meter reading of <span class="fw-bold">{{ $meter->room->name ?? 'N/A' }}</span>.</p>
</div>

{{-- Main Details and Usage Summary --}}
<div class="row g-3 mb-4">
    {{-- Meter Information Card --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100 p-2" style="border-left: 5px solid var(--bs-primary) !important; background-color: var(--bs-primary-bg-subtle);">
            <div class="card-body">
                <h6 class="mb-3 text-primary fw-bold"><i class="ri-information-line me-2"></i>Reading Overview</h6>
                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                        <tr>
                            <td class="ps-0 py-1"><strong>Room:</strong></td>
                            <td class="py-1">{{ $meter->room->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1"><strong>Period:</strong></td>
                            <td class="py-1">{{ \Carbon\Carbon::parse($meter->period)->format('F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1"><strong>Recorded On:</strong></td>
                            <td class="py-1">{{ $meter->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Usage Summary Cards --}}
    <div class="col-lg-6">
        <div class="row g-3 h-100">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-left: 5px solid #3b82f6 !important; background-color: rgba(59, 130, 246, 0.05);">
                    <div class="card-body text-center py-3">
                        <i class="ri-water-flash-line text-info fs-2 mb-2"></i>
                        <h5 class="mb-0 text-dark fw-bold">{{ number_format($meter->total_water) }} m³</h5>
                        <small class="text-muted">Total Water Usage</small>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-left: 5px solid #f59e0b !important; background-color: rgba(245, 158, 11, 0.05);">
                    <div class="card-body text-center py-3">
                        <i class="ri-flashlight-line text-warning fs-2 mb-2"></i>
                        <h5 class="mb-0 text-dark fw-bold">{{ number_format($meter->total_electric) }} kWh</h5>
                        <small class="text-muted">Total Electric Usage</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Detailed Readings Section --}}
<div class="card content-card shadow-sm mb-4">
    <div class="card-header bg-gradient-light-subtle d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 text-primary fw-bold"><i class="ri-numbers-line me-2"></i>Detailed Meter Values</h5>
    </div>
    <div class="card-body p-0">
        <div class="row g-0"> {{-- Use g-0 for no gutter between columns for better table-like look --}}
            {{-- Water Meter Details --}}
            <div class="col-md-6 border-end"> {{-- Add border-end for separator --}}
                <div class="p-4">
                    <h6 class="mb-3 text-info fw-bold"><i class="ri-drop-line me-2"></i>Water Meter</h6>
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="ps-0 py-1">Start Reading:</td>
                                <td class="text-end pe-0 py-1"><strong>{{ number_format($meter->water_meter_start) }}</strong></td>
                            </tr>
                            <tr>
                                <td class="ps-0 py-1">End Reading:</td>
                                <td class="text-end pe-0 py-1"><strong>{{ number_format($meter->water_meter_end) }}</strong></td>
                            </tr>
                            <tr class="table-info-subtle"> {{-- Use Bootstrap 5 subtle colors for rows --}}
                                <td class="ps-0 py-1 fw-bold">Calculated Usage:</td>
                                <td class="text-end pe-0 py-1 fw-bold">{{ number_format($meter->total_water) }} m³</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Electric Meter Details --}}
            <div class="col-md-6">
                <div class="p-4">
                    <h6 class="mb-3 text-warning fw-bold"><i class="ri-thunderbolt-line me-2"></i>Electric Meter</h6>
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="ps-0 py-1">Start Reading:</td>
                                <td class="text-end pe-0 py-1"><strong>{{ number_format($meter->electric_meter_start) }}</strong></td>
                            </tr>
                            <tr>
                                <td class="ps-0 py-1">End Reading:</td>
                                <td class="text-end pe-0 py-1"><strong>{{ number_format($meter->electric_meter_end) }}</strong></td>
                            </tr>
                            <tr class="table-warning-subtle">
                                <td class="ps-0 py-1 fw-bold">Calculated Usage:</td>
                                <td class="text-end pe-0 py-1 fw-bold">{{ number_format($meter->total_electric) }} kWh</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Total Bill Section --}}
@if($meter->total_bill)
<div class="card shadow-sm border-0 mb-4" style="border-left: 5px solid #10b981 !important; background-color: rgba(16, 185, 129, 0.05);">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-success fw-bold">
            <i class="ri-file-text-line me-2"></i>Total Bill:
        </h5>
        <h4 class="mb-0 text-success fw-bold">Rp{{ number_format($meter->total_bill, 0, ',', '.') }}</h4>
    </div>
</div>
@endif

{{-- Notes Section (if any) --}}
@if($meter->notes)
<div class="card content-card shadow-sm mb-4">
    <div class="card-header bg-gradient-light-subtle py-3">
        <h5 class="mb-0 text-primary fw-bold"><i class="ri-sticky-note-line me-2"></i>Notes</h5>
    </div>
    <div class="card-body">
        <p class="mb-0 text-muted">{{ $meter->notes }}</p>
    </div>
</div>
@endif

{{-- Actions --}}
<div class="text-end mt-4">
    <a href="{{ route('dashboard.meter.edit', $meter->id) }}" class="btn btn-primary me-2">
        <i class="ri-pencil-line me-1"></i> Edit Reading
    </a>
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <i class="ri-close-line me-1"></i> Close
    </button>
</div>