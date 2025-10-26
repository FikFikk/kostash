@extends('dashboard.admin.layouts.app')

@section('title', 'Visit Logs')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Visit Logs</h4>
                <form class="d-flex" method="GET" action="{{ route('dashboard.visits.index') }}">
                    <input type="search" name="q" class="form-control form-control-sm me-2"
                        placeholder="Search IP, URL or UA" value="{{ request('q') }}">
                    <select name="per_page" class="form-select form-select-sm me-2" style="width:90px;">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <button class="btn btn-sm btn-primary">Filter</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">Visit Logs</h5>
                                <small class="text-muted">Daftar pengunjung & bot. Label membantu admin memahami kondisi —
                                    mis. 'Robot / Bot', 'Bahasa tidak diketahui', atau 'Sering dikunjungi'.</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger me-1">Bot</span>
                                <span class="badge bg-warning text-dark me-1">Bahasa tidak diketahui</span>
                                <span class="badge bg-info text-dark">Sering dikunjungi</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($visits as $visit)
                                @php
                                    $isSuspicious = empty($visit->accept_language) || ($ipCounts[$visit->ip] ?? 0) > 3;
                                    $label = $labels[$visit->id] ?? null;
                                @endphp
                                <li
                                    class="list-group-item d-flex align-items-center justify-content-between py-2 {{ $isSuspicious ? 'border-danger bg-opacity-10' : '' }}">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center"
                                                style="width:44px;height:44px;">
                                                @if ($label && strpos($label['text'], 'bot') !== false)
                                                    <i class="ri-alert-line text-danger fs-18"></i>
                                                @elseif($label && strpos($label['text'], 'unknown') !== false)
                                                    <i class="ri-question-line text-warning fs-18"></i>
                                                @elseif($label && strpos($label['text'], 'frequent') !== false)
                                                    <i class="ri-repeat-line text-info fs-18"></i>
                                                @else
                                                    <i class="ri-global-line text-secondary fs-18"></i>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <div class="fw-semibold mb-1">
                                                <span>{{ $visit->ip }}</span>
                                                @if (($ipCounts[$visit->ip] ?? 0) > 1)
                                                    <span
                                                        class="badge bg-secondary ms-2">x{{ $ipCounts[$visit->ip] }}</span>
                                                @endif
                                            </div>
                                            <div class="small text-muted"
                                                style="max-width:560px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                                {{ $visit->url }}</div>
                                            <div class="small text-muted mt-1">
                                                {{ \Carbon\Carbon::parse($visit->date)->diffForHumans() }} • <span
                                                    class="text-truncate"
                                                    style="max-width:520px;display:inline-block;">{{ $visit->user_agent }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        @if ($label && $label['text'])
                                            <span class="{{ $label['class'] }} d-inline-block mb-2"
                                                data-bs-toggle="tooltip"
                                                title="{{ $label['text'] }}">{{ ucfirst($label['text']) }}</span>
                                            <br>
                                        @endif

                                        @php $friendlyLang = $languages[$visit->id] ?? null; @endphp
                                        @if ($friendlyLang)
                                            <span class="badge bg-success">{{ $friendlyLang }}</span>
                                        @elseif($visit->accept_language)
                                            <span class="badge bg-success">{{ $visit->accept_language }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Bahasa tidak diketahui</span>
                                        @endif

                                        <div class="mt-2">
                                            <a href="{{ route('dashboard.visits.show', $visit->id) }}"
                                                class="btn btn-sm btn-outline-info">View</a>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4">No visits recorded.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Showing {{ $visits->firstItem() ?? 0 }} -
                                {{ $visits->lastItem() ?? 0 }} of {{ $visits->total() }} visits</small>
                            <div>
                                {{ $visits->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
                try {
                    new bootstrap.Tooltip(el);
                } catch (e) {
                    /* ignore if bootstrap not available */ }
            });
        });
    </script>
@endpush
