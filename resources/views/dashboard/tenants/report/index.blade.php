@extends('dashboard.tenants.layouts.app')

@section('title', 'Laporan Saya')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Daftar Laporan Saya</h4>
            <div class="flex-shrink-0">
                <a href="{{ route('tenant.report.create') }}" class="btn btn-primary btn-label waves-effect waves-light">
                    <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Buat Laporan Baru
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul Laporan</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Prioritas</th>
                            <th scope="col">Tanggal Lapor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $key => $report)
                            <tr>
                                <td>{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
                                <td class="text-truncate" style="max-width: 250px;">{{ $report->title }}</td>
                                <td>{{ $report->category_label }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->priority_color }}">{{ $report->priority_label }}</span>
                                </td>
                                <td>{{ $report->reported_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->status_color }}">{{ $report->status_label }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('tenant.report.show', $report->id) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Anda belum pernah membuat laporan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $reports->links('dashboard.tenants.layouts.pagination') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection