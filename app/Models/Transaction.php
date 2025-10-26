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
        'mayar_payment_id',
        'mayar_link',
        'paid_at'
    ];

    protected $casts = [
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
