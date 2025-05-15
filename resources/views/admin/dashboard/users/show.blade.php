@extends('admin.dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Detail Pengguna</h4>
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard.user.index') }}" class="btn btn-secondary btn-label">
                    <i class="ri-arrow-go-back-line label-icon align-middle fs-16 me-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nama:</strong>
                    <p>{{ $user->name }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong>
                    <p>{{ $user->email }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Phone:</strong>
                    <p>{{ $user->phone ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>NIK:</strong>
                    <p>{{ $user->nik ?? '-' }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Alamat:</strong>
                    <p>{{ $user->address ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Room:</strong>
                    <p>{{ $user->room ? $user->room->name : '-' }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Tanggal Masuk:</strong>
                    <p>{{ $user->date_entry ? \Carbon\Carbon::parse($user->date_entry)->format('Y-m-d') : '-' }}</p>
                </div>
                <div class="col-md-3">
                    <strong>Role:</strong>
                    <p class="badge bg-primary">{{ $user->role }}</p>
                </div>
                <div class="col-md-3">
                    <strong>Status:</strong>
                    <p class="badge bg-{{ $user->status == 'aktif' ? 'success' : 'danger' }}">
                        {{ ucfirst($user->status) }}
                    </p>
                </div>
            </div>

            <div class="mb-3">
                <strong>Catatan:</strong>
                <p>{{ $user->catatan ?? '-' }}</p>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-warning">
                    <i class="ri-edit-2-line me-1"></i> Edit
                </a>
                <form action="{{ route('dashboard.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ri-delete-bin-line me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
