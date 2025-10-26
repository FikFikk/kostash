@if ($notifications->count() > 0)
    <div class="notification-list">
        @foreach ($notifications as $notification)
            @php
                $data = $notification->data;
                if (is_string($data)) {
                    $data = json_decode($data, true) ?: [];
                }
                $isUnread = !$notification->isRead();
                $icon = match ($notification->type) {
                    'transaction' => 'ri-exchange-dollar-line bg-soft-success text-success',
                    'report' => 'ri-file-text-line bg-soft-warning text-warning',
                    'payment' => 'ri-secure-payment-line bg-soft-info text-info',
                    default => 'ri-notification-line bg-soft-primary text-primary',
                };
            @endphp

            <div
                class="notification-item d-flex align-items-start p-3 border-bottom {{ $isUnread ? 'bg-soft-primary' : '' }}">
                <div class="flex-shrink-0 me-3">
                    <div class="avatar-xs">
                        <div class="avatar-title {{ $icon }} rounded-circle fs-16">
                            <i class="{{ explode(' ', $icon)[0] }}"></i>
                        </div>
                    </div>
                </div>

                <div class="flex-grow-1">
                    <h6 class="mb-2 {{ $isUnread ? 'fw-semibold' : 'text-muted' }}">
                        {{ $data['title'] ?? 'Notifikasi' }}
                        @if ($isUnread)
                            <span class="badge badge-soft-primary ms-2">Baru</span>
                        @endif
                    </h6>

                    <p class="text-muted mb-2">{{ $data['message'] ?? '' }}</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="ri-time-line me-1"></i>{{ $notification->created_at->diffForHumans() }}
                        </small>

                        <div class="d-flex gap-2">
                            @if ($isUnread)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-soft-success" title="Tandai dibaca">
                                        <i class="ri-check-line"></i>
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if (!empty($data['url']) && $data['url'] !== '#')
                        <div class="mt-2">
                            <a href="{{ $data['url'] }}" class="btn btn-sm btn-outline-primary">
                                <i class="ri-external-link-line me-1"></i>Lihat Detail
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center p-5">
        <div class="avatar-lg mx-auto mb-3">
            <div class="avatar-title bg-soft-info text-info rounded-circle">
                <i class="ri-notification-off-line fs-24"></i>
            </div>
        </div>
        <h5>Tidak ada notifikasi</h5>
        <p class="text-muted">Semua bersih!</p>
    </div>
@endif
