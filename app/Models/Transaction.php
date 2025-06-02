<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use \Fahriztx\ModelUuid\Uuid;

    protected $fillable = [
        'order_id',
        'user_id', 
        'meter_id',
        'amount',
        'status',
        'payment_type',
        'snap_token',
        'midtrans_response',
        'paid_at'
    ];

    protected $casts = [
        'midtrans_response' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meter()
    {
        return $this->belongsTo(Meter::class);
    }
}
