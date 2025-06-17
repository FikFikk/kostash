@extends('dashboard.admin.layouts.app')

@section('title', 'Manajemen Laporan')

@section('content')
<div class="container-fluid">
    <!-- Card untuk Filter Laporan -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Filter Laporan</h5>
        </div>
        <div class="card-body">
            
        </div>
    </div>

    <!-- Card untuk Tabel Laporan -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Daftar Laporan Masuk</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Judul Laporan</th>
                            <th scope="col">Pelapor</th>
                            <th scope="col">Kamar</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td class="text-truncate" style="max-width: 200px;">
                                    <a href="{{ route('dashboard.report.show', $report->id) }}" class="fw-medium">{{ $report->title }}</a>
                                </td>
                                <td>{{ $report->user->name ?? 'N/A' }}</td>
                                <td>{{ $report->room->name ?? 'N/A' }}</td>
                                <td>{{ $report->category_label }}</td>
                                <td>{{ $report->reported_at ? $report->reported_at->format('d M Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->status_color }}">{{ $report->status_label }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.report.show', $report->id) }}" class="btn btn-primary btn-sm">Kelola</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="mb-1">Tidak ada laporan yang cocok dengan filter Anda.</p>
                                    <a href="{{ route('dashboard.report.index') }}">Reset Filter</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $reports->appends(request()->query())->links('dashboard.admin.layouts.pagination') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
