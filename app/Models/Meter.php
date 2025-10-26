<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use \Fahriztx\ModelUuid\Uuid;

    protected $fillable = [
        'room_id',
        'water_meter_start',
        'water_meter_end',
        'electric_meter_start',
        'electric_meter_end',
        'total_water',
        'total_electric',
        'total_bill',
        'period',
        'user_id',
    ];

    protected $dates = ['period'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedPeriodAttribute(): string
    {
        return Carbon::parse($this->period)->format('F Y');
    }

    public function getWaterUsageAttribute(): float
    {
        return $this->total_water ?? ($this->water_meter_end - $this->water_meter_start);
    }

    public function getElectricUsageAttribute(): float
    {
        return $this->total_electric ?? ($this->electric_meter_end - $this->electric_meter_start);
    }
}
