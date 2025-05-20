@extends('dashboard.admin.layouts.app')

@section('title', 'Global')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                    <h4 class="mb-0 text-white"><i class="ri-settings-3-line me-2 card-title"></i>Global Setting</h4>
                    <a href="{{ route('dashboard.global.edit', $global->id) }}" class="btn btn-light btn-sm">
                        <i class="ri-edit-line me-1"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted"><i class="ri-home-8-line me-2 text-primary"></i>Harga Kos Per-Bulan Room Price</h6>
                        <p class="fs-5 fw-semibold">Rp {{ number_format($global->monthly_room_price) }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted"><i class="ri-water-flash-line me-2 text-info"></i>Harga Air Per-Kubik</h6>
                        <p class="fs-5 fw-semibold">Rp {{ number_format($global->water_price) }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted"><i class="ri-flashlight-line me-2 text-warning"></i>Harga Listrik Per-Kwh</h6>
                        <p class="fs-5 fw-semibold">Rp {{ number_format($global->electric_price) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
