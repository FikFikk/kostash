<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ReportResponse extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'report_id',
        'admin_id',
        'response_text',
        'action_taken',
        'estimated_completion',
        'actual_completion',
        'notes',
    ];

    protected $casts = [
        'estimated_completion' => 'datetime',
        'actual_completion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id ??= Str::uuid());
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
