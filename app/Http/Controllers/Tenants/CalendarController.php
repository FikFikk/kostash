<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display the calendar page for tenants
     */
    public function index()
    {
        return view('tenant.calendar.index');
    }

    /**
     * Get events for calendar (AJAX)
     */
    public function getEvents(Request $request)
    {
        try {
            $start = $request->get('start');
            $end = $request->get('end');

            $query = Event::forTenant(Auth::id())
                ->when($start, function ($q) use ($start) {
                    return $q->where('start_date', '>=', $start);
                })
                ->when($end, function ($q) use ($end) {
                    return $q->where('start_date', '<=', $end);
                })
                ->when($request->get('type'), function ($q) use ($request) {
                    return $q->where('type', $request->get('type'));
                })
                ->when($request->get('status'), function ($q) use ($request) {
                    return $q->where('status', $request->get('status'));
                });

            $events = $query->with(['creator', 'assignee', 'room'])
                ->orderBy('start_date')
                ->get()
                ->map(function ($event) {
                    return $event->toFullCalendarArray();
                });

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching events'], 500);
        }
    }

    /**
     * Store a new event
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:reminder,meeting,other',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'all_day' => 'boolean',
            'reminder_at' => 'nullable|date',
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $data['assigned_to'] = Auth::id(); // Tenant events are self-assigned

            // Convert all_day checkbox value
            $data['all_day'] = $request->boolean('all_day');

            $event = Event::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'event' => $event->toFullCalendarArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating event: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific event
     */
    public function show($id)
    {
        try {
            $event = Event::where('id', $id)
                ->where(function ($query) {
                    $query->where('created_by', Auth::id())
                        ->orWhere('assigned_to', Auth::id());
                })
                ->with(['creator', 'assignee', 'room'])
                ->firstOrFail();

            // Format the event for display
            $eventData = $event->toArray();
            $eventData['type_display'] = ucfirst(str_replace('_', ' ', $event->type));
            $eventData['status_display'] = ucfirst(str_replace('_', ' ', $event->status));
            $eventData['priority_display'] = ucfirst($event->priority);

            return response()->json([
                'success' => true,
                'event' => $eventData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }
    }

    /**
     * Update a specific event
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:reminder,meeting,other',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'all_day' => 'boolean',
            'reminder_at' => 'nullable|date',
        ]);

        try {
            $event = Event::where('id', $id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            $data = $request->all();
            $data['all_day'] = $request->boolean('all_day');

            $event->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully',
                'event' => $event->toFullCalendarArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating event or event not found'
            ], 500);
        }
    }

    /**
     * Delete a specific event
     */
    public function destroy($id)
    {
        try {
            $event = Event::where('id', $id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting event or event not found'
            ], 500);
        }
    }

    /**
     * Update event date/time via drag and drop
     */
    public function updateDateTime(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'all_day' => 'boolean'
        ]);

        try {
            $event = Event::where('id', $id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            $event->update([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'all_day' => $request->boolean('all_day')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Event time updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating event time'
            ], 500);
        }
    }

    /**
     * Get calendar statistics for tenant
     */
    public function getStatistics()
    {
        try {
            $userId = Auth::id();
            $now = Carbon::now();

            $stats = [
                'total_events' => Event::forTenant($userId)->count(),
                'upcoming_events' => Event::forTenant($userId)
                    ->where('start_date', '>', $now)
                    ->where('status', 'scheduled')
                    ->count(),
                'overdue_events' => Event::forTenant($userId)
                    ->where('start_date', '<', $now)
                    ->where('status', 'scheduled')
                    ->count(),
                'total_amount' => Event::forTenant($userId)
                    ->where('type', 'tagihan')
                    ->whereNotNull('amount')
                    ->sum('amount')
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json([
                'total_events' => 0,
                'upcoming_events' => 0,
                'overdue_events' => 0,
                'total_amount' => 0
            ]);
        }
    }
}
