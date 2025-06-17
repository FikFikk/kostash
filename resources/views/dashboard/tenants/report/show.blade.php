@extends('dashboard.tenants.layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Laporan Anda: {{ $report->title }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ $report->reported_at->format('d M Y') }}</p>
                    <p>{{ $report->description }}</p>

                    @if(!empty($report->images))
                        <h6 class="mt-4">Bukti Lampiran:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($report->images as $image)
                                <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $image) }}" alt="lampiran" class="avatar-lg rounded object-fit-cover">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @foreach($report->responses as $response)
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">Respons dari Admin: {{ $response->admin->name }}</h6>
                    <small class="text-muted">{{ $response->created_at->format('d M Y') }}</small>
                </div>
                <div class="card-body">
                    <p><strong>Pesan:</strong><br>{{ $response->response_text }}</p>
                    @if($response->action_taken)
                    <p class="mb-1"><strong>Tindakan yang Diambil:</strong><br>{{ $response->action_taken }}</p>
                    @endif
                     @if($response->notes)
                    <p class="mb-1"><strong>Catatan Tambahan:</strong><br>{{ $response->notes }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Status
                            <span class="badge bg-{{ $report->status_color }} fs-12">{{ $report->status_label }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Prioritas
                            <span class="badge bg-{{ $report->priority_color }} fs-12">{{ $report->priority_label }}</span>
                        </li>
                         <li class="list-group-item">
                            <div class="d-flex justify-content-between"><span>ID Laporan</span> <span>#{{ substr($report->id, 0, 8) }}</span></div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between"><span>Kategori</span> <span>{{ $report->category_label }}</span></div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between"><span>Kamar</span> <span>{{ $report->room->name }}</span></div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Riwayat Status</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach($report->statusHistory->sortByDesc('changed_at') as $history)
                            <li class="d-flex gap-3 pb-3">
                                <div class="flex-shrink-0">
                                    <i class="ri-checkbox-circle-fill text-primary fs-16"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $history->new_status_label }}</h6>
                                    <p class="text-muted mb-0">
                                        @if($history->old_status)
                                            Berubah dari <strong>{{ $history->old_status_label }}</strong>.
                                        @else
                                            Laporan dibuat.
                                        @endif
                                    </p>
                                    <small class="text-muted">{{ $history->changed_at->diffForHumans() }} oleh {{ $history->changedBy->name }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
                <a href="{{ route('tenant.report.index') }}" class="btn btn-light w-100"><i class="ri-arrow-left-s-line me-1"></i> Kembali ke Daftar</a>
                @if($report->status === 'pending')
                    <form action="{{ route('tenant.report.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan laporan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ri-delete-bin-line me-1"></i> Batalkan Laporan
                        </button>
                    </form>
                @endif
        </div>
    </div>
</div>
@endsection
