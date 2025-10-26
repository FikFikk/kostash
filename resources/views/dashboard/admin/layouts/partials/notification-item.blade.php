@php
    $data = $notification->data;
    $isUnread = !$notification->isRead();
    $icon = match ($notification->type) {
        'transaction' => 'ri-exchange-dollar-line bg-soft-success text-success',
        'report' => 'ri-file-text-line bg-soft-warning text-warning',
        'payment' => 'ri-secure-payment-line bg-soft-info text-info',
        default => 'ri-notification-line bg-soft-primary text-primary',
    };
@endphp

<div
    class="text-reset notification-item d-block dropdown-item position-relative {{ $isUnread ? 'unread-notification' : '' }}">
    <div class="d-flex">
        <div class="avatar-xs me-3">
            <span class="avatar-title {{ $icon }} rounded-circle fs-16">
                <i class="{{ explode(' ', $icon)[0] }}"></i>
            </span>
        </div>
        <div class="flex-grow-1">
            <h6 class="mt-0 mb-2 lh-base {{ $isUnread ? 'text-dark' : 'text-muted' }}">
                {{ $data['title'] ?? 'Notifikasi' }}
            </h6>
            <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                <span><i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}</span>
            </p>
        </div>
        @if ($isUnread)
            <div class="px-2">
                <span class="badge badge-soft-primary rounded-pill">Baru</span>
            </div>
        @endif
    </div>

    @if (!empty($data['url']) && $data['url'] !== '#')
        <a href="{{ $data['url'] }}" class="stretched-link"></a>
    @endif

    @if ($isUnread)
        <button type="button" class="btn btn-sm btn-ghost-secondary position-absolute top-0 end-0 mt-1 me-1"
            onclick="markAsRead('{{ $notification->id }}'); event.stopPropagation();" title="Tandai sudah dibaca">
            <i class="ri-check-line fs-12"></i>
        </button>
    @endif
</div>
