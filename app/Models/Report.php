<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Report extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id',
        'room_id', 
        'title',
        'description',
        'category',
        'priority',
        'status',
        'images',
        'reported_at'
    ];

    protected $casts = [
        'images' => 'array',
        'reported_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(ReportResponse::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ReportStatusHistory::class);
    }

    // Accessors & Mutators
    public function getCategoryLabelAttribute(): string
    {
        $categories = [
            'electrical' => 'Listrik',
            'water' => 'Air',
            'facility' => 'Fasilitas',
            'cleaning' => 'Kebersihan',
            'security' => 'Keamanan',
            'other' => 'Lainnya'
        ];
        return $categories[$this->category] ?? $this->category;
    }

    public function getPriorityLabelAttribute(): string
    {
        $priorities = [
            'low' => 'Rendah',
            'medium' => 'Sedang', 
            'high' => 'Tinggi',
            'urgent' => 'Mendesak'
        ];
        return $priorities[$this->priority] ?? $this->priority;
    }

    public function getStatusLabelAttribute(): string
    {
        $statuses = [
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak'
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getPriorityColorAttribute(): string
    {
        $colors = [
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'urgent' => 'dark'
        ];
        return $colors[$this->priority] ?? 'secondary';
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'in_progress' => 'info',
            'completed' => 'success',
            'rejected' => 'danger'
        ];
        return $colors[$this->status] ?? 'secondary';
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('reported_at', '>=', now()->subDays($days));
    }
}