{{-- resources/views/dashboard/admin/meters/partials/room-details.blade.php --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0">
        <i class="ri-home-4-line me-2"></i>{{ $room->name }}
        <span class="badge bg-primary-subtle text-primary ms-2">{{ $year }}</span>
    </h6>
    <small class="text-muted">{{ $readings->count() }} readings found</small>
</div>

@if($readings->count() > 0)
    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-info-subtle">
                <div class="card-body text-center py-3">
                    <i class="ri-water-flash-line text-info fs-4"></i>
                    <h5 class="mb-0 mt-1">{{ number_format($readings->sum('total_water')) }}</h5>
                    <small>Total Water (m³)</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning-subtle">
                <div class="card-body text-center py-3">
                    <i class="ri-flashlight-line text-warning fs-4"></i>
                    <h5 class="mb-0 mt-1">{{ number_format($readings->sum('total_electric')) }}</h5>
                    <small>Total Electric (kWh)</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success-subtle">
                <div class="card-body text-center py-3">
                    <i class="ri-calendar-line text-success fs-4"></i>
                    <h5 class="mb-0 mt-1">{{ $readings->count() }}</h5>
                    <small>Readings</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Readings Table --}}
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Period</th>
                    <th class="text-center">Water (m³)</th>
                    <th class="text-center">Electric (kWh)</th>
                    <th class="text-center">Reading Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($readings as $reading)
                    <tr>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($reading->period)->format('M Y') }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info-subtle text-info">
                                {{ number_format($reading->total_water) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning-subtle text-warning">
                                {{ number_format($reading->total_electric) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">{{ $reading->created_at->format('d M Y') }}</small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        onclick="viewMeterDetail('{{ $reading->id }}')">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <a href="{{ route('dashboard.meter.edit', $reading->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="ri-pencil-line"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-4">
        <i class="ri-file-list-line fs-1 text-muted mb-3 d-block"></i>
        <h6 class="text-muted">No readings found for {{ $room->name }} in {{ $year }}</h6>
        <p class="text-muted mb-3">Start by adding a meter reading for this room.</p>
        <a href="{{ route('dashboard.meter.create', ['room' => $room->id]) }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Reading
        </a>
    </div>
@endif