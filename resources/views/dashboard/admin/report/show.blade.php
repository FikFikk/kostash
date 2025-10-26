@extends('dashboard.admin.layouts.app')

@section('title', 'Manage Report')

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

        /* Styles for image carousel modal */
        .modal-carousel .carousel-control-prev,
        .modal-carousel .carousel-control-next {
            width: 10%;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .modal-carousel .carousel-control-prev:hover,
        .modal-carousel .carousel-control-next:hover {
            opacity: 1;
        }

        .modal-carousel .carousel-control-prev-icon,
        .modal-carousel .carousel-control-next-icon {
            background-size: 60%;
            filter: brightness(0) invert(1);
        }

        .btn-close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 10;
            filter: invert(1) grayscale(100%) brightness(200%);
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
                        <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-file-search-line me-2"></i>Manage Report</h1>
                        <p class="text-muted mb-0">Review details, respond, and update report status.</p>
                    </div>
                    <a href="{{ route('dashboard.report.index') }}" class="btn btn-outline-secondary btn-sm mt-3 mt-lg-0">
                        <i class="ri-arrow-left-line me-1"></i> Back to Report List
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Report Details & Responses -->
            <div class="col-lg-7">
                <!-- Report Details Card -->
                <div class="card content-card mb-4">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Report from: {{ $report->user->name }} ({{ $report->room->name }})</p>
                        <h4 class="card-title mb-3">{{ $report->title }}</h4>
                        <h6>Description:</h6>
                        <p>{{ $report->description }}</p>

                        @if (!empty($report->images))
                            <h6 class="mt-4">Attachments:</h6>
                            <div class="d-flex flex-wrap gap-2">
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

                <!-- Responses Card -->
                <div class="card content-card">
                    <div class="card-header bg-transparent p-4">
                        <h5 class="card-title mb-0">Response History</h5>
                    </div>
                    <div class="card-body pt-0 p-4">
                        <!-- Form to Add New Response -->
                        <form action="{{ route('dashboard.report.response.store', $report->id) }}" method="POST"
                            class="mb-4 pb-4 border-bottom">
                            @csrf
                            <div class="d-flex gap-3 mt-4">
                                <div class="avatar-xs flex-shrink-0">
                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <textarea name="response_text" rows="3" class="form-control @error('response_text') is-invalid @enderror"
                                        placeholder="Write a response..."></textarea>
                                    @error('response_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="text-end mt-2">
                                        <button type="submit" class="btn btn-success">Send Response</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Existing Responses -->
                        @forelse($report->responses->sortBy('created_at') as $response)
                            <div class="d-flex gap-3 mb-4">
                                <div class="avatar-xs flex-shrink-0">
                                    <div class="avatar-title bg-light text-dark rounded-circle">
                                        {{ substr($response->admin->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fs-14 mb-0">{{ $response->admin->name }}
                                            <small
                                                class="text-muted ms-2">{{ $response->created_at->format('d M Y, H:i') }}</small>
                                        </h6>

                                        @if (auth()->user()->role === 'admin' && auth()->id() === $response->admin_id)
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
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="confirmDelete('{{ $response->id }}')">
                                                            <i class="ri-delete-bin-line me-2"></i>Delete Response
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    <p class="mb-1 mt-1">
                                        {{ $response->response_text }}
                                        @if ($response->updated_at && $response->updated_at->ne($response->created_at))
                                            <span class="badge bg-warning text-dark ms-2">edited</span>
                                        @endif
                                    </p>
                                    @if ($response->action_taken)
                                        <p class="mb-0"><small class="text-muted"><strong>Action Taken:</strong>
                                                {{ $response->action_taken }}</small></p>
                                    @endif
                                </div>
                            </div>

                            {{-- Hidden Delete Form --}}
                            @if (auth()->user()->role === 'admin' && auth()->id() === $response->admin_id)
                                <form id="deleteForm-{{ $response->id }}"
                                    action="{{ route('dashboard.report.response.destroy', [$report->id, $response->id]) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif

                            {{-- Modal untuk Edit Response --}}
                            @if (auth()->user()->role === 'admin' && auth()->id() === $response->admin_id)
                                <div class="modal fade" id="editResponseModal-{{ $response->id }}" tabindex="-1"
                                    aria-labelledby="editResponseModalLabel-{{ $response->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editResponseModalLabel-{{ $response->id }}">
                                                    <i class="ri-edit-line me-2"></i>Edit Response
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form
                                                action="{{ route('dashboard.report.response.update', [$report->id, $response->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="response_text_{{ $response->id }}"
                                                            class="form-label fw-semibold">Response Text</label>
                                                        <textarea name="response_text" id="response_text_{{ $response->id }}" rows="4" class="form-control" required>{{ old('response_text', $response->response_text) }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="action_taken_{{ $response->id }}"
                                                            class="form-label fw-semibold">Action Taken <span
                                                                class="text-muted">(Optional)</span></label>
                                                        <input type="text" name="action_taken"
                                                            id="action_taken_{{ $response->id }}" class="form-control"
                                                            value="{{ old('action_taken', $response->action_taken) }}"
                                                            placeholder="Describe any actions taken...">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="ri-close-line me-1"></i>Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ri-save-line me-1"></i>Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-muted text-center">No responses have been sent yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & History -->
            <div class="col-lg-5">
                <!-- Update Status Card -->
                <div class="card content-card mb-4">
                    <div class="card-header bg-transparent p-4">
                        <h5 class="card-title mb-0">Update Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('dashboard.report.updateStatus', $report->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label d-block">Current Status</label>
                                <span
                                    class="badge fs-6 bg-{{ $report->status_color }}">{{ $report->status_label }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Change Status To</label>
                                <select name="status" id="" class="form-select">
                                    <option value="pending" @if ($report->status == 'pending') selected @endif>Pending
                                    </option>
                                    <option value="in_progress" @if ($report->status == 'in_progress') selected @endif>In
                                        Progress</option>
                                    <option value="completed" @if ($report->status == 'completed') selected @endif>Completed
                                    </option>
                                    <option value="rejected" @if ($report->status == 'rejected') selected @endif>Rejected
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Change (Optional)</label>
                                <textarea name="reason" id="reason" rows="2" class="form-control"
                                    placeholder="e.g., Technician has been scheduled"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Save Status</button>
                        </form>
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
                        <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
                    const button = event.relatedTarget;
                    const slideToIndex = parseInt(button.getAttribute('data-bs-slide-to'));
                    carousel.to(slideToIndex);
                });
            }
        });

        function confirmDelete(responseId) {
            if (confirm('Are you sure you want to delete this response? This action cannot be undone.')) {
                document.getElementById('deleteForm-' + responseId).submit();
            }
        }
    </script>
@endpush
