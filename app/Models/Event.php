<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Event extends Model
{
    /**
     * Relationship with Room
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    protected $fillable = [
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
        'participants',
        'metadata',
        'created_by',
        'assigned_to',
        'is_recurring',
        'recurrence_pattern',
        'reminder_at',
        'reminder_sent'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'reminder_at' => 'datetime',
        'all_day' => 'boolean',
        'is_recurring' => 'boolean',
        'reminder_sent' => 'boolean',
        'participants' => 'array',
        'metadata' => 'array',
        'recurrence_pattern' => 'array',
        'amount' => 'decimal:2'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'reminder_at'
    ];

    /**
     * Relationship with User who created the event
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship with User who is assigned to the event
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Scope for filtering events by date range
     */
    public function scopeInDateRange($query, $start, $end)
    {
        return $query->where(function ($q) use ($start, $end) {
            $q->whereBetween('start_date', [$start, $end])
                ->orWhereBetween('end_date', [$start, $end])
                ->orWhere(function ($q2) use ($start, $end) {
                    $q2->where('start_date', '<=', $start)
                        ->where('end_date', '>=', $end);
                });
        });
    }

    /**
     * Scope for filtering events by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for filtering events by status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering events visible to a specific user
     */
    public function scopeVisibleToUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('created_by', $userId)
                ->orWhere('assigned_to', $userId)
                ->orWhereJsonContains('participants', $userId)
                ->orWhere(function ($q2) {
                    // Events that are public (no specific participants)
                    $q2->whereNull('participants');
                });
        });
    }

    /**
     * Scope for admin to see all events
     */
    public function scopeForAdmin($query)
    {
        return $query; // Admin can see all events
    }

    /**
     * Scope for tenant to see only relevant events
     */
    public function scopeForTenant($query, $userId, $roomId = null)
    {
        return $query->where(function ($q) use ($userId, $roomId) {
            // Events created by user
            $q->where('created_by', $userId)
                // Events assigned to user
                ->orWhere('assigned_to', $userId)
                // Events in participants list
                ->orWhereJsonContains('participants', $userId)
                // Global events (no assigned_to means for all tenants)
                ->orWhereNull('assigned_to');

            // If user has a room, include room-specific events
            if ($roomId) {
                $q->orWhereJsonContains('metadata->room_id', $roomId);
            }
        });
    }

    /**
     * Get formatted start date for FullCalendar
     */
    public function getFormattedStartAttribute()
    {
        return $this->start_date ? $this->start_date->toISOString() : null;
    }

    /**
     * Get formatted end date for FullCalendar
     */
    public function getFormattedEndAttribute()
    {
        return $this->end_date ? $this->end_date->toISOString() : null;
    }

    /**
     * Get FullCalendar formatted event data
     */
    public function toFullCalendarArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->formatted_start,
            'end' => $this->formatted_end,
            'allDay' => $this->all_day,
            'backgroundColor' => $this->color,
            'borderColor' => $this->color,
            'textColor' => $this->getTextColor(),
            'extendedProps' => [
                'description' => $this->description,
                'type' => $this->type,
                'status' => $this->status,
                'priority' => $this->priority,
                'amount' => $this->amount,
                'location' => $this->location,
                'created_by' => $this->created_by,
                'assigned_to' => $this->assigned_to,
                'creator_name' => $this->creator?->name,
                'assignee_name' => $this->assignee?->name,
                'metadata' => $this->metadata
            ]
        ];
    }

    /**
     * Get appropriate text color based on background color
     */
    public function getTextColor()
    {
        // Simple calculation to determine if text should be light or dark
        $hex = str_replace('#', '', $this->color);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculate luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.5 ? '#000000' : '#ffffff';
    }

    /**
     * Check if event is overdue (for scheduled events)
     */
    public function getIsOverdueAttribute()
    {
        if ($this->status !== 'scheduled') {
            return false;
        }

        return $this->start_date && $this->start_date->isPast();
    }

    /**
     * Get event type with proper formatting
     */
    public function getTypeDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    /**
     * Get status with proper formatting
     */
    public function getStatusDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Get priority with proper formatting
     */
    public function getPriorityDisplayAttribute()
    {
        return ucfirst($this->priority);
    }
}
