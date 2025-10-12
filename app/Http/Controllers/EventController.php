<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Display the calendar page
     */
    public function index(Request $request)
    {
        $users = User::where('role', 'tenants')->get();
        $rooms = Room::all();

        // Get events based on filters
        $query = Event::forAdmin()
            ->when($request->get('type'), function ($q) use ($request) {
                return $q->where('type', $request->get('type'));
            })
            ->when($request->get('status'), function ($q) use ($request) {
                return $q->where('status', $request->get('status'));
            })
            ->when($request->get('user'), function ($q) use ($request) {
                return $q->where(function ($query) use ($request) {
                    $query->where('created_by', $request->get('user'))
                        ->orWhere('assigned_to', $request->get('user'));
                });
            })
            ->when($request->get('room'), function ($q) use ($request) {
                return $q->where('room_id', $request->get('room'));
            });

        $events = $query->with(['creator', 'assignee', 'room'])
            ->orderBy('start_date')
            ->get()
            ->map(function ($event) {
                return $event->toFullCalendarArray();
            });

        // Get upcoming events for sidebar
        $upcomingEvents = Event::forAdmin()
            ->where('start_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('start_date')
            ->limit(10)
            ->get();

        // Get statistics
        $statisticsData = $this->getStatistics(new Request());

        return view('admin.calendar.index', compact('users', 'rooms', 'events', 'upcomingEvents', 'statisticsData'));
    }

    /**
     * Get events for calendar (AJAX endpoint)
     */
    public function getEvents(Request $request)
    {
        $user = Auth::user();
        $start = $request->get('start');
        $end = $request->get('end');

        $query = Event::with(['creator', 'assignee'])
            ->inDateRange($start, $end);

        // Apply role-based filtering
        if ($user->role === 'admin') {
            // Admin can see all events
            $events = $query->forAdmin();
        } else {
            // Tenant can only see their relevant events
            $events = $query->forTenant($user->id, $user->room_id);
        }

        // Apply filters if provided
        if ($request->has('type') && $request->type !== '') {
            $events = $events->ofType($request->type);
        }

        if ($request->has('status') && $request->status !== '') {
            $events = $events->withStatus($request->status);
        }

        $events = $events->get();

        // Transform events for FullCalendar
        $calendarEvents = $events->map(function ($event) {
            return $event->toFullCalendarArray();
        });

        return response()->json($calendarEvents);
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tagihan,maintenance,check_in,check_out,meeting,reminder,other',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'all_day' => 'boolean',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'amount' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'participants' => 'nullable|array',
            'participants.*' => 'exists:users,id',
            'room_id' => 'nullable|exists:rooms,id',
            'is_recurring' => 'boolean',
            'recurrence_pattern' => 'nullable|array',
            'reminder_at' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Prepare event data
        $eventData = $request->only([
            'title',
            'description',
            'type',
            'start_date',
            'end_date',
            'all_day',
            'status',
            'priority',
            'color',
            'amount',
            'location',
            'assigned_to',
            'is_recurring',
            'recurrence_pattern',
            'reminder_at'
        ]);

        $eventData['created_by'] = $user->id;
        $eventData['participants'] = $request->participants ?: [];

        // Add metadata
        $metadata = [];
        if ($request->room_id) {
            $metadata['room_id'] = $request->room_id;
        }
        $eventData['metadata'] = $metadata;

        // Set default color based on type if not provided
        if (!$request->color) {
            $eventData['color'] = $this->getDefaultColorForType($request->type);
        }

        try {
            $event = Event::create($eventData);

            return redirect()->route('dashboard.calendar.index')
                ->with('success', 'Event berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat event: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified event
     */
    public function show(Event $event)
    {
        $user = Auth::user();

        // Check if user can view this event
        if (!$this->canUserAccessEvent($user, $event)) {
            abort(403, 'Unauthorized access to this event');
        }

        $event->load(['creator', 'assignee']);

        return response()->json([
            'success' => true,
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'type' => $event->type,
                'type_display' => $event->type_display,
                'start_date' => $event->start_date->format('Y-m-d H:i:s'),
                'end_date' => $event->end_date ? $event->end_date->format('Y-m-d H:i:s') : null,
                'all_day' => $event->all_day,
                'status' => $event->status,
                'status_display' => $event->status_display,
                'priority' => $event->priority,
                'priority_display' => $event->priority_display,
                'color' => $event->color,
                'amount' => $event->amount,
                'location' => $event->location,
                'creator' => $event->creator ? [
                    'id' => $event->creator->id,
                    'name' => $event->creator->name
                ] : null,
                'assignee' => $event->assignee ? [
                    'id' => $event->assignee->id,
                    'name' => $event->assignee->name
                ] : null,
                'participants' => $event->participants,
                'metadata' => $event->metadata,
                'is_recurring' => $event->is_recurring,
                'recurrence_pattern' => $event->recurrence_pattern,
                'reminder_at' => $event->reminder_at ? $event->reminder_at->format('Y-m-d H:i:s') : null,
                'is_overdue' => $event->is_overdue,
                'created_at' => $event->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Update the specified event
     */
    public function update(Request $request, Event $event)
    {
        $user = Auth::user();

        // Check if user can edit this event
        if (!$this->canUserEditEvent($user, $event)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to edit this event'
                ], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized to edit this event');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tagihan,maintenance,check_in,check_out,meeting,reminder,other',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'all_day' => 'boolean',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'amount' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'participants' => 'nullable|array',
            'participants.*' => 'exists:users,id',
            'room_id' => 'nullable|exists:rooms,id',
            'is_recurring' => 'boolean',
            'recurrence_pattern' => 'nullable|array',
            'reminder_at' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $eventData = $request->only([
                'title',
                'description',
                'type',
                'start_date',
                'end_date',
                'all_day',
                'status',
                'priority',
                'color',
                'amount',
                'location',
                'assigned_to',
                'is_recurring',
                'recurrence_pattern',
                'reminder_at'
            ]);

            $eventData['participants'] = $request->participants ?: [];

            // Update metadata
            $metadata = $event->metadata ?: [];
            if ($request->room_id) {
                $metadata['room_id'] = $request->room_id;
            }
            $eventData['metadata'] = $metadata;

            $event->update($eventData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event berhasil diupdate',
                    'event' => $event->fresh()->toFullCalendarArray()
                ]);
            }

            return redirect()->route('admin.calendar.index')->with('success', 'Event berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate event: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal mengupdate event: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified event
     */
    public function destroy(Event $event)
    {
        $user = Auth::user();

        // Check if user can delete this event
        if (!$this->canUserEditEvent($user, $event)) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to delete this event'
                ], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized to delete this event');
        }

        try {
            $event->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.calendar.index')->with('success', 'Event berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus event: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal menghapus event: ' . $e->getMessage());
        }
    }

    /**
     * Update event date/time (for drag & drop functionality)
     */
    public function updateDateTime(Request $request, Event $event)
    {
        $user = Auth::user();

        // Check if user can edit this event
        if (!$this->canUserEditEvent($user, $event)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to edit this event'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'all_day' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $event->update([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'all_day' => $request->all_day ?? false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Event date updated successfully',
                'event' => $event->fresh()->toFullCalendarArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update event: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get event types with their default colors
     */
    public function getEventTypes()
    {
        return response()->json([
            'tagihan' => ['label' => 'Tagihan', 'color' => '#dc3545'],
            'maintenance' => ['label' => 'Maintenance', 'color' => '#fd7e14'],
            'check_in' => ['label' => 'Check In', 'color' => '#28a745'],
            'check_out' => ['label' => 'Check Out', 'color' => '#6c757d'],
            'meeting' => ['label' => 'Meeting', 'color' => '#007bff'],
            'reminder' => ['label' => 'Reminder', 'color' => '#ffc107'],
            'other' => ['label' => 'Other', 'color' => '#6f42c1']
        ]);
    }

    /**
     * Get calendar statistics
     */
    public function getStatistics(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->get('start') ? Carbon::createFromFormat('Y-m-d', $request->get('start')) : Carbon::createFromFormat('Y-m-d', date('Y-m-01'));
        $endDate = $request->get('end') ? Carbon::createFromFormat('Y-m-d', $request->get('end')) : Carbon::createFromFormat('Y-m-d', date('Y-m-t'));

        $query = Event::whereBetween('start_date', [$startDate, $endDate]);

        // Apply role-based filtering
        if ($user->role !== 'admin') {
            $query->forTenant($user->id, $user->room_id);
        }

        $events = $query->get();

        $statistics = [
            'total_events' => $events->count(),
            'upcoming_events' => $events->filter(function ($event) {
                return $event->start_date->isFuture() && $event->status === 'scheduled';
            })->count(),
            'overdue_events' => $events->filter(function ($event) {
                return $event->start_date->isPast() && $event->status === 'scheduled';
            })->count(),
            'completed_events' => $events->where('status', 'completed')->count(),
            'total_amount' => $events->where('type', 'tagihan')->sum('amount'),
            'by_type' => $events->groupBy('type')->map->count(),
            'by_status' => $events->groupBy('status')->map->count(),
            'by_priority' => $events->groupBy('priority')->map->count()
        ];

        // If this is an AJAX request, return JSON
        if ($request->expectsJson()) {
            return response()->json($statistics);
        }

        // Otherwise, return the array for view use
        return $statistics;
    }

    /**
     * Check if user can access event
     */
    private function canUserAccessEvent($user, $event)
    {
        if ($user->role === 'admin') {
            return true;
        }

        // Tenant can access if they created it, assigned to it, or in participants
        return $event->created_by === $user->id ||
            $event->assigned_to === $user->id ||
            in_array($user->id, $event->participants ?: []) ||
            (isset($event->metadata['room_id']) && $event->metadata['room_id'] === $user->room_id);
    }

    /**
     * Check if user can edit event
     */
    private function canUserEditEvent($user, $event)
    {
        if ($user->role === 'admin') {
            return true;
        }

        // Tenant can only edit events they created
        return $event->created_by === $user->id;
    }

    /**
     * Get default color for event type
     */
    private function getDefaultColorForType($type)
    {
        $colors = [
            'tagihan' => '#dc3545',
            'maintenance' => '#fd7e14',
            'check_in' => '#28a745',
            'check_out' => '#6c757d',
            'meeting' => '#007bff',
            'reminder' => '#ffc107',
            'other' => '#6f42c1'
        ];

        return $colors[$type] ?? '#6f42c1';
    }
}
