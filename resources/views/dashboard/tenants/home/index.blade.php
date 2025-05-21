@extends('dashboard.tenants.layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard Penyewa</h3>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tenant.home') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="month" class="form-label">Bulan</label>
                    <select name="month" id="month" class="form-select">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label">Tahun</label>
                    <select name="year" id="year" class="form-select">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
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
