<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ReportStatusHistory extends Model
{
    protected $table = 'report_status_history';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'old_status',
        'new_status', 
        'changed_by',
        'reason',
        'changed_at'
    ];

    protected $casts = [
        'changed_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
            if (empty($model->changed_at)) {
                $model->changed_at = now();
            }
        });
    }

    // Relationships
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Accessor untuk label status
    public function getOldStatusLabelAttribute(): ?string
    {
        if (!$this->old_status) return null;
        
        $statuses = [
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak'
        ];
        return $statuses[$this->old_status] ?? $this->old_status;
    }

    public function getNewStatusLabelAttribute(): string
    {
        $statuses = [
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak'
        ];
        return $statuses[$this->new_status] ?? $this->new_status;
    }
}
