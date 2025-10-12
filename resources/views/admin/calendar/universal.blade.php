@if (auth()->user()->role === 'admin')
    @extends('dashboard.admin.layouts.app')
@else
    @extends('dashboard.tenants.layouts.app')
@endif

@section('title', 'Calendar - Kostash')

@section('css')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <style>
        .fc-toolbar-title {
            color: var(--vz-heading-color) !important;
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
        }

        .fc-daygrid-event {
            padding: 2px 4px;
        }

        .event-filters {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
            border-radius: 6px;
            padding: 1rem;
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--vz-primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--vz-secondary-color);
            margin: 0;
        }

        .calendar-container {
            background: var(--vz-card-bg);
            border: 1px solid var(--vz-border-color);
            border-radius: 6px;
            padding: 1.5rem;
        }

        .modal-header {
            border-bottom: 1px solid var(--vz-border-color);
        }

        .modal-footer {
            border-top: 1px solid var(--vz-border-color);
        }

        .form-floating>label {
            color: var(--vz-secondary-color);
        }

        .event-type-tagihan {
            background-color: #dc3545;
        }

        .event-type-maintenance {
            background-color: #fd7e14;
        }

        .event-type-check_in {
            background-color: #28a745;
        }

        .event-type-check_out {
            background-color: #6c757d;
        }

        .event-type-meeting {
            background-color: #007bff;
        }

        .event-type-reminder {
            background-color: #ffc107;
        }

        .event-type-other {
            background-color: #6f42c1;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Calendar</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        @if (auth()->user()->role === 'admin')
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('tenant.home') }}">Dashboard</a></li>
                        @endif
                        <li class="breadcrumb-item active">Calendar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards" id="statsCards">
        <div class="stat-card">
            <div class="stat-number" id="totalEvents">0</div>
            <p class="stat-label">Total Events</p>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="upcomingEvents">0</div>
            <p class="stat-label">Upcoming Events</p>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="overdueEvents">0</div>
            <p class="stat-label">Overdue Events</p>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="totalAmount">Rp 0</div>
            <p class="stat-label">Total Tagihan</p>
        </div>
    </div>

    <!-- Event Filters -->
    <div class="event-filters">
        <div class="row align-items-end">
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select" id="typeFilter">
                        <option value="">All Types</option>
                        <option value="tagihan">Tagihan</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="check_in">Check In</option>
                        <option value="check_out">Check Out</option>
                        <option value="meeting">Meeting</option>
                        <option value="reminder">Reminder</option>
                        <option value="other">Other</option>
                    </select>
                    <label for="typeFilter">Event Type</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <label for="statusFilter">Status</label>
                </div>
            </div>
            @if (auth()->user()->role === 'admin')
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="userFilter">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="userFilter">User</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="roomFilter">
                            <option value="">All Rooms</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                        <label for="roomFilter">Room</label>
                    </div>
                </div>
            @endif
        </div>

        <!-- Event Type Legend -->
        <div class="calendar-legend">
            <div class="legend-item">
                <div class="legend-color event-type-tagihan"></div>
                <span>Tagihan</span>
            </div>
            <div class="legend-item">
                <div class="legend-color event-type-maintenance"></div>
                <span>Maintenance</span>
            </div>
            <div class="legend-item">
                <div class="legend-color event-type-check_in"></div>
                <span>Check In</span>
            </div>
            <div class="legend-item">
                <div class="legend-color event-type-check_out"></div>
                <span>Check Out</span>
            </div>
            <div class="legend-item">
                <div class="legend-color event-type-meeting"></div>
                <span>Meeting</span>
            </div>
            <div class="legend-item">
                <div class="legend-color event-type-reminder"></div>
                <span>Reminder</span>
            </div>
            <div class="legend-item">
                <div class="legend-color event-type-other"></div>
                <span>Other</span>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="row">
        <div class="col-12">
            <div class="calendar-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Calendar Events</h5>
                    <button type="button" class="btn btn-primary" id="addEventBtn">
                        <i class="ri-add-line"></i> Add Event
                    </button>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="eventForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="eventTitle" name="title" required>
                                    <label for="eventTitle">Title</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="eventType" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="tagihan">Tagihan</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="check_in">Check In</option>
                                        <option value="check_out">Check Out</option>
                                        <option value="meeting">Meeting</option>
                                        <option value="reminder">Reminder</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <label for="eventType">Type</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="eventDescription" name="description" style="height: 80px;"></textarea>
                            <label for="eventDescription">Description</label>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" class="form-control" id="eventStartDate"
                                        name="start_date" required>
                                    <label for="eventStartDate">Start Date</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" class="form-control" id="eventEndDate" name="end_date">
                                    <label for="eventEndDate">End Date</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 1.5rem;">
                                    <input class="form-check-input" type="checkbox" id="eventAllDay" name="all_day">
                                    <label class="form-check-label" for="eventAllDay">All Day</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="eventStatus" name="status" required>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <label for="eventStatus">Status</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="eventPriority" name="priority" required>
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                    <label for="eventPriority">Priority</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="color" class="form-control form-control-color" id="eventColor"
                                        name="color" value="#3b82f6">
                                    <label for="eventColor">Color</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="eventAmount" name="amount"
                                        min="0" step="0.01">
                                    <label for="eventAmount">Amount (for Tagihan)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="eventLocation" name="location">
                                    <label for="eventLocation">Location</label>
                                </div>
                            </div>
                        </div>

                        @if (auth()->user()->role === 'admin')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="eventAssignedTo" name="assigned_to">
                                            <option value="">Not Assigned</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="eventAssignedTo">Assigned To</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="eventRoom" name="room_id">
                                            <option value="">No specific room</option>
                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="eventRoom">Related Room</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-floating mb-3">
                            <input type="datetime-local" class="form-control" id="eventReminderAt" name="reminder_at">
                            <label for="eventReminderAt">Reminder At</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deleteEventBtn"
                            style="display: none;">Delete</button>
                        <button type="submit" class="btn btn-primary" id="saveEventBtn">Save Event</button>
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
                    <button type="button" class="btn btn-primary" id="editEventFromDetailsBtn">Edit</button>
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
        let currentEvent = null;
        let isEditMode = false;

        // Get the correct base URL for API calls
        const baseUrl = '{{ auth()->user()->role === 'admin' ? '/dashboard/calendar' : '/tenant/calendar' }}';

        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar();
            setupEventHandlers();
            loadStatistics();
        });

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 'auto',
                firstDay: 1, // Monday
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetchEvents(fetchInfo.start, fetchInfo.end, successCallback, failureCallback);
                },
                eventClick: function(info) {
                    showEventDetails(info.event.id);
                },
                eventDrop: function(info) {
                    updateEventDateTime(info.event);
                },
                eventResize: function(info) {
                    updateEventDateTime(info.event);
                },
                dateClick: function(info) {
                    openEventModal(info.date);
                },
                eventDidMount: function(info) {
                    // Add tooltip
                    info.el.setAttribute('title', info.event.title + '\n' +
                        'Type: ' + info.event.extendedProps.type + '\n' +
                        'Status: ' + info.event.extendedProps.status);
                },
                editable: hasPermissionToEdit(),
                droppable: false,
                dayMaxEvents: 3,
                moreLinkClick: 'popover'
            });

            calendar.render();
        }

        function fetchEvents(start, end, successCallback, failureCallback) {
            const params = new URLSearchParams({
                start: start.toISOString(),
                end: end.toISOString()
            });

            // Add filters
            const typeFilter = document.getElementById('typeFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const userFilter = document.getElementById('userFilter')?.value;
            const roomFilter = document.getElementById('roomFilter')?.value;

            if (typeFilter) params.append('type', typeFilter);
            if (statusFilter) params.append('status', statusFilter);
            if (userFilter) params.append('user', userFilter);
            if (roomFilter) params.append('room', roomFilter);

            fetch(`${baseUrl}/events?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    successCallback(data);
                    updateStatistics(data);
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
        }

        function setupEventHandlers() {
            // Add Event button
            document.getElementById('addEventBtn')?.addEventListener('click', function() {
                openEventModal();
            });

            // Event form submission
            document.getElementById('eventForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveEvent();
            });

            // Delete event button
            document.getElementById('deleteEventBtn').addEventListener('click', function() {
                if (currentEvent) {
                    deleteEvent(currentEvent.id);
                }
            });

            // Edit from details modal
            document.getElementById('editEventFromDetailsBtn').addEventListener('click', function() {
                if (currentEvent) {
                    const detailsModal = bootstrap.Modal.getInstance(document.getElementById('eventDetailsModal'));
                    detailsModal.hide();
                    openEventModal(null, currentEvent);
                }
            });

            // Filter change handlers
            ['typeFilter', 'statusFilter', 'userFilter', 'roomFilter'].forEach(filterId => {
                const element = document.getElementById(filterId);
                if (element) {
                    element.addEventListener('change', function() {
                        calendar.refetchEvents();
                    });
                }
            });

            // Event type change handler
            document.getElementById('eventType').addEventListener('change', function() {
                updateEventColor(this.value);
            });

            // All day checkbox handler
            document.getElementById('eventAllDay').addEventListener('change', function() {
                toggleTimeFields(this.checked);
            });
        }

        function openEventModal(date = null, event = null) {
            currentEvent = event;
            isEditMode = !!event;

            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            const form = document.getElementById('eventForm');
            const modalTitle = document.getElementById('eventModalLabel');
            const deleteBtn = document.getElementById('deleteEventBtn');

            // Reset form
            form.reset();
            form.classList.remove('was-validated');

            if (isEditMode) {
                modalTitle.textContent = 'Edit Event';
                deleteBtn.style.display = hasPermissionToDelete(event) ? 'inline-block' : 'none';
                populateEventForm(event);
            } else {
                modalTitle.textContent = 'Add Event';
                deleteBtn.style.display = 'none';

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

        function populateEventForm(event) {
            document.getElementById('eventTitle').value = event.title || '';
            document.getElementById('eventDescription').value = event.extendedProps.description || '';
            document.getElementById('eventType').value = event.extendedProps.type || '';
            document.getElementById('eventStartDate').value = formatDateTimeLocal(event.start);
            document.getElementById('eventEndDate').value = event.end ? formatDateTimeLocal(event.end) : '';
            document.getElementById('eventAllDay').checked = event.allDay || false;
            document.getElementById('eventStatus').value = event.extendedProps.status || 'scheduled';
            document.getElementById('eventPriority').value = event.extendedProps.priority || 'medium';
            document.getElementById('eventColor').value = event.backgroundColor || '#3b82f6';
            document.getElementById('eventAmount').value = event.extendedProps.amount || '';
            document.getElementById('eventLocation').value = event.extendedProps.location || '';
            document.getElementById('eventReminderAt').value = event.extendedProps.reminder_at ?
                formatDateTimeLocal(new Date(event.extendedProps.reminder_at)) : '';

            // Admin-only fields
            const assignedToField = document.getElementById('eventAssignedTo');
            const roomField = document.getElementById('eventRoom');

            if (assignedToField) {
                assignedToField.value = event.extendedProps.assigned_to || '';
            }

            if (roomField && event.extendedProps.metadata?.room_id) {
                roomField.value = event.extendedProps.metadata.room_id;
            }

            toggleTimeFields(event.allDay);
        }

        function saveEvent() {
            const form = document.getElementById('eventForm');
            const formData = new FormData(form);

            // Convert FormData to object
            const eventData = {};
            for (let [key, value] of formData.entries()) {
                if (value !== '') {
                    eventData[key] = value;
                }
            }

            // Handle checkbox
            eventData.all_day = document.getElementById('eventAllDay').checked;

            const url = isEditMode ? `${baseUrl}/events/${currentEvent.id}` : `${baseUrl}/events`;
            const method = isEditMode ? 'PUT' : 'POST';

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(eventData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
                        modal.hide();
                        calendar.refetchEvents();
                    } else {
                        showAlert('danger', data.message || 'Error saving event');
                        if (data.errors) {
                            displayValidationErrors(data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error saving event:', error);
                    showAlert('danger', 'Error saving event');
                });
        }

        function deleteEvent(eventId) {
            if (!confirm('Are you sure you want to delete this event?')) {
                return;
            }

            fetch(`${baseUrl}/events/${eventId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
                        modal.hide();
                        calendar.refetchEvents();
                    } else {
                        showAlert('danger', data.message || 'Error deleting event');
                    }
                })
                .catch(error => {
                    console.error('Error deleting event:', error);
                    showAlert('danger', 'Error deleting event');
                });
        }

        function showEventDetails(eventId) {
            fetch(`${baseUrl}/events/${eventId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentEvent = {
                            id: eventId,
                            ...data.event
                        };
                        displayEventDetails(data.event);
                    } else {
                        showAlert('danger', 'Error loading event details');
                    }
                })
                .catch(error => {
                    console.error('Error fetching event details:', error);
                    showAlert('danger', 'Error loading event details');
                });
        }

        function displayEventDetails(event) {
            const content = document.getElementById('eventDetailsContent');
            const editBtn = document.getElementById('editEventFromDetailsBtn');

            editBtn.style.display = hasPermissionToEdit(event) ? 'inline-block' : 'none';

            content.innerHTML = `
        <div class="event-details">
            <h6 class="fw-bold text-primary">${event.title}</h6>
            ${event.description ? `<p class="text-muted mb-2">${event.description}</p>` : ''}
            
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Type:</small><br>
                    <span class="badge bg-secondary">${event.type_display}</span>
                </div>
                <div class="col-6">
                    <small class="text-muted">Status:</small><br>
                    <span class="badge bg-${getStatusColor(event.status)}">${event.status_display}</span>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Start:</small><br>
                    <span>${formatDisplayDateTime(event.start_date, event.all_day)}</span>
                </div>
                ${event.end_date ? `
                    <div class="col-6">
                        <small class="text-muted">End:</small><br>
                        <span>${formatDisplayDateTime(event.end_date, event.all_day)}</span>
                    </div>
                    ` : ''}
            </div>
            
            ${event.amount ? `
                <hr>
                <div class="row">
                    <div class="col-12">
                        <small class="text-muted">Amount:</small><br>
                        <span class="fw-bold text-success">Rp ${number_format(event.amount)}</span>
                    </div>
                </div>
                ` : ''}
            
            ${event.location ? `
                <hr>
                <div class="row">
                    <div class="col-12">
                        <small class="text-muted">Location:</small><br>
                        <span>${event.location}</span>
                    </div>
                </div>
                ` : ''}
            
            ${event.creator || event.assignee ? `
                <hr>
                <div class="row">
                    ${event.creator ? `
                <div class="col-6">
                    <small class="text-muted">Created by:</small><br>
                    <span>${event.creator.name}</span>
                </div>
                ` : ''}
                    ${event.assignee ? `
                <div class="col-6">
                    <small class="text-muted">Assigned to:</small><br>
                    <span>${event.assignee.name}</span>
                </div>
                ` : ''}
                </div>
                ` : ''}
        </div>
    `;

            const modal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
            modal.show();
        }

        function updateEventDateTime(event) {
            const eventData = {
                start_date: event.start.toISOString(),
                end_date: event.end ? event.end.toISOString() : null,
                all_day: event.allDay
            };

            fetch(`${baseUrl}/events/${event.id}/datetime`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(eventData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', 'Event updated successfully');
                    } else {
                        showAlert('danger', data.message || 'Error updating event');
                        calendar.refetchEvents(); // Revert on error
                    }
                })
                .catch(error => {
                    console.error('Error updating event:', error);
                    showAlert('danger', 'Error updating event');
                    calendar.refetchEvents(); // Revert on error
                });
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
                // Convert to date only
                if (startDate.value) {
                    startDate.type = 'date';
                    startDate.value = startDate.value.split('T')[0];
                }
                if (endDate.value) {
                    endDate.type = 'date';
                    endDate.value = endDate.value.split('T')[0];
                }
            } else {
                // Convert to datetime
                startDate.type = 'datetime-local';
                endDate.type = 'datetime-local';
            }
        }

        function loadStatistics() {
            fetch(`${baseUrl}/statistics`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalEvents').textContent = data.total_events || 0;
                    document.getElementById('upcomingEvents').textContent = data.upcoming_events || 0;
                    document.getElementById('overdueEvents').textContent = data.overdue_events || 0;
                    document.getElementById('totalAmount').textContent = 'Rp ' + number_format(data.total_amount || 0);
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                });
        }

        function updateStatistics(events) {
            const stats = {
                total: events.length,
                upcoming: 0,
                overdue: 0,
                totalAmount: 0
            };

            const now = new Date();

            events.forEach(event => {
                const eventStart = new Date(event.start);

                if (eventStart > now && event.extendedProps.status === 'scheduled') {
                    stats.upcoming++;
                }

                if (eventStart < now && event.extendedProps.status === 'scheduled') {
                    stats.overdue++;
                }

                if (event.extendedProps.type === 'tagihan' && event.extendedProps.amount) {
                    stats.totalAmount += parseFloat(event.extendedProps.amount);
                }
            });

            document.getElementById('totalEvents').textContent = stats.total;
            document.getElementById('upcomingEvents').textContent = stats.upcoming;
            document.getElementById('overdueEvents').textContent = stats.overdue;
            document.getElementById('totalAmount').textContent = 'Rp ' + number_format(stats.totalAmount);
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

        function hasPermissionToEdit(event = null) {
            @if (auth()->user()->role === 'admin')
                return true;
            @else
                return event ? event.extendedProps.created_by === '{{ auth()->id() }}' : true;
            @endif
        }

        function hasPermissionToDelete(event = null) {
            @if (auth()->user()->role === 'admin')
                return true;
            @else
                return event ? event.extendedProps.created_by === '{{ auth()->id() }}' : false;
            @endif
        }

        function showAlert(type, message) {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

            // Insert at top of page
            const container = document.querySelector('.container-fluid');
            container.insertBefore(alertDiv, container.firstChild);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        function displayValidationErrors(errors) {
            // Remove existing error messages
            document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Add new error messages
            Object.keys(errors).forEach(field => {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = errors[field][0];
                    input.parentNode.appendChild(feedback);
                }
            });
        }
    </script>
@endsection
