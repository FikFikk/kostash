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
            <form action="{{ route('dashboard.report.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="priority" class="form-label">Prioritas</label>
                    <select name="priority" id="priority" class="form-select">
                        <option value="">Semua Prioritas</option>
                         @foreach($priorities as $key => $value)
                            <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ri-filter-3-line align-bottom me-1"></i> Filter
                    </button>
                </div>
            </form>
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
