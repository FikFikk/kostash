@extends('admin.dashboard.layouts.app')

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
            <table class="table align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kamar</th>
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
                    @forelse($meters as $index => $meter)
                        <tr>
                            <td>{{ ($meters->currentPage() - 1) * $meters->perPage() + $index + 1 }}</td>
                            <td>{{ $meter->room->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($meter->period)->format('F Y') }}</td>
                            <td>{{ $meter->water_meter_start ?? '-' }}</td>
                            <td>{{ $meter->water_meter_end ?? '-' }}</td>
                            <td>{{ $meter->electric_meter_start ?? '-' }}</td>
                            <td>{{ $meter->electric_meter_end ?? '-' }}</td>
                            <td>{{ $meter->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('meter.edit', $meter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('meter.destroy', $meter->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No meter data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $meters->links('admin.dashboard.layouts.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection
