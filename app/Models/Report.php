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
            $model->id = $model->id ?: Str::uuid();
        });
    }

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

    public function getCategoryLabelAttribute(): string
    {
        return [
            'electrical' => 'Listrik',
            'water' => 'Air',
            'facility' => 'Fasilitas',
            'cleaning' => 'Kebersihan',
            'security' => 'Keamanan',
            'other' => 'Lainnya'
        ][$this->category] ?? $this->category;
    }

    public function getPriorityLabelAttribute(): string
    {
        return [
            'low' => 'Rendah',
            'medium' => 'Sedang', 
            'high' => 'Tinggi',
            'urgent' => 'Mendesak'
        ][$this->priority] ?? $this->priority;
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak'
        ][$this->status] ?? $this->status;
    }

    public function getPriorityColorAttribute(): string
    {
        return [
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'urgent' => 'dark'
        ][$this->priority] ?? 'secondary';
    }

    public function getStatusColorAttribute(): string
    {
        return [
            'pending' => 'warning',
            'in_progress' => 'info',
            'completed' => 'success',
            'rejected' => 'danger'
        ][$this->status] ?? 'secondary';
    }

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
