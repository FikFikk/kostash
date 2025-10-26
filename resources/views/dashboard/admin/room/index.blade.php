@extends('dashboard.admin.layouts.app')

@section('title', 'Room Management')

@push('styles')
{{-- Custom styles for a modern, consistent UI --}}
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.12);
        --radius-lg: 1rem;
    }
    .stats-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-elegant);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        position: relative;
    }
    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }
    .stats-icon {
        width: 60px; height: 60px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: var(--gradient-primary);
        color: white; font-size: 1.6rem;
    }
    .stats-card.success-card .stats-icon { background: var(--gradient-success); }
    .stats-card.info-card .stats-icon { background: var(--gradient-info); }
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .stats-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--bs-secondary-color);
    }
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .content-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-elegant);
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
    .action-buttons .btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    /* PERBAIKAN: Style untuk modal dan tombol close */
    .image-modal-content {
        background: transparent;
        border: none;
        display: inline-block;
        width: auto;
    }
    .image-modal-dialog {
        max-width: 90vw;
        display: flex; 
        align-items: center; 
        justify-content: center;
        min-height: calc(100% - (var(--bs-modal-margin) * 2));
    }
    .image-modal-wrapper {
        position: relative;
        display: inline-block;
    }
    .btn-close-modal {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
        filter: invert(1) grayscale(100%) brightness(200%);
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-home-4-line me-2"></i>Room Management</h1>
                    <p class="text-muted mb-0">Manage all rooms, their status, and assigned tenants.</p>
                </div>
                 <a href="{{ route('dashboard.room.create') }}" class="btn btn-primary btn-sm mt-3 mt-lg-0">
                    <i class="ri-add-line me-1"></i> Add New Room
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Total Rooms</p>
                            <h3 class="stats-number mb-0">{{ $totalRooms ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-building-4-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stats-card success-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Available Rooms</p>
                            <h3 class="stats-number mb-0">{{ $availableRooms ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-door-open-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stats-card info-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Kamar Terisi</p>
                            <h3 class="stats-number mb-0">{{ $occupiedRooms ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-user-3-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Table -->
    <div class="card content-card">
        <div class="card-header bg-transparent d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Room List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Room Info</th>
                            <th>Status</th>
                            <th>Tenant</th>
                            <th>Facilities</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 flex-shrink-0">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $room->id }}">
                                            <img src="{{ $room->image ? asset('storage/' . $room->image) : asset('assets/images/rocket-img.png') }}" alt="{{ $room->name }}" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $room->name }}</h6>
                                        <p class="text-muted mb-0 small">{{ $room->width }}m x {{ $room->length }}m</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($room->user)
                                    <span class="badge bg-danger-subtle text-danger">Terisi</span>
                                @else
                                    <span class="badge bg-success-subtle text-success">Available</span>
                                @endif
                            </td>
                            <td>
                                @if($room->user)
                                    <span class="fw-medium">{{ $room->user->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(json_decode($room->facilities ?? '[]') as $facility)
                                        @foreach(explode(',', $facility) as $item)
                                            <span class="badge badge-soft-primary">{{ trim($item) }}</span>
                                        @endforeach
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end action-buttons">
                                    {{-- Vacate Room Button (only show if room has tenant) --}}
                                    @if($room->user)
                                        <form action="{{ route('dashboard.room.vacate', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan kamar ini? Penyewa akan dipindahkan dari kamar.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip" title="Kosongkan Kamar">
                                                <i class="ri-door-open-line"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    {{-- Edit Room Button --}}
                                    <a href="{{ route('dashboard.room.edit', $room->id) }}" class="btn btn-sm btn-soft-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    
                                    {{-- Delete Room Button --}}
                                    <form action="{{ route('dashboard.room.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini? {{ $room->user ? 'Penyewa akan dipindahkan dari kamar.' : '' }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        
                        {{-- Modal untuk setiap kamar --}}
                        <div class="modal fade" id="imageModal{{ $room->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $room->id }}" aria-hidden="true">
                            <div class="modal-dialog image-modal-dialog">
                                <div class="modal-content image-modal-content">
                                    <div class="image-modal-wrapper">
                                        <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <img src="{{ $room->image ? asset('storage/' . $room->image) : asset('assets/images/rocket-img.png') }}" class="img-fluid rounded-3" alt="Full-size image for {{ $room->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="ri-door-closed-line fs-1 text-muted"></i>
                                <h5 class="mt-2">No rooms found.</h5>
                                <p class="text-muted">Get started by adding your first room.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($rooms->hasPages())
        <div class="card-footer bg-transparent">
            {{ $rooms->links('dashboard.admin.layouts.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    });
</script>
@endsection
