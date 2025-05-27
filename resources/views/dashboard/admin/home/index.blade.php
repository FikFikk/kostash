@extends('dashboard.admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1" id="greeting-text">Selamat datang!</h4>
                                <p class="text-muted mb-0">Here's what's happening with your store
                                    today.</p>
                            </div>
                            <!-- <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control border-0 dash-filter-picker shadow"
                                                    data-provider="flatpickr" data-range-date="true"
                                                    data-date-format="d M, Y"
                                                    data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                <div
                                                    class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-soft-success"><i
                                                    class="ri-add-circle-line align-middle me-1"></i>
                                                Add Product</button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button"
                                                class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i
                                                    class="ri-pulse-line"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p
                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Total Revenue</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="{{ $revenueGrowthPercent >= 0 ? 'text-success' : 'text-danger' }} float-right fs-14 mb-0">
                                            <i class="ri-arrow-{{ $revenueGrowthPercent >= 0 ? 'right-up' : 'right-down' }}-line fs-13 align-middle"></i>
                                            {{ $revenueGrowthPercent < 0 ? '-' : '+' }}{{ number_format(abs($revenueGrowthPercent), 2) }}%
                                        </h5>
                                        <small class="text-muted d-block">Monthly change</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rp <span
                                                class="counter-value" data-target="{{ $totalRevenue }}">0</span>
                                        </h4>
                                        <a href="" class="text-decoration-underline">View net
                                            earnings</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-success rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p
                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Gallery Photo</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end" style="visibility: hidden;">
                                        <h5 class="text-danger fs-14 mb-0">
                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                            -3.57 %
                                        </h5>
                                        <small class="text-muted d-block">Monthly orders change</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value" data-target="{{ $totalGalleryItems }}">0</span> 
                                                <small class="text-muted">photo</small>
                                            </h4>
                                        <a href="{{ route('dashboard.gallery.index') }}" class="text-decoration-underline">View all photo</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                            <i class="bx bx-photo-album text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p
                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Tenants</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="{{ $growthPercent >= 0 ? 'text-success' : 'text-danger' }} float-right fs-14 mb-0">
                                            <i class="ri-arrow-{{ $growthPercent >= 0 ? 'right-up' : 'right-down' }}-line fs-13 align-middle"></i>
                                            {{ $growthPercent < 0 ? '-' : '+' }}{{ number_format(abs($growthPercent), 2) }}%
                                        </h5>
                                        <small class="text-muted d-block">Monthly tenant growth</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value" data-target="{{ $totalTenants }}">0</span> 
                                                <small class="text-muted"> pengguna</small>
                                        </h4>
                                        <a href="{{ route('dashboard.user.index') }}" class="text-decoration-underline">See details</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-warning rounded fs-3">
                                            <i class="bx bx-user-circle text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p
                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Total Paid Bills</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end" style=" visibility: hidden;">
                                        <h5 class="text-muted fs-14 mb-0">
                                            +0.00 %
                                        </h5>
                                        <small class="text-muted d-block">Bills paid this month</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value" data-target="{{ $totalMeters }}">0</span> 
                                                <small class="text-muted">bill</small>
                                        </h4>
                                        <a href="" class="text-decoration-underline">Withdraw money</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                            <i class="bx bx-wallet text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card card-height-100 overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);">
                            <div class="card-header border-0 bg-transparent">
                                <h4 class="card-title mb-0 text-white fw-bold">Room Status</h4>
                            </div>

                            <div class="card-body pt-0">
                                <!-- Main Stats -->
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="p-3 rounded-3 bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-20">
                                            <div class="text-center">
                                                <div class="avatar-sm bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2">
                                                    <i class="ri-home-4-line text-white fs-16"></i>
                                                </div>
                                                <h3 class="mb-0 text-white fw-bold">{{ $roomsWithTenants }}</h3>
                                                <p class="text-white-50 mb-0 fs-13">Terisi</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded-3 bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-20">
                                            <div class="text-center">
                                                <div class="avatar-sm bg-info bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2">
                                                    <i class="ri-home-line text-white fs-16"></i>
                                                </div>
                                                <h3 class="mb-0 text-white fw-bold">{{ $roomsWithoutTenants }}</h3>
                                                <p class="text-white-50 mb-0 fs-13">Kosong</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Donut Chart -->
                                <div class="bg-white bg-opacity-10 rounded-3 p-3 backdrop-blur border border-white border-opacity-20">
                                    <div id="room-occupancy-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                    .backdrop-blur {
                        backdrop-filter: blur(10px);
                        -webkit-backdrop-filter: blur(10px);
                    }

                    .card-height-100:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 25px 50px rgba(102, 126, 234, 0.3) !important;
                        transition: all 0.3s ease;
                    }

                    @keyframes float {
                        0%, 100% { transform: translateY(0px); }
                        50% { transform: translateY(-5px); }
                    }

                    .avatar-sm {
                        animation: float 2s ease-in-out infinite;
                    }
                    </style>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-info btn-sm">
                                        <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                    </button>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table
                                        class="table table-borderless table-centered align-middle table-nowrap mb-2 mt-2">
                                        <thead class="text-muted table-light mt-1">
                                            <tr>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Lebar</th>
                                                <th scope="col">Panjang</th>
                                                <th scope="col">Deskripsi</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Fasilitas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rooms as $room)
                                            <tr>
                                                <td>
                                                    <a href=""
                                                        class="fw-medium link-primary">{{ $room->name }}</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{ asset('storage/' . $room->image) }}"
                                                                alt=""
                                                                class="avatar-xs rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1"></div>
                                                    </div>
                                                </td>
                                                <td>{{ $room->length }}</td>
                                                <td>
                                                    {{ $room->width }}  
                                                </td>
                                                <td>{{ $room->description }}</td>
                                                <td>
                                                    <span class="badge badge-soft-success">{{ $room->status }}</span>
                                                </td>
                                                @php
                                                    $facilities = collect(json_decode($room->facilities ?? '[]'))
                                                        ->flatMap(fn($f) => explode(',', $f))
                                                        ->map(fn($f) => trim($f))
                                                        ->filter()
                                                        ->values();
                                                @endphp

                                                <td>
                                                    <button 
                                                        type="button"
                                                        class="btn btn-soft-info btn-sm"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="{{ $facilities->join(', ') }}">
                                                        {{ $facilities->count() }} Fasilitas
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->
                </div> 

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Top Bills</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#"
                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="text-muted">Report<i
                                                    class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Download Report</a>
                                            <a class="dropdown-item" href="#">Export</a>
                                            <a class="dropdown-item" href="#">Import</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tenant Info</th>
                                                <th>Consumption</th>
                                                <th>Period</th>
                                                <th>Total Bill</th>
                                                <th>Rank/Change</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topTenants as $index => $bill)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            @switch($index)
                                                                @case(0)
                                                                    <div class="avatar-sm p-2" style="background: linear-gradient(45deg, #FFD700, #FFA500); border-radius: 8px;">
                                                                        <i class="ri-medal-fill text-white fs-16"></i>
                                                                    </div>
                                                                    @break
                                                                @case(1)
                                                                    <div class="avatar-sm p-2" style="background: linear-gradient(45deg, #C0C0C0, #808080); border-radius: 8px;">
                                                                        <i class="ri-medal-fill text-white fs-16"></i>
                                                                    </div>
                                                                    @break
                                                                @case(2)
                                                                    <div class="avatar-sm p-2" style="background: linear-gradient(45deg, #CD7F32, #8B4513); border-radius: 8px;">
                                                                        <i class="ri-medal-fill text-white fs-16"></i>
                                                                    </div>
                                                                    @break
                                                                @default
                                                                    <div class="avatar-sm p-2 bg-primary rounded d-flex align-items-center justify-content-center text-white fw-bold">
                                                                        {{ strtoupper(substr($bill->user->name ?? 'UN', 0, 2)) }}
                                                                    </div>
                                                            @endswitch
                                                        </div>
                                                        <div>
                                                            <h5 class="fs-14 my-1 fw-medium">
                                                                <a href="#" class="text-reset">{{ $bill->user->name ?? 'Unknown User' }}</a>
                                                            </h5>
                                                            <span class="text-muted">
                                                                {{ $bill->room->name ?? 'Room N/A' }} - {{ $bill->room->floor ?? 'Floor N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <small class="text-muted mb-1">
                                                            <i class="ri-drop-line text-primary me-1"></i>
                                                            Water: <strong>{{ $bill->total_water ?? 0 }} m³</strong>
                                                            @if($bill->water_charge ?? 0 > 0)
                                                                <span class="text-muted">(Rp {{ number_format($bill->water_charge, 0, ',', '.') }})</span>
                                                            @endif
                                                        </small>
                                                        <small class="text-muted">
                                                            <i class="ri-flashlight-line text-warning me-1"></i>
                                                            Electric: <strong>{{ $bill->total_electric ?? 0 }} kWh</strong>
                                                            @if($bill->electric_charge ?? 0 > 0)
                                                                <span class="text-muted">(Rp {{ number_format($bill->electric_charge, 0, ',', '.') }})</span>
                                                            @endif
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        @if($bill->period)
                                                            {{ \Carbon\Carbon::parse($bill->period)->format('M Y') }}
                                                        @else
                                                            {{ now()->format('M Y') }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <h6 class="text-success mb-0 fw-bold">
                                                        Rp {{ number_format($bill->total_amount ?? 0, 0, ',', '.') }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <span class="badge bg-primary-subtle text-primary">
                                                            Rank #{{ $index + 1 }}
                                                        </span>
                                                        @if(isset($bill->percentage_change) && $bill->percentage_change !== null)
                                                            <div class="mt-1">
                                                                <small class="text-{{ $bill->percentage_change >= 0 ? 'danger' : 'success' }}">
                                                                    <i class="ri-arrow-{{ $bill->percentage_change >= 0 ? 'up' : 'down' }}-line me-1"></i>
                                                                    {{ abs($bill->percentage_change) }}%
                                                                </small>
                                                            </div>
                                                        @else
                                                            <div class="mt-1">
                                                                <small class="text-muted">No change</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="ri-inbox-line fs-24 d-block mb-2"></i>
                                                        <p class="mb-1">No tenant billing data found</p>
                                                        <small>Make sure there are meter readings with billing information</small>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->
                    <div class="col-xl-4">
                        <!-- card -->
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Sales by Locations</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                        Export Report
                                    </button>
                                </div>
                            </div><!-- end card header -->

                            <!-- card body -->
                            <div class="card-body">

                                <div id="sales-by-locations"
                                    data-colors='["--vz-light", "--vz-success", "--vz-primary"]'
                                    style="height: 269px" dir="ltr"></div>

                                <div class="px-2 py-2 mt-1">
                                    <p class="mb-1">Canada <span class="float-end">75%</span></p>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar progress-bar-striped bg-primary"
                                            role="progressbar" style="width: 75%" aria-valuenow="75"
                                            aria-valuemin="0" aria-valuemax="75">
                                        </div>
                                    </div>

                                    <p class="mt-3 mb-1">Greenland <span class="float-end">47%</span>
                                    </p>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar progress-bar-striped bg-primary"
                                            role="progressbar" style="width: 47%" aria-valuenow="47"
                                            aria-valuemin="0" aria-valuemax="47">
                                        </div>
                                    </div>

                                    <p class="mt-3 mb-1">Russia <span class="float-end">82%</span></p>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar progress-bar-striped bg-primary"
                                            role="progressbar" style="width: 82%" aria-valuenow="82"
                                            aria-valuemin="0" aria-valuemax="82">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div> <!-- end row-->

            </div> <!-- end .h-100-->

        </div> <!-- end col -->

        <!-- <div class="col-auto layout-rightside-col">
            <div class="overlay"></div>
            <div class="layout-rightside">
                <div class="card h-100 rounded-0">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">Recent Activity</h6>
                        </div>
                        <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                            <div class="acitivity-timeline acitivity-main">
                                <div class="acitivity-item d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div
                                            class="avatar-title bg-soft-success text-success rounded-circle">
                                            <i class="ri-shopping-cart-2-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Purchase by James Price</h6>
                                        <p class="text-muted mb-1">Product noise evolve smartwatch </p>
                                        <small class="mb-0 text-muted">02:14 PM Today</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div
                                            class="avatar-title bg-soft-danger text-danger rounded-circle">
                                            <i class="ri-stack-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Added new <span
                                                class="fw-semibold">style collection</span></h6>
                                        <p class="text-muted mb-1">By Nesta Technologies</p>
                                        <div class="d-inline-flex gap-2 border border-dashed p-2 mb-2">
                                            <a href="apps-ecommerce-product-details.html"
                                                class="bg-light rounded p-1">
                                                <img src="{{ asset('assets/dashboard/images/products/img-8.png') }}" alt=""
                                                    class="img-fluid d-block" />
                                            </a>
                                            <a href="apps-ecommerce-product-details.html"
                                                class="bg-light rounded p-1">
                                                <img src="{{ asset('assets/dashboard/images/products/img-2.png') }}" alt=""
                                                    class="img-fluid d-block" />
                                            </a>
                                            <a href="apps-ecommerce-product-details.html"
                                                class="bg-light rounded p-1">
                                                <img src="{{ asset('assets/dashboard/images/products/img-10.png') }}" alt=""
                                                    class="img-fluid d-block" />
                                            </a>
                                        </div>
                                        <p class="mb-0 text-muted"><small>9:47 PM Yesterday</small></p>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('assets/dashboard/images/users/avatar-2.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Natasha Carey have liked the products
                                        </h6>
                                        <p class="text-muted mb-1">Allow users to like products in your
                                            WooCommerce store.</p>
                                        <small class="mb-0 text-muted">25 Dec, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-secondary">
                                                <i class="mdi mdi-sale fs-14"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Today offers by <a
                                                href="apps-ecommerce-seller-details.html"
                                                class="link-secondary">Digitech Galaxy</a></h6>
                                        <p class="text-muted mb-2">Offer is valid on orders of Rs.500 Or
                                            above for selected products only.</p>
                                        <small class="mb-0 text-muted">12 Dec, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div
                                                class="avatar-title rounded-circle bg-soft-danger text-danger">
                                                <i class="ri-bookmark-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Favoried Product</h6>
                                        <p class="text-muted mb-2">Esther James have favorited product.
                                        </p>
                                        <small class="mb-0 text-muted">25 Nov, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-secondary">
                                                <i class="mdi mdi-sale fs-14"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Flash sale starting <span
                                                class="text-primary">Tomorrow.</span></h6>
                                        <p class="text-muted mb-0">Flash sale by <a
                                                href="javascript:void(0);"
                                                class="link-secondary fw-medium">Zoetic Fashion</a></p>
                                        <small class="mb-0 text-muted">22 Oct, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div
                                                class="avatar-title rounded-circle bg-soft-info text-info">
                                                <i class="ri-line-chart-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Monthly sales report</h6>
                                        <p class="text-muted mb-2"><span class="text-danger">2 days
                                                left</span> notification to submit the monthly sales
                                            report. <a href="javascript:void(0);"
                                                class="link-warning text-decoration-underline">Reports
                                                Builder</a></p>
                                        <small class="mb-0 text-muted">15 Oct</small>
                                    </div>
                                </div>
                                <div class="acitivity-item d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('assets/dashboard/images/users/avatar-3.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Frank Hook Commented</h6>
                                        <p class="text-muted mb-2 fst-italic">" A product that has
                                            reviews is more likable to be sold than a product. "</p>
                                        <small class="mb-0 text-muted">26 Aug, 2021</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 mt-2">
                            <h6 class="text-muted mb-3 text-uppercase fw-semibold">Top 10 Categories
                            </h6>

                            <ol class="ps-3 text-muted">
                                <li class="py-1">
                                    <a href="#" class="text-muted">Mobile & Accessories <span
                                            class="float-end">(10,294)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Desktop <span
                                            class="float-end">(6,256)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Electronics <span
                                            class="float-end">(3,479)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Home & Furniture <span
                                            class="float-end">(2,275)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Grocery <span
                                            class="float-end">(1,950)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Fashion <span
                                            class="float-end">(1,582)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Appliances <span
                                            class="float-end">(1,037)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Beauty, Toys & More <span
                                            class="float-end">(924)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Food & Drinks <span
                                            class="float-end">(701)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Toys & Games <span
                                            class="float-end">(239)</span></a>
                                </li>
                            </ol>
                            <div class="mt-3 text-center">
                                <a href="javascript:void(0);"
                                    class="text-muted text-decoration-underline">View all Categories</a>
                            </div>
                        </div>
                        <div class="p-3">
                            <h6 class="text-muted mb-3 text-uppercase fw-semibold">Products Reviews</h6>
                            
                            <div class="swiper vertical-swiper" style="height: 250px;">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="card border border-dashed shadow-none">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-sm">
                                                        <div class="avatar-title bg-light rounded">
                                                            <img src="{{ asset('assets/dashboard/images/companies/img-1.png') }}"
                                                                alt="" height="30">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div>
                                                            <p
                                                                class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                " Great product and looks great, lots of
                                                                features. "</p>
                                                            <div
                                                                class="fs-11 align-middle text-warning">
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="text-end mb-0 text-muted">
                                                            - by <cite title="Source Title">Force
                                                                Medicines</cite>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card border border-dashed shadow-none">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ asset('assets/dashboard/images/users/avatar-3.jpg') }}"
                                                            alt="" class="avatar-sm rounded">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div>
                                                            <p
                                                                class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                " Amazing template, very easy to
                                                                understand and manipulate. "</p>
                                                            <div
                                                                class="fs-11 align-middle text-warning">
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-half-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="text-end mb-0 text-muted">
                                                            - by <cite title="Source Title">Henry
                                                                Baird</cite>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card border border-dashed shadow-none">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-sm">
                                                        <div class="avatar-title bg-light rounded">
                                                            <img src="{{ asset('assets/dashboard/images/companies/img-8.png') }}"
                                                                alt="" height="30">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div>
                                                            <p
                                                                class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                "Very beautiful product and Very helpful
                                                                customer service."</p>
                                                            <div
                                                                class="fs-11 align-middle text-warning">
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-line"></i>
                                                                <i class="ri-star-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="text-end mb-0 text-muted">
                                                            - by <cite title="Source Title">Zoetic
                                                                Fashion</cite>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card border border-dashed shadow-none">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ asset('assets/dashboard/images/users/avatar-2.jpg') }}"
                                                            alt="" class="avatar-sm rounded">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div>
                                                            <p
                                                                class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                " The product is very beautiful. I like
                                                                it. "</p>
                                                            <div
                                                                class="fs-11 align-middle text-warning">
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-fill"></i>
                                                                <i class="ri-star-half-fill"></i>
                                                                <i class="ri-star-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="text-end mb-0 text-muted">
                                                            - by <cite title="Source Title">Nancy
                                                                Martino</cite>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3">
                            <h6 class="text-muted mb-3 text-uppercase fw-semibold">Customer Reviews</h6>
                            <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="fs-16 align-middle text-warning">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-half-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h6 class="mb-0">4.5 out of 5</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-muted">Total <span class="fw-medium">5.50k</span>
                                    reviews</div>
                            </div>

                            <div class="mt-3">
                                <div class="row align-items-center g-2">
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0">5 star</h6>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="progress animated-progress progress-sm">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 50.16%" aria-valuenow="50.16"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0 text-muted">2758</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center g-2">
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0">4 star</h6>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="progress animated-progress progress-sm">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 29.32%" aria-valuenow="29.32"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0 text-muted">1063</h6>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row align-items-center g-2">
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0">3 star</h6>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="progress animated-progress progress-sm">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 18.12%" aria-valuenow="18.12"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0 text-muted">997</h6>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row align-items-center g-2">
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0">2 star</h6>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="progress animated-progress progress-sm">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 4.98%" aria-valuenow="4.98"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0 text-muted">227</h6>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row align-items-center g-2">
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0">1 star</h6>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="progress animated-progress progress-sm">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: 7.42%" aria-valuenow="7.42"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="p-1">
                                            <h6 class="mb-0 text-muted">408</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card sidebar-alert bg-light border-0 text-center mx-4 mb-0 mt-3">
                            <div class="card-body">
                                <img src="{{ asset('assets/dashboard/images/giftbox.png') }}" alt="">
                                <div class="mt-4">
                                    <h5>Invite New Seller</h5>
                                    <p class="text-muted lh-base">Refer a new seller to us and earn $100
                                        per refer.</p>
                                    <button type="button"
                                        class="btn btn-primary btn-label rounded-pill"><i
                                            class="ri-mail-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                                        Invite Now</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 
            </div> 

        </div>  -->
    </div>

</div>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Waktu berdasarkan GMT+7
        const now = new Date();
        const gmtOffset = 7 * 60; // dalam menit
        const localTime = new Date(now.getTime() + (gmtOffset + now.getTimezoneOffset()) * 60000);
        const hour = localTime.getHours();

        let greeting = "Selamat Pagi";
        if (hour >= 11 && hour < 15) {
            greeting = "Selamat Siang";
        } else if (hour >= 15 && hour < 18) {
            greeting = "Selamat Sore";
        } else if (hour >= 18 || hour < 4) {
            greeting = "Selamat Malam";
        }

        // Nama user dari backend (bisa null)
        const userName = @json(auth()->user()->name ?? 'Tuan');

        // Ubah isi elemen sapaan
        document.getElementById("greeting-text").innerText = `${greeting}, ${userName}!`;
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var roomOccupancyOptions = {
        series: [{{ $roomsWithTenants }}, {{ $roomsWithoutTenants }}],
        chart: {
            type: 'donut',
            height: 220
        },
        labels: ['Terisi', 'Kosong'],
        colors: ['#10b981', '#06b6d4'],
        dataLabels: {
            enabled: false
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '12px',
                            color: 'rgb(255, 255, 255)',
                            formatter: function () {
                                return '{{ $totalRooms }}'
                            }
                        }
                    }
                }
            }
        },
        legend: {
            show: true,
            position: 'bottom',
            labels: {
                colors: ['rgb(255, 255, 255)']
            }
        },
        stroke: {
            width: 0
        }
    };

    var roomChart = new ApexCharts(document.querySelector("#room-occupancy-chart"), roomOccupancyOptions);
    roomChart.render();
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
