<?php

namespace App\Models;

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
    ];

    protected $dates = ['period'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
