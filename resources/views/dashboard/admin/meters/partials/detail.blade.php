{{-- resources/views/dashboard/admin/meters/partials/detail.blade.php --}}
<div class="row">
    <div class="col-md-6">
        <h6 class="text-muted mb-3">Meter Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Room:</strong></td>
                <td>{{ $meter->room->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Period:</strong></td>
                <td>{{ \Carbon\Carbon::parse($meter->period)->format('F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Reading Date:</strong></td>
                <td>{{ $meter->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6 class="text-muted mb-3">Usage Summary</h6>
        <div class="row text-center">
            <div class="col-6">
                <div class="card bg-info-subtle">
                    <div class="card-body py-2">
                        <i class="ri-water-flash-line text-info fs-4"></i>
                        <h5 class="mb-0 mt-1">{{ number_format($meter->total_water) }}</h5>
                        <small>m³ Water</small>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card bg-warning-subtle">
                    <div class="card-body py-2">
                        <i class="ri-flashlight-line text-warning fs-4"></i>
                        <h5 class="mb-0 mt-1">{{ number_format($meter->total_electric) }}</h5>
                        <small>kWh Electric</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-6">
        <h6 class="text-muted mb-3">Water Meter Readings</h6>
        <table class="table table-sm">
            <tr>
                <td>Start Reading:</td>
                <td><strong>{{ number_format($meter->water_meter_start) }}</strong></td>
            </tr>
            <tr>
                <td>End Reading:</td>
                <td><strong>{{ number_format($meter->water_meter_end) }}</strong></td>
            </tr>
            <tr class="table-info">
                <td>Usage:</td>
                <td><strong>{{ number_format($meter->total_water) }} m³</strong></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6 class="text-muted mb-3">Electric Meter Readings</h6>
        <table class="table table-sm">
            <tr>
                <td>Start Reading:</td>
                <td><strong>{{ number_format($meter->electric_meter_start) }}</strong></td>
            </tr>
            <tr>
                <td>End Reading:</td>
                <td><strong>{{ number_format($meter->electric_meter_end) }}</strong></td>
            </tr>
            <tr class="table-warning">
                <td>Usage:</td>
                <td><strong>{{ number_format($meter->total_electric) }} kWh</strong></td>
            </tr>
        </table>
    </div>
</div>

@if($meter->notes)
<hr>
<div>
    <h6 class="text-muted mb-2">Notes</h6>
    <p class="mb-0">{{ $meter->notes }}</p>
</div>
@endif

<div class="mt-3 text-end">
    <a href="{{ route('dashboard.meter.edit', $meter->id) }}" class="btn btn-sm btn-outline-primary">
        <i class="ri-pencil-line me-1"></i> Edit Reading
    </a>
</div>