@extends('dashboard.tenants.layouts.app')

@section('title', 'Report Details')

@push('styles')
    {{-- Custom styles for a modern, consistent UI --}}
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
            --radius-lg: 1rem;
        }

        .content-card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-elegant);
        }

        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .history-timeline {
            position: relative;
            list-style: none;
            padding-left: 1.5rem;
        }

        .history-timeline::before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            bottom: 5px;
            width: 2px;
            background-color: var(--bs-border-color-translucent);
        }

        .history-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .history-item:last-child {
            padding-bottom: 0;
        }

        .history-icon {
            position: absolute;
            left: -0.5rem;
            top: 4px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: var(--bs-card-bg);
            border: 3px solid var(--bs-primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .history-icon i {
            font-size: 0.8rem;
            color: var(--bs-primary);
        }

        .info-list .list-group-item {
            background-color: transparent;
            border-color: var(--bs-border-color-translucent);
            padding: 1rem 0;
        }

        .info-list .list-group-item:first-child {
            border-top: none;
        }

        .info-list .list-group-item:last-child {
            border-bottom: none;
        }

        /* PERBAIKAN: Style untuk kontrol carousel */
        .modal-carousel .carousel-control-prev,
        .modal-carousel .carousel-control-next {
            width: 10%;
        }

        .modal-carousel .carousel-control-prev-icon,
        .modal-carousel .carousel-control-next-icon {
            background-size: 50%;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-file-search-line me-2"></i>Report Details</h1>
                        <p class="text-muted mb-0">Track the status and responses for your report.</p>
                    </div>
                    <a href="{{ route('tenant.report.index') }}" class="btn btn-outline-secondary btn-sm mt-3 mt-lg-0">
                        <i class="ri-arrow-left-line me-1"></i> Back to My Reports
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Report Details & Admin Responses -->
            <div class="col-lg-7">
                <!-- Your Report Details -->
                <div class="card content-card mb-4">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Reported on:
                            {{ $report->reported_at ? $report->reported_at->format('d M Y, H:i') : 'N/A' }}</p>
                        <h4 class="card-title mb-3">{{ $report->title }}</h4>
                        <h6>Description:</h6>
                        <p>{{ $report->description }}</p>

                        @if (!empty($report->images))
                            <h6 class="mt-4">Your Attachments:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                {{-- PERBAIKAN: Mengubah link untuk memicu carousel --}}
                                @foreach ($report->images as $key => $image)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageCarouselModal"
                                        data-bs-slide-to="{{ $key }}">
                                        <img src="{{ asset('storage/' . $image) }}" alt="attachment {{ $key + 1 }}"
                                            height="80" width="80" class="rounded object-fit-cover border">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Responses -->
                <div class="card content-card">
                    <div class="card-header bg-transparent p-4">
                        <h5 class="card-title mb-0">Responses</h5>
                    </div>
                    <div class="card-body pt-0 p-4">
                        @if ($report->responses->isNotEmpty())
                            @foreach ($report->responses->sortBy('created_at') as $response)
                                <div class="d-flex gap-3 mt-4 {{ !$loop->last ? 'mb-4 pb-4 border-bottom' : '' }}">
                                    <div class="avatar-xs flex-shrink-0">
                                        <div class="avatar-title bg-light text-dark rounded-circle">
                                            @if ($response->admin)
                                                {{ substr($response->admin->name, 0, 1) }}
                                            @else
                                                {{ substr($report->user->name, 0, 1) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-0">
                                            @if ($response->admin)
                                                {{ $response->admin->name }}
                                            @else
                                                {{ $report->user->name }} <span class="badge bg-info ms-1">You</span>
                                            @endif
                                            <small
                                                class="text-muted ms-2">{{ $response->created_at->format('d M Y, H:i') }}</small>
                                        </h6>
                                        @php
                                            $isTenantOwner =
                                                $response->admin_id === auth()->id() &&
                                                $report->user_id === auth()->id();
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="mb-1 mb-0">
                                                {{ $response->response_text }}
                                                @if ($response->updated_at && $response->updated_at->ne($response->created_at))
                                                    <span class="badge bg-warning text-dark ms-2">edited</span>
                                                @endif
                                            </p>
                                            @if ($isTenantOwner)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-line"></i>
                                                    </button>
                                                    <ul class="dropdown-menu response-menu">
                                                        <li>
                                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#editResponseModal-{{ $response->id }}">
                                                                <i class="ri-edit-line me-2"></i>Edit Response
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($isTenantOwner)
                                            <!-- Modal Edit Response Tenant -->
                                            <div class="modal fade" id="editResponseModal-{{ $response->id }}"
                                                tabindex="-1" aria-labelledby="editResponseModalLabel-{{ $response->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editResponseModalLabel-{{ $response->id }}">
                                                                <i class="ri-edit-line me-2"></i>Edit Response
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('tenant.report.response.update', [$report->id, $response->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="response_text_{{ $response->id }}"
                                                                        class="form-label fw-semibold">Response Text</label>
                                                                    <textarea name="response_text" id="response_text_{{ $response->id }}" rows="4" class="form-control" required>{{ old('response_text', $response->response_text) }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="ri-close-line me-1"></i> Cancel
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="ri-save-line me-1"></i> Save Changes
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($response->action_taken)
                                            <p class="mb-0"><small class="text-muted"><strong>Action Taken:</strong>
                                                    {{ $response->action_taken }}</small></p>
                                        @endif
                                        @if ($response->notes)
                                            <p class="mb-0"><small class="text-muted"><strong>Notes:</strong>
                                                    {{ $response->notes }}</small></p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No responses yet.</p>
                        @endif

                        @if (in_array($report->status, ['pending', 'in_progress']))
                            <hr>
                            <form action="{{ route('tenant.report.response.store', $report->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="response_text" class="form-label">Your Response</label>
                                    <textarea name="response_text" id="response_text" class="form-control" rows="3" required>{{ old('response_text') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Response</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & History -->
            <div class="col-lg-5">
                <!-- Report Details Card -->
                <div class="card content-card mb-4">
                    <div class="card-header bg-transparent p-4">
                        <h5 class="card-title mb-0">Report Info</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush info-list">
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Status</span>
                                <span
                                    class="badge fs-6 bg-{{ $report->status_color }}">{{ $report->status_label }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Priority</span>
                                <span class="badge bg-{{ $report->priority_color }}">{{ $report->priority_label }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Category</span>
                                <span>{{ $report->category_label }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Room</span>
                                <span>{{ $report->room->name }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Report ID</span>
                                <span>#{{ substr($report->id, 0, 8) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Status History Card -->
                <div class="card content-card">
                    <div class="card-header bg-transparent p-4">
                        <h5 class="card-title mb-0">Status History</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="history-timeline">
                            @foreach ($report->statusHistory->sortBy('changed_at') as $history)
                                <li class="history-item">
                                    <div class="history-icon"><i class="ri-check-line"></i></div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 fs-14">{{ $history->new_status_label }}</h6>
                                        <p class="text-muted mb-1">{{ $history->reason ?? 'Status updated.' }}</p>
                                        <small class="text-muted">{{ $history->changed_at->diffForHumans() }} by
                                            {{ $history->changedBy->name ?? 'System' }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($report->status === 'pending')
                        <div class="card-footer bg-transparent p-3 border-top">
                            <form action="{{ route('tenant.report.destroy', $report->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this report?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-soft-danger w-100">
                                    <i class="ri-delete-bin-line me-1"></i> Cancel Report
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (!empty($report->images))
        <div class="modal fade" id="imageCarouselModal" tabindex="-1" aria-labelledby="imageCarouselModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="background: transparent; border: none;">
                    <div class="modal-body p-0">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close" style="position: absolute; top: 1rem; right: 1rem; z-index: 10;"></button>
                        <div id="reportImageCarousel" class="carousel slide modal-carousel">
                            <div class="carousel-inner">
                                @foreach ($report->images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 rounded-3"
                                            alt="Full-size attachment {{ $key + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#reportImageCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#reportImageCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageCarouselModal = document.getElementById('imageCarouselModal');
            if (imageCarouselModal) {
                const carousel = new bootstrap.Carousel(imageCarouselModal.querySelector('.carousel'));

                imageCarouselModal.addEventListener('show.bs.modal', function(event) {
                    // Button that triggered the modal
                    const button = event.relatedTarget;
                    // Extract info from data-bs-* attributes
                    const slideToIndex = parseInt(button.getAttribute('data-bs-slide-to'));

                    // Go to the specific slide
                    carousel.to(slideToIndex);
                });
            }
        });
    </script>
@endpush
