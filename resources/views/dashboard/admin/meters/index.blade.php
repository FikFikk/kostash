@extends('dashboard.admin.layouts.app')

@section('title', 'Meter Readings')

@push('styles')
{{-- Custom styles for a modern, consistent UI --}}
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
    .table-modern {
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-modern th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid var(--bs-border-color);
    }
    .table-modern td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--bs-border-color-translucent);
        vertical-align: middle;
    }
    .accordion-button:not(.collapsed) {
        color: var(--bs-primary);
        background-color: var(--bs-primary-bg-subtle);
        font-weight: 600;
    }
    .accordion-item {
        border-radius: var(--radius-lg) !important;
        border: 1px solid var(--bs-border-color-translucent) !important;
        overflow: hidden;
    }
    .action-buttons .btn {
        width: 35px; height: 35px;
        display: inline-flex; align-items: center; justify-content: center;
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-dashboard-2-line me-2"></i>Meter Readings</h1>
                    <p class="text-muted mb-0">Manage monthly water and electricity meter readings for each room.</p>
                </div>
                 <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="{{ route('dashboard.meter.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line me-1"></i> Add New Reading
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Info Section -->
    <div class="card content-card mb-4">
        <div class="card-body">
             <div class="d-flex flex-column flex-md-row align-items-md-center">
                <div class="mb-2 mb-md-0 me-md-3">
                    <form method="GET" action="{{ route('dashboard.meter.index') }}" class="mb-0">
                        <div class="input-group">
                            <label for="year-select" class="input-group-text">Year</label>
                            <select name="year" id="year-select" class="form-select" onchange="this.form.submit()" style="min-width: 120px;">
                                <option value="">Select Year</option>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ (request('year', now()->year) == $year) ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            @if(request('year') && request('year') != now()->year)
                                <a href="{{ route('dashboard.meter.index') }}" class="btn btn-outline-secondary" title="Reset to current year">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                @if(request('year', now()->year))
                    <div class="alert alert-info mb-0 py-2 px-3 d-flex align-items-center flex-grow-1">
                        <i class="ri-information-line me-2"></i>
                        <div>
                            Displaying data for year <strong>{{ request('year', now()->year) }}</strong>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Meter Readings Accordion -->
    <div class="accordion" id="meterReadingsAccordion">
        @foreach($rooms as $room)
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading{{ $room->id }}">
                <button class="accordion-button fw-medium {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $room->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $room->id }}">
                    <i class="ri-home-4-line me-2"></i>
                    {{ $room->name }}
                    <span class="badge bg-primary-subtle text-primary ms-2">{{ count($roomMeters[$room->id] ?? []) }} readings</span>
                </button>
            </h2>
            <div id="collapse{{ $room->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $room->id }}" data-bs-parent="#meterReadingsAccordion">
                <div class="accordion-body p-0">
                    <div class="table-responsive">
                         <table class="table table-modern table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Period</th>
                                    <th>Water Usage (m³)</th>
                                    <th>Electric Usage (kWh)</th>
                                    <th>Created At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomMeters[$room->id] ?? [] as $meter)
                                    <tr>
                                        <td>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($meter->period)->format('F Y') }}</span>
                                        </td>
                                        <td>
                                            <i class="ri-water-flash-line text-info me-1"></i>
                                            {{ $meter->total_water ?? ($meter->water_meter_end - $meter->water_meter_start) }}
                                            <small class="text-muted"> ({{ $meter->water_meter_start }} → {{ $meter->water_meter_end }})</small>
                                        </td>
                                        <td>
                                            <i class="ri-flashlight-line text-warning me-1"></i>
                                            {{ $meter->total_electric ?? ($meter->electric_meter_end - $meter->electric_meter_start) }}
                                             <small class="text-muted"> ({{ $meter->electric_meter_start }} → {{ $meter->electric_meter_end }})</small>
                                        </td>
                                        <td>{{ $meter->created_at->format('d M Y') }}</td>
                                        <td class="text-end">
                                             <div class="d-flex gap-2 justify-content-end action-buttons">
                                                <button type="button" class="btn btn-sm btn-soft-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $meter->id }}" title="View Details">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                                <a href="{{ route('dashboard.meter.edit', $meter->id) }}" class="btn btn-sm btn-soft-warning" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <form action="{{ route('dashboard.meter.destroy', $meter->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-soft-danger" title="Delete">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal for each meter -->
                                    <div id="viewModal{{ $meter->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="flipModalLabel{{ $meter->id }}">Detail Meter - Kamar {{ $meter->room->name ?? '-' }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($meter->period)->format('F Y') }}</p>
                                                    <p><strong>Water Meter:</strong> {{ $meter->water_meter_start }} → {{ $meter->water_meter_end }} (Total: {{ $meter->total_water ?? $meter->water_meter_end - $meter->water_meter_start }} m³)</p>
                                                    <p><strong>Electric Meter:</strong> {{ $meter->electric_meter_start }} → {{ $meter->electric_meter_end }} (Total: {{ $meter->total_electric ?? $meter->electric_meter_end - $meter->electric_meter_start }} kWh)</p>
                                                    <p><strong>Total Tagihan:</strong> Rp{{ number_format($meter->total_bill ?? 0, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No meter readings for this room in {{ request('year', now()->year) }}.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
