<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventService
{
    /**
     * Create recurring events based on recurrence pattern
     */
    public function createRecurringEvents(Event $baseEvent, array $recurrencePattern, Carbon $endDate = null)
    {
        if (!$baseEvent->is_recurring || empty($recurrencePattern)) {
            return [];
        }

        $events = [];
        $frequency = $recurrencePattern['frequency'] ?? 'daily'; // daily, weekly, monthly, yearly
        $interval = $recurrencePattern['interval'] ?? 1; // every X frequency
        $daysOfWeek = $recurrencePattern['days_of_week'] ?? []; // for weekly recurrence
        $maxOccurrences = $recurrencePattern['max_occurrences'] ?? 50;

        $endDate = $endDate ?: Carbon::now()->addYear(); // Default 1 year
        $currentDate = Carbon::parse($baseEvent->start_date);
        $originalDuration = $baseEvent->end_date ?
            Carbon::parse($baseEvent->end_date)->diffInMinutes($currentDate) : 60;

        $occurrenceCount = 0;

        while ($currentDate->lte($endDate) && $occurrenceCount < $maxOccurrences) {
            // Skip the original event
            if ($occurrenceCount > 0) {
                $eventData = $baseEvent->toArray();
                unset($eventData['id'], $eventData['created_at'], $eventData['updated_at']);

                $eventData['start_date'] = $currentDate->copy();
                $eventData['end_date'] = $baseEvent->end_date ?
                    $currentDate->copy()->addMinutes($originalDuration) : null;

                // Add occurrence number to metadata
                $metadata = $eventData['metadata'] ?? [];
                $metadata['occurrence_number'] = $occurrenceCount + 1;
                $metadata['parent_event_id'] = $baseEvent->id;
                $eventData['metadata'] = $metadata;

                $event = Event::create($eventData);
                $events[] = $event;
            }

            $occurrenceCount++;

            // Calculate next occurrence
            switch ($frequency) {
                case 'daily':
                    $currentDate->addDays($interval);
                    break;

                case 'weekly':
                    if (!empty($daysOfWeek)) {
                        $currentDate = $this->getNextWeeklyOccurrence($currentDate, $daysOfWeek, $interval);
                    } else {
                        $currentDate->addWeeks($interval);
                    }
                    break;

                case 'monthly':
                    $currentDate->addMonths($interval);
                    break;

                case 'yearly':
                    $currentDate->addYears($interval);
                    break;

                default:
                    break 2; // Break out of while loop
            }
        }

        return $events;
    }

    /**
     * Get next weekly occurrence based on days of week
     */
    private function getNextWeeklyOccurrence(Carbon $currentDate, array $daysOfWeek, int $interval)
    {
        $nextDate = $currentDate->copy();
        $currentDayOfWeek = $nextDate->dayOfWeek;

        // Find next day in the same week
        $nextDayInWeek = null;
        foreach ($daysOfWeek as $day) {
            if ($day > $currentDayOfWeek) {
                $nextDayInWeek = $day;
                break;
            }
        }

        if ($nextDayInWeek !== null) {
            // Next occurrence is in the same week
            $nextDate->dayOfWeek = $nextDayInWeek;
        } else {
            // Next occurrence is in the next interval of weeks
            $nextDate->addWeeks($interval);
            $nextDate->dayOfWeek = min($daysOfWeek);
        }

        return $nextDate;
    }

    /**
     * Generate billing events for all tenants
     */
    public function generateMonthlyBillingEvents(Carbon $month = null)
    {
        $month = $month ?: Carbon::now();
        $billDate = $month->copy()->startOfMonth();
        $dueDate = $billDate->copy()->addDays(15); // Due 15 days after bill date

        $tenants = User::where('role', 'tenants')
            ->where('status', 'aktif')
            ->whereNotNull('room_id')
            ->with('room')
            ->get();

        $events = [];

        foreach ($tenants as $tenant) {
            if (!$tenant->room) continue;

            // Check if billing event already exists for this month
            $existingEvent = Event::where('type', 'tagihan')
                ->whereJsonContains('metadata->room_id', $tenant->room_id)
                ->whereJsonContains('metadata->tenant_id', $tenant->id)
                ->whereYear('start_date', $month->year)
                ->whereMonth('start_date', $month->month)
                ->first();

            if ($existingEvent) {
                continue; // Skip if already exists
            }

            // Calculate bill amount (this should come from your billing logic)
            $amount = $this->calculateMonthlyBill($tenant);

            $eventData = [
                'title' => "Tagihan Bulanan - {$tenant->name} (Room {$tenant->room->name})",
                'description' => "Tagihan bulanan untuk periode " . $month->format('F Y'),
                'type' => 'tagihan',
                'start_date' => $billDate,
                'end_date' => $dueDate,
                'all_day' => true,
                'status' => 'scheduled',
                'priority' => 'high',
                'color' => '#dc3545',
                'amount' => $amount,
                'created_by' => $this->getAdminUserId(),
                'assigned_to' => $tenant->id,
                'participants' => [$tenant->id],
                'metadata' => [
                    'room_id' => $tenant->room_id,
                    'tenant_id' => $tenant->id,
                    'billing_month' => $month->format('Y-m'),
                    'auto_generated' => true
                ]
            ];

            $event = Event::create($eventData);
            $events[] = $event;
        }

        return $events;
    }

    /**
     * Calculate monthly bill for tenant
     */
    private function calculateMonthlyBill(User $tenant)
    {
        // This is a simplified calculation
        // You should integrate with your actual billing system
        $globalSettings = \App\Models\GlobalSetting::first();

        $roomPrice = $globalSettings->monthly_room_price ?? 0;
        $adminFee = $globalSettings->admin_fee ?? 0;

        // Add meter readings if available
        $waterCost = 0;
        $electricCost = 0;

        // You can add logic here to calculate actual meter usage

        return $roomPrice + $adminFee + $waterCost + $electricCost;
    }

    /**
     * Create maintenance reminder events
     */
    public function createMaintenanceReminders()
    {
        $rooms = Room::all();
        $events = [];

        foreach ($rooms as $room) {
            // Monthly room inspection
            $events[] = $this->createMaintenanceEvent($room, 'monthly_inspection');

            // Quarterly deep cleaning
            if (Carbon::now()->month % 3 === 1) {
                $events[] = $this->createMaintenanceEvent($room, 'quarterly_cleaning');
            }

            // Annual safety check
            if (Carbon::now()->month === 1) {
                $events[] = $this->createMaintenanceEvent($room, 'annual_safety');
            }
        }

        return array_filter($events); // Remove null values
    }

    /**
     * Create specific maintenance event
     */
    private function createMaintenanceEvent(Room $room, string $type)
    {
        $now = Carbon::now();
        $nextMonth = $now->copy()->addMonth();

        $eventTypes = [
            'monthly_inspection' => [
                'title' => "Inspeksi Bulanan - Room {$room->name}",
                'description' => 'Inspeksi rutin bulanan untuk keamanan dan kebersihan',
                'date' => $nextMonth->startOfMonth()->addDays(7), // 7th of next month
                'priority' => 'medium'
            ],
            'quarterly_cleaning' => [
                'title' => "Deep Cleaning - Room {$room->name}",
                'description' => 'Pembersihan menyeluruh triwulanan',
                'date' => $nextMonth->startOfMonth()->addDays(14), // 14th of next month
                'priority' => 'high'
            ],
            'annual_safety' => [
                'title' => "Safety Check - Room {$room->name}",
                'description' => 'Pemeriksaan keselamatan tahunan',
                'date' => $nextMonth->startOfMonth()->addDays(21), // 21st of next month
                'priority' => 'urgent'
            ]
        ];

        if (!isset($eventTypes[$type])) {
            return null;
        }

        $eventConfig = $eventTypes[$type];

        // Check if event already exists
        $existing = Event::where('type', 'maintenance')
            ->whereJsonContains('metadata->room_id', $room->id)
            ->whereJsonContains('metadata->maintenance_type', $type)
            ->whereDate('start_date', $eventConfig['date'])
            ->first();

        if ($existing) {
            return null;
        }

        $eventData = [
            'title' => $eventConfig['title'],
            'description' => $eventConfig['description'],
            'type' => 'maintenance',
            'start_date' => $eventConfig['date'],
            'end_date' => $eventConfig['date']->copy()->addHours(2),
            'all_day' => false,
            'status' => 'scheduled',
            'priority' => $eventConfig['priority'],
            'color' => '#fd7e14',
            'created_by' => $this->getAdminUserId(),
            'metadata' => [
                'room_id' => $room->id,
                'maintenance_type' => $type,
                'auto_generated' => true
            ]
        ];

        return Event::create($eventData);
    }

    /**
     * Send event reminders
     */
    public function sendEventReminders()
    {
        $upcomingEvents = Event::where('reminder_at', '<=', Carbon::now())
            ->where('reminder_sent', false)
            ->where('status', 'scheduled')
            ->with(['creator', 'assignee'])
            ->get();

        foreach ($upcomingEvents as $event) {
            try {
                $this->sendEventNotification($event);
                $event->update(['reminder_sent' => true]);
            } catch (\Exception $e) {
                Log::error('Failed to send event reminder', [
                    'event_id' => $event->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $upcomingEvents->count();
    }

    /**
     * Send event notification
     */
    private function sendEventNotification(Event $event)
    {
        // Get recipients
        $recipients = collect();

        if ($event->assignee) {
            $recipients->push($event->assignee);
        }

        if ($event->participants) {
            $participantUsers = User::whereIn('id', $event->participants)->get();
            $recipients = $recipients->merge($participantUsers);
        }

        $recipients = $recipients->unique('id');

        foreach ($recipients as $user) {
            // Create notification record
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => "Reminder: {$event->title}",
                'message' => "Event '{$event->title}' is scheduled for " .
                    $event->start_date->format('Y-m-d H:i'),
                'type' => 'event_reminder',
                'data' => [
                    'event_id' => $event->id,
                    'event_type' => $event->type,
                    'start_date' => $event->start_date->toISOString()
                ],
                'is_read' => false
            ]);

            // Send email if enabled
            // You can add email notification logic here
        }
    }

    /**
     * Get events statistics for dashboard
     */
    public function getEventStatistics(User $user, Carbon $startDate = null, Carbon $endDate = null)
    {
        $startDate = $startDate ?: Carbon::now()->startOfMonth();
        $endDate = $endDate ?: Carbon::now()->endOfMonth();

        $query = Event::whereBetween('start_date', [$startDate, $endDate]);

        // Apply user-based filtering
        if ($user->role !== 'admin') {
            $query->forTenant($user->id, $user->room_id);
        }

        $events = $query->get();

        return [
            'total_events' => $events->count(),
            'by_type' => $events->groupBy('type')->map->count(),
            'by_status' => $events->groupBy('status')->map->count(),
            'by_priority' => $events->groupBy('priority')->map->count(),
            'overdue_events' => $events->filter->is_overdue->count(),
            'upcoming_events' => $events->filter(function ($event) {
                return $event->start_date->isFuture() && $event->status === 'scheduled';
            })->count(),
            'total_amount' => $events->where('type', 'tagihan')->sum('amount')
        ];
    }

    /**
     * Get admin user ID
     */
    private function getAdminUserId()
    {
        $admin = User::where('role', 'admin')->first();
        return $admin ? $admin->id : null;
    }

    /**
     * Clean up old events
     */
    public function cleanupOldEvents(Carbon $cutoffDate = null)
    {
        $cutoffDate = $cutoffDate ?: Carbon::now()->subMonths(6);

        $deletedCount = Event::where('created_at', '<', $cutoffDate)
            ->where('status', 'completed')
            ->whereNull('metadata->keep_forever')
            ->delete();

        return $deletedCount;
    }

    /**
     * Bulk update event status
     */
    public function bulkUpdateEventStatus(array $eventIds, string $status, User $user)
    {
        $query = Event::whereIn('id', $eventIds);

        // Apply user-based filtering for non-admin users
        if ($user->role !== 'admin') {
            $query->where('created_by', $user->id);
        }

        $updatedCount = $query->update(['status' => $status]);

        return $updatedCount;
    }
}
