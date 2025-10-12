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
                        {{ $data['title'] ?? 'Notification' }}
                        @if ($isUnread)
                            <span class="badge badge-soft-primary ms-2">New</span>
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
                                    <button type="submit" class="btn btn-sm btn-soft-success" title="Mark as read">
                                        <i class="ri-check-line"></i>
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this notification?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @php
                        // Jika tipe report dan url mengandung /tenant/report, ganti ke dashboard.report.show
                        $url = $data['url'] ?? null;
                        if (
                            $notification->type === 'report' &&
                            !empty($data['report_id']) &&
                            is_string($url) &&
                            str_contains($url, '/tenant/report')
                        ) {
                            $url = route('dashboard.report.show', $data['report_id']);
                        }
                    @endphp
                    @if (!empty($url) && $url !== '#')
                        <div class="mt-2">
                            <a href="{{ $url }}" class="btn btn-sm btn-outline-primary">
                                <i class="ri-external-link-line me-1"></i>View Details
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
        <h5>No notifications found</h5>
        <p class="text-muted">You're all caught up!</p>
    </div>
@endif
