@extends('dashboard.admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Meter Readings</h4>
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard.meter.create') }}" class="btn btn-primary btn-label">
                    <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Tambah
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            @foreach($rooms as $room)
                <h5 class="mt-4">{{ $room->name }}</h5>
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Periode</th>
                            <th scope="col">Air Lama</th>
                            <th scope="col">Air Baru</th>
                            <th scope="col">Listrik Lama</th>
                            <th scope="col">Listrik Baru</th>
                            <th scope="col">Dibuat Pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roomMeters[$room->id] ?? [] as $meter)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($meter->period)->format('F Y') }}</td>
                                <td>{{ $meter->water_meter_start ?? '-' }}</td>
                                <td>{{ $meter->water_meter_end ?? '-' }}</td>
                                <td>{{ $meter->electric_meter_start ?? '-' }}</td>
                                <td>{{ $meter->electric_meter_end ?? '-' }}</td>
                                <td>{{ $meter->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $meter->id }}">View</button>
                                    <a href="{{ route('dashboard.meter.edit', $meter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('dashboard.meter.destroy', $meter->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div id="viewModal{{ $meter->id }}" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel{{ $meter->id }}" aria-hidden="true">
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
                            <tr><td colspan="7" class="text-center">Tidak ada data untuk kamar ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
</div>
@endsection
