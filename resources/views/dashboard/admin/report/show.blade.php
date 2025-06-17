@extends('dashboard.admin.layouts.app')

@section('title', 'Kelola Laporan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Kolom Kiri: Detail Laporan & Form Respons -->
        <div class="col-lg-8">
            <!-- Detail Laporan dari Tenant -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Laporan dari {{ $report->user->name }}: {{ $report->title }}</h5>
                    <p class="text-muted mb-0">Dilaporkan pada: {{ $report->reported_at ? $report->reported_at->format('d M Y, H:i') : 'N/A' }}</p>
                </div>
                <div class="card-body">
                    <h6>Deskripsi Kendala:</h6>
                    <p>{{ $report->description }}</p>

                    @if(!empty($report->images))
                        <h6 class="mt-4">Bukti Lampiran:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($report->images as $image)
                                <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $image) }}" alt="lampiran" height="80" class="rounded object-fit-cover">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form untuk Memberi Respons -->
            <div class="card">
                 <div class="card-header">
                    <h5 class="card-title mb-0">Beri Tanggapan atau Update</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.report.response.store', $report->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="response_text" class="form-label">Teks Respons <span class="text-danger">*</span></label>
                            <textarea name="response_text" id="response_text" rows="4" class="form-control @error('response_text') is-invalid @enderror" placeholder="Tuliskan tanggapan Anda di sini..."></textarea>
                            @error('response_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="mb-3">
                            <label for="action_taken" class="form-label">Tindakan yang Diambil (Opsional)</label>
                            <input type="text" name="action_taken" class="form-control" placeholder="Contoh: Menjadwalkan teknisi untuk besok">
                        </div>
                        <button type="submit" class="btn btn-success">Kirim Respons</button>
                    </form>
                </div>
            </div>

            <!-- Menampilkan Respons yang Sudah Ada -->
            @foreach($report->responses->sortByDesc('created_at') as $response)
            <div class="card">
                <div class="card-header bg-light-subtle">
                    <h6 class="card-title mb-0">Respons dari: {{ $response->admin->name }}</h6>
                    <small class="text-muted">{{ $response->created_at->format('d M Y, H:i') }}</small>
                </div>
                <div class="card-body">
                    <p>{{ $response->response_text }}</p>
                    @if($response->action_taken)
                    <p class="mb-1"><small><strong>Tindakan:</strong> {{ $response->action_taken }}</small></p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Kolom Kanan: Aksi & Riwayat -->
        <div class="col-lg-4">
            <!-- Form Ubah Status -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ubah Status Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.report.updateStatus', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tampilan Status Saat Ini -->
                        <div class="mb-3">
                            <label class="form-label d-block">Status Saat Ini</label>
                            <span class="badge bg-{{$report->status_color}}">{{ $report->status_label }}</span>
                        </div>

                        <!-- Dropdown untuk Mengubah Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Ubah Status Ke</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="in_progress" {{ $report->status == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="completed" {{ $report->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <!-- Textarea untuk Alasan Perubahan -->
                        <div class="mb-3">
                            <label for="reason" class="form-label">Alasan Perubahan (Opsional)</label>
                            <textarea name="reason" id="reason" rows="3" class="form-control" placeholder="Contoh: Teknisi sudah dihubungi"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
                    </form>
                </div>
            </div>

            <!-- Riwayat Status -->
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
                                    <small class="text-muted">{{ $history->changed_at->diffForHumans() }} oleh {{ $history->changedBy->name ?? 'Sistem' }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const previewBadge = document.querySelector('#status-preview .badge');
    const previewText = document.getElementById('preview-text');

    const statusConfig = {
        'pending': {
            class: 'bg-warning',
            text: 'Menunggu'
        },
        'in_progress': {
            class: 'bg-info',
            text: 'Sedang Diproses'
        },
        'completed': {
            class: 'bg-success',
            text: 'Selesai'
        },
        'rejected': {
            class: 'bg-danger',
            text: 'Ditolak'
        }
    };

    statusSelect.addEventListener('change', function() {
        const selectedStatus = this.value;
        const config = statusConfig[selectedStatus];
        
        if (config) {
            // Reset semua class
            previewBadge.className = 'badge fs-6 px-3 py-2 ' + config.class;
            previewText.textContent = config.text;
        }
    });

    // Set initial preview
    const initialStatus = statusSelect.value;
    if (statusConfig[initialStatus]) {
        previewBadge.className = 'badge fs-6 px-3 py-2 ' + statusConfig[initialStatus].class;
        previewText.textContent = statusConfig[initialStatus].text;
    }
});
</script>
@endsection
