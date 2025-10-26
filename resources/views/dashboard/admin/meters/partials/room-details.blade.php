@php
    $totalBillForYear = $readings->sum('total_bill');
@endphp

<div class="mb-4">
    <h4 class="text-gradient mb-2">
        <i class="ri-home-4-line me-2"></i>{{ $room->name }}
        <small class="text-muted d-inline-block ms-2">{{ $year }}</small>
    </h4>
    <p class="text-muted mb-0">Rincian pembacaan meter dan rangkuman untuk <strong>{{ $room->name }}</strong> pada
        tahun {{ $year }}.</p>
</div>

@if ($readings->count() > 0)
    {{-- Summary Metrics Section --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100"
                style="border-left: 5px solid #3b82f6 !important; background-color: rgba(59, 130, 246, 0.05);">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <i class="ri-water-flash-line text-info fs-2 mb-2"></i>
                    <h5 class="mb-0 text-dark fw-bold">{{ number_format($readings->sum('total_water')) }} m³</h5>
                    <small class="text-muted">Total Pemakaian Air</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100"
                style="border-left: 5px solid #f59e0b !important; background-color: rgba(245, 158, 11, 0.05);">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <i class="ri-flashlight-line text-warning fs-2 mb-2"></i>
                    <h5 class="mb-0 text-dark fw-bold">{{ number_format($readings->sum('total_electric')) }} kWh</h5>
                    <small class="text-muted">Total Pemakaian Listrik</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100"
                style="border-left: 5px solid #10b981 !important; background-color: rgba(16, 185, 129, 0.05);">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <i class="ri-money-dollar-circle-line text-success fs-2 mb-2"></i>
                    <h5 class="mb-0 text-dark fw-bold">Rp{{ number_format($totalBillForYear, 0, ',', '.') }}</h5>
                    <small class="text-muted">Total Tagihan Tahun</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Readings List --}}
    <div class="card content-card shadow-sm mb-4">
        <div class="card-header bg-gradient-light-subtle d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-primary fw-bold"><i class="ri-list-check me-2"></i>Pembacaan Bulanan</h5>
            <span class="badge bg-secondary-subtle text-secondary">{{ $readings->count() }} Entri</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Periode</th>
                            <th class="text-center py-3">Air (m³)</th>
                            <th class="text-center py-3">Listrik (kWh)</th>
                            <th class="text-center py-3">Tagihan</th>
                            <th class="text-center py-3">Dibuat</th>
                            <th class="text-end py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($readings as $reading)
                            <tr class="align-middle">
                                <td class="px-4">
                                    <span
                                        class="fw-medium">{{ \Carbon\Carbon::parse($reading->period)->format('F Y') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <span
                                            class="badge bg-info-subtle text-info fw-bold mb-1">{{ number_format($reading->total_water) }}</span>
                                        <small class="text-muted">({{ $reading->water_meter_start }} &rarr;
                                            {{ $reading->water_meter_end }})</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <span
                                            class="badge bg-warning-subtle text-warning fw-bold mb-1">{{ number_format($reading->total_electric) }}</span>
                                        <small class="text-muted">({{ $reading->electric_meter_start }} &rarr;
                                            {{ $reading->electric_meter_end }})</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($reading->total_bill)
                                        <span
                                            class="badge bg-success-subtle text-success fw-bold">Rp{{ number_format($reading->total_bill, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">{{ $reading->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Tombol "Lihat Detail" --}}
                                        <button type="button" class="btn btn-sm btn-outline-info"
                                            onclick="window.viewMeterDetail('{{ $reading->id }}')"
                                            title="Lihat Detail Pembacaan">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        {{-- End Tombol --}}

                                        <a href="{{ route('dashboard.meter.edit', $reading->id) }}"
                                            class="btn btn-sm btn-outline-warning" title="Ubah Pembacaan">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        <form action="{{ route('dashboard.meter.destroy', $reading->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembacaan meter ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Hapus Pencatatan">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5 border rounded-lg bg-light-subtle">
        <i class="ri-file-list-line fs-1 text-muted mb-3 d-block"></i>
        <h5 class="text-muted mb-2">Tidak ada pencatatan untuk {{ $room->name }} di tahun {{ $year }}</h5>
        <p class="text-muted mb-3">Mulai dengan menambahkan pencatatan meter untuk kamar ini.</p>
        <a href="{{ route('dashboard.meter.create', ['room' => $room->id]) }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Tambah Pencatatan Baru
        </a>
    </div>
@endif

{{-- Optional: Add back-to-list button or direct links --}}
<div class="text-center mt-4">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <i class="ri-arrow-left-line me-1"></i> Kembali ke Daftar Pencatatan
    </button>
</div>
