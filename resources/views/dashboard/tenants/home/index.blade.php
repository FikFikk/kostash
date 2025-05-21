@extends('dashboard.tenants.layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard Penyewa</h3>

    <div>
        <h5>{{ auth()->user()->name }}</h5>
        <p class="mb-0">Kamar: {{ $room->name ?? '-' }}</p>
        <p class="mb-0 text-muted">Tanggal Masuk: {{ $user->date_entry ? \Carbon\Carbon::parse($user->date_entry)->translatedFormat('d F Y') : '-' }}</p>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tenant.home') }}">
                <div class="row g-3 align-items-end">
                    <!-- Pilihan Bulan dan Tahun -->
                    <div class="col-md-6">
                        <label for="month" class="form-label">Periode Tagihan</label>
                        <div class="input-group">
                            <select name="month" id="month" class="form-select">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="year" id="year" class="form-select">
                                @foreach($availableYears as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Tampilkan -->
                    <div class="col-md-3 mt-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-search-line me-1"></i> Tampilkan
                        </button>
                    </div>

                    <!-- Tombol Export PDF -->
                    <div class="col-md-3 mt-md-4">
                        <a href="{{ route('tenant.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-outline-danger w-100">
                            <i class="ri-file-pdf-line me-1"></i> Export PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Informasi Tagihan</strong>
        </div>
        <div class="card-body">
            <p><strong> {{ $room->name ?? '-' }} </strong></p>
            @php
                use Carbon\Carbon;

                $current = Carbon::createFromDate($year, $month, 1);
                $prev = $current->copy()->subMonth();

                $startMonth = $prev->locale('id')->translatedFormat('F');
                $endMonth = $current->locale('id')->translatedFormat('F');
            @endphp

            <p><strong>Periode:</strong> {{ $startMonth }} → {{ $endMonth }} {{ $year }}</p>

            @if($meter)
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        Pemakaian Listrik:
                        <strong>{{ $electricUsage }} kWh</strong>
                        <br>
                        <small class="text-muted">
                            ({{ $meter->electric_meter_start ?? 0 }} → {{ $meter->electric_meter_end ?? 0 }} kWh)
                        </small>
                    </li>
                    <li class="list-group-item">
                        Pemakaian Air:
                        <strong>{{ $waterUsage }} m³</strong>
                        <br>
                        <small class="text-muted">
                            ({{ $meter->water_meter_start ?? 0 }} → {{ $meter->water_meter_end ?? 0 }} m³)
                        </small>
                    </li>
                    <li class="list-group-item">
                        Biaya Tetap:
                        <strong>Rp{{ number_format($global->monthly_room_price, 0, ',', '.') }}</strong>
                    </li>
                    <li class="list-group-item">
                        Total Tagihan:
                        <strong class="text-success">Rp{{ number_format($totalBill, 0, ',', '.') }}</strong>
                    </li>
                </ul>
            @else
                <div class="alert alert-warning mb-0">Belum ada data meteran untuk periode ini.</div>
            @endif

        </div>
    </div>

</div>
@endsection
