@extends('dashboard.admin.layouts.app')

@section('title', 'Calendar Management')

@section('css')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <style>
        .hover-card {
            transition: transform 0.2s ease-in-out;
        }

        .hover-card:hover {
            transform: translateY(-2px);
        }

        .fc-toolbar-title {
            color: var(--vz-heading-color) !important;
            font-weight: 600;
        }

        .fc-button-primary {
            background-color: var(--vz-primary) !important;
            border-color: var(--vz-primary) !important;
        }

        .fc-button-primary:hover {
            background-color: var(--vz-primary-rgb, 13, 110, 253) !important;
            border-color: var(--vz-primary-rgb, 13, 110, 253) !important;
        }

        .fc-event {
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
        }

        .fc-daygrid-event {
            padding: 2px 4px;
        }

        .calendar-sidebar {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
            border-radius: 8px;
            padding: 1.5rem;
            height: fit-content;
        }

        .calendar-main {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .event-type-item {
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 6px;
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .event-type-tagihan {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .event-type-maintenance {
            background: linear-gradient(135deg, #fd7e14 0%, #e55a00 100%);
        }

        .event-type-check_in {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        }

        .event-type-check_out {
            background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
        }

        .event-type-meeting {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .event-type-reminder {
            background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
        }

        .event-type-other {
            background: linear-gradient(135deg, #6f42c1 0%, #59359a 100%);
        }

        .stat-card {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--vz-secondary-color);
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .create-event-section {
            background: var(--vz-card-bg);
            border: 2px dashed var(--vz-border-color);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .create-event-section:hover {
            border-color: var(--vz-primary);
            background: var(--vz-primary-bg-subtle);
        }

        .upcoming-events {
            max-height: 400px;
            overflow-y: auto;
        }

        .event-item {
            padding: 0.75rem;
            border: 1px solid var(--vz-border-color);
            border-radius: 6px;
            margin-bottom: 0.5rem;
            background: var(--vz-card-bg);
            transition: all 0.2s ease;
        }

        .event-item:hover {
            border-color: var(--vz-primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .filter-section {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .modal-header {
            border-bottom: 1px solid var(--vz-border-color);
            background: var(--vz-card-bg);
        }

        .modal-footer {
            border-top: 1px solid var(--vz-border-color);
            background: var(--vz-card-bg);
        }

        .form-floating>label {
            color: var(--vz-secondary-color);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800 fw-bold">Calendar Management</h1>
                        <p class="text-muted mb-0">Kelola jadwal dan event koskosan Anda</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="ri-download-line me-1"></i> Export
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#eventModal">
                            <i class="ri-add-line me-1"></i> Add Event
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card hover-card">
                    <div class="stat-number text-primary">{{ $statisticsData['total_events'] ?? 0 }}</div>
                    <div class="stat-label">Total Events</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card hover-card">
                    <div class="stat-number text-success">{{ $statisticsData['upcoming_events'] ?? 0 }}</div>
                    <div class="stat-label">Upcoming Events</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card hover-card">
                    <div class="stat-number text-warning">{{ $statisticsData['overdue_events'] ?? 0 }}</div>
                    <div class="stat-label">Overdue Events</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card hover-card">
                    <div class="stat-number text-info">Rp
                        {{ number_format($statisticsData['total_amount'] ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Tagihan</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Create New Event -->
                <div class="create-event-section">
                    <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                        data-bs-target="#eventModal">
                        <i class="ri-add-line me-2"></i> Create New Event
                    </button>
                    <p class="text-muted mt-2 mb-0 small">Drag and drop your event or click in the calendar</p>
                </div>

                <!-- Event Types -->
                <div class="calendar-sidebar mb-4">
                    <h5 class="mb-3">Event Types</h5>
                    <div class="event-type-tagihan event-type-item">
                        <i class="ri-money-dollar-circle-line me-2"></i> Tagihan
                    </div>
                    <div class="event-type-maintenance event-type-item">
                        <i class="ri-tools-line me-2"></i> Maintenance
                    </div>
                    <div class="event-type-check_in event-type-item">
                        <i class="ri-login-box-line me-2"></i> Check In
                    </div>
                    <div class="event-type-check_out event-type-item">
                        <i class="ri-logout-box-line me-2"></i> Check Out
                    </div>
                    <div class="event-type-meeting event-type-item">
                        <i class="ri-team-line me-2"></i> Meeting
                    </div>
                    <div class="event-type-reminder event-type-item">
                        <i class="ri-alarm-line me-2"></i> Reminder
                    </div>
                    <div class="event-type-other event-type-item">
                        <i class="ri-more-line me-2"></i> Other
                    </div>
                </div>

                <!-- Filters -->
                <div class="filter-section">
                    <h5 class="mb-3">Filters</h5>
                    <form action="{{ route('dashboard.calendar.index') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label for="typeFilter" class="form-label">Event Type</label>
                            <select class="form-select" id="typeFilter" name="type"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">All Types</option>
                                <option value="tagihan" {{ request('type') == 'tagihan' ? 'selected' : '' }}>Tagihan
                                </option>
                                <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance</option>
                                <option value="check_in" {{ request('type') == 'check_in' ? 'selected' : '' }}>Check In
                                </option>
                                <option value="check_out" {{ request('type') == 'check_out' ? 'selected' : '' }}>Check Out
                                </option>
                                <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Meeting
                                </option>
                                <option value="reminder" {{ request('type') == 'reminder' ? 'selected' : '' }}>Reminder
                                </option>
                                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select class="form-select" id="statusFilter" name="status"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">All Status</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>
                                    Scheduled</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="userFilter" class="form-label">User</label>
                            <select class="form-select" id="userFilter" name="user"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="roomFilter" class="form-label">Room</label>
                            <select class="form-select" id="roomFilter" name="room"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">All Rooms</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ request('room') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Upcoming Events -->
                <div class="calendar-sidebar">
                    <h5 class="mb-3">Upcoming Events</h5>
                    <div class="upcoming-events">
                        @forelse($upcomingEvents as $event)
                            <div class="event-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $event->title }}</h6>
                                        <small class="text-muted">{{ $event->start_date->format('M d, Y H:i') }}</small>
                                    </div>
                                    <span
                                        class="badge bg-{{ $event->type === 'tagihan' ? 'danger' : ($event->type === 'maintenance' ? 'warning' : 'primary') }}">
                                        {{ ucfirst($event->type) }}
                                    </span>
                                </div>
                                @if ($event->description)
                                    <p class="text-muted small mt-1 mb-0">
                                        {{ \Illuminate\Support\Str::limit($event->description, 50) }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted text-center">No upcoming events</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Calendar Main -->
            <div class="col-lg-9">
                <div class="calendar-main">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Calendar Events</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="calendar.today()">Today</button>
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary btn-sm"
                                    onclick="calendar.changeView('dayGridMonth')">Month</button>
                                <button class="btn btn-outline-primary btn-sm"
                                    onclick="calendar.changeView('timeGridWeek')">Week</button>
                                <button class="btn btn-outline-primary btn-sm"
                                    onclick="calendar.changeView('timeGridDay')">Day</button>
                                <button class="btn btn-outline-primary btn-sm"
                                    onclick="calendar.changeView('listWeek')">List</button>
                            </div>
                        </div>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dashboard.calendar.events.store') }}" method="POST" id="eventForm">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="formMethod">
                    <input type="hidden" name="event_id" id="eventId">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="eventTitle" name="title" value="{{ old('title') }}" required>
                                    <label for="eventTitle">Event Title</label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('type') is-invalid @enderror" id="eventType"
                                        name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="tagihan" {{ old('type') == 'tagihan' ? 'selected' : '' }}>Tagihan
                                        </option>
                                        <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>
                                            Maintenance</option>
                                        <option value="check_in" {{ old('type') == 'check_in' ? 'selected' : '' }}>Check
                                            In</option>
                                        <option value="check_out" {{ old('type') == 'check_out' ? 'selected' : '' }}>Check
                                            Out</option>
                                        <option value="meeting" {{ old('type') == 'meeting' ? 'selected' : '' }}>Meeting
                                        </option>
                                        <option value="reminder" {{ old('type') == 'reminder' ? 'selected' : '' }}>
                                            Reminder</option>
                                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    <label for="eventType">Event Type</label>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="eventDescription" name="description"
                                style="height: 100px;">{{ old('description') }}</textarea>
                            <label for="eventDescription">Description</label>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local"
                                        class="form-control @error('start_date') is-invalid @enderror" id="eventStartDate"
                                        name="start_date" value="{{ old('start_date') }}" required>
                                    <label for="eventStartDate">Start Date & Time</label>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local"
                                        class="form-control @error('end_date') is-invalid @enderror" id="eventEndDate"
                                        name="end_date" value="{{ old('end_date') }}">
                                    <label for="eventEndDate">End Date & Time</label>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 1.5rem;">
                                    <input class="form-check-input" type="checkbox" id="eventAllDay" name="all_day"
                                        value="1" {{ old('all_day') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="eventAllDay">All Day</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('status') is-invalid @enderror" id="eventStatus"
                                        name="status" required>
                                        <option value="scheduled"
                                            {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled
                                        </option>
                                        <option value="in_progress"
                                            {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                    <label for="eventStatus">Status</label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('priority') is-invalid @enderror" id="eventPriority"
                                        name="priority" required>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low
                                        </option>
                                        <option value="medium"
                                            {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High
                                        </option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent
                                        </option>
                                    </select>
                                    <label for="eventPriority">Priority</label>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="color"
                                        class="form-control form-control-color @error('color') is-invalid @enderror"
                                        id="eventColor" name="color" value="{{ old('color', '#3b82f6') }}">
                                    <label for="eventColor">Color</label>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                        id="eventAmount" name="amount" min="0" step="0.01"
                                        value="{{ old('amount') }}">
                                    <label for="eventAmount">Amount (for Tagihan)</label>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                        id="eventLocation" name="location" value="{{ old('location') }}">
                                    <label for="eventLocation">Location</label>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('assigned_to') is-invalid @enderror"
                                        id="eventAssignedTo" name="assigned_to">
                                        <option value="">Assign to All Tenants</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="eventAssignedTo">Assigned To</label>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('room_id') is-invalid @enderror" id="eventRoom"
                                        name="room_id">
                                        <option value="">No specific room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="eventRoom">Related Room</label>
                                    @error('room_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="datetime-local" class="form-control @error('reminder_at') is-invalid @enderror"
                                id="eventReminderAt" name="reminder_at" value="{{ old('reminder_at') }}">
                            <label for="eventReminderAt">Reminder At</label>
                            @error('reminder_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deleteEventBtn" style="display: none;"
                            onclick="deleteEvent()">Delete</button>
                        <button type="submit" class="btn btn-primary">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="eventDetailsContent">
                    <!-- Event details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editEventBtn"
                        onclick="editEventFromDetails()">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        let calendar;
        let currentEventData = null;

        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar();
            setupEventHandlers();
        });

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');

            const events = @json($events ?? []);

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                height: 'auto',
                firstDay: 1,
                events: events,
                eventClick: function(info) {
                    showEventDetails(info.event);
                },
                dateClick: function(info) {
                    openEventModal(info.date);
                },
                eventDidMount: function(info) {
                    info.el.setAttribute('title', info.event.title + '\nType: ' + info.event.extendedProps
                        .type + '\nStatus: ' + info.event.extendedProps.status);
                },
                editable: false,
                droppable: false,
                dayMaxEvents: 3,
                moreLinkClick: 'popover'
            });

            calendar.render();
        }

        function setupEventHandlers() {
            // Event type change handler
            document.getElementById('eventType').addEventListener('change', function() {
                updateEventColor(this.value);
            });

            // All day checkbox handler
            document.getElementById('eventAllDay').addEventListener('change', function() {
                toggleTimeFields(this.checked);
            });
        }

        function openEventModal(date = null, eventData = null) {
            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            const form = document.getElementById('eventForm');
            const modalTitle = document.getElementById('eventModalLabel');
            const deleteBtn = document.getElementById('deleteEventBtn');
            const formMethod = document.getElementById('formMethod');
            const eventId = document.getElementById('eventId');

            // Reset form
            form.reset();
            form.action = '{{ route('dashboard.calendar.events.store') }}';
            formMethod.value = 'POST';
            eventId.value = '';

            if (eventData) {
                // Edit mode
                modalTitle.textContent = 'Edit Event';
                deleteBtn.style.display = 'inline-block';
                form.action = '{{ route('dashboard.calendar.events.update', ':id') }}'.replace(':id', eventData.id);
                formMethod.value = 'PUT';
                eventId.value = eventData.id;
                populateEventForm(eventData);
                currentEventData = eventData;
            } else {
                // Create mode
                modalTitle.textContent = 'Add New Event';
                deleteBtn.style.display = 'none';
                currentEventData = null;

                if (date) {
                    const startDate = new Date(date);
                    document.getElementById('eventStartDate').value = formatDateTimeLocal(startDate);

                    const endDate = new Date(startDate);
                    endDate.setHours(startDate.getHours() + 1);
                    document.getElementById('eventEndDate').value = formatDateTimeLocal(endDate);
                }
            }

            modal.show();
        }

        function populateEventForm(eventData) {
            document.getElementById('eventTitle').value = eventData.title || '';
            document.getElementById('eventDescription').value = eventData.extendedProps.description || '';
            document.getElementById('eventType').value = eventData.extendedProps.type || '';
            document.getElementById('eventStartDate').value = formatDateTimeLocal(eventData.start);
            document.getElementById('eventEndDate').value = eventData.end ? formatDateTimeLocal(eventData.end) : '';
            document.getElementById('eventAllDay').checked = eventData.allDay || false;
            document.getElementById('eventStatus').value = eventData.extendedProps.status || 'scheduled';
            document.getElementById('eventPriority').value = eventData.extendedProps.priority || 'medium';
            document.getElementById('eventColor').value = eventData.backgroundColor || '#3b82f6';
            document.getElementById('eventAmount').value = eventData.extendedProps.amount || '';
            document.getElementById('eventLocation').value = eventData.extendedProps.location || '';
            document.getElementById('eventReminderAt').value = eventData.extendedProps.reminder_at ?
                formatDateTimeLocal(new Date(eventData.extendedProps.reminder_at)) : '';

            if (eventData.extendedProps.assigned_to) {
                document.getElementById('eventAssignedTo').value = eventData.extendedProps.assigned_to;
            }

            if (eventData.extendedProps.room_id) {
                document.getElementById('eventRoom').value = eventData.extendedProps.room_id;
            }

            toggleTimeFields(eventData.allDay);
        }

        function showEventDetails(event) {
            const content = document.getElementById('eventDetailsContent');

            content.innerHTML = `
        <div class="event-details">
            <h6 class="fw-bold text-primary">${event.title}</h6>
            ${event.extendedProps.description ? `<p class="text-muted mb-2">${event.extendedProps.description}</p>` : ''}
            
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Type:</small><br>
                    <span class="badge bg-secondary">${event.extendedProps.type_display || event.extendedProps.type}</span>
                </div>
                <div class="col-6">
                    <small class="text-muted">Status:</small><br>
                    <span class="badge bg-${getStatusColor(event.extendedProps.status)}">${event.extendedProps.status_display || event.extendedProps.status}</span>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Start:</small><br>
                    <span>${formatDisplayDateTime(event.start, event.allDay)}</span>
                </div>
                ${event.end ? `
                                <div class="col-6">
                                    <small class="text-muted">End:</small><br>
                                    <span>${formatDisplayDateTime(event.end, event.allDay)}</span>
                                </div>
                                ` : ''}
            </div>
            
            ${event.extendedProps.amount ? `
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">Amount:</small><br>
                                    <span class="fw-bold text-success">Rp ${number_format(event.extendedProps.amount)}</span>
                                </div>
                            </div>
                            ` : ''}
            
            ${event.extendedProps.location ? `
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">Location:</small><br>
                                    <span>${event.extendedProps.location}</span>
                                </div>
                            </div>
                            ` : ''}
        </div>
    `;

            currentEventData = event;
            const modal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
            modal.show();
        }

        function editEventFromDetails() {
            if (currentEventData) {
                const detailsModal = bootstrap.Modal.getInstance(document.getElementById('eventDetailsModal'));
                detailsModal.hide();
                openEventModal(null, currentEventData);
            }
        }

        function deleteEvent() {
            if (!currentEventData || !confirm('Are you sure you want to delete this event?')) {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('dashboard.calendar.events.destroy', ':id') }}'.replace(':id', currentEventData.id);

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }

        function updateEventColor(type) {
            const colorMapping = {
                'tagihan': '#dc3545',
                'maintenance': '#fd7e14',
                'check_in': '#28a745',
                'check_out': '#6c757d',
                'meeting': '#007bff',
                'reminder': '#ffc107',
                'other': '#6f42c1'
            };

            if (colorMapping[type]) {
                document.getElementById('eventColor').value = colorMapping[type];
            }
        }

        function toggleTimeFields(allDay) {
            const startDate = document.getElementById('eventStartDate');
            const endDate = document.getElementById('eventEndDate');

            if (allDay) {
                if (startDate.value) {
                    startDate.type = 'date';
                    startDate.value = startDate.value.split('T')[0];
                }
                if (endDate.value) {
                    endDate.type = 'date';
                    endDate.value = endDate.value.split('T')[0];
                }
            } else {
                startDate.type = 'datetime-local';
                endDate.type = 'datetime-local';
            }
        }

        // Utility functions
        function formatDateTimeLocal(date) {
            if (!date) return '';
            const d = new Date(date);
            const offset = d.getTimezoneOffset();
            const localDate = new Date(d.getTime() - (offset * 60000));
            return localDate.toISOString().slice(0, 16);
        }

        function formatDisplayDateTime(dateStr, allDay) {
            const date = new Date(dateStr);
            if (allDay) {
                return date.toLocaleDateString();
            }
            return date.toLocaleString();
        }

        function getStatusColor(status) {
            const colors = {
                'scheduled': 'primary',
                'in_progress': 'warning',
                'completed': 'success',
                'cancelled': 'danger'
            };
            return colors[status] || 'secondary';
        }

        function number_format(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    </script>
@endsection
