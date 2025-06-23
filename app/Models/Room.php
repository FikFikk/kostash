<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use \Fahriztx\ModelUuid\Uuid;

    protected $fillable = [
        'name',
        'image',
        'width',
        'length',
        'description',
        'status',
        'facilities',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'room_id');
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function meters()
    {
        return $this->hasMany(Meter::class);
    }

    public function getTotalWaterUsage($year)
    {
        return $this->metersForYear($year)->get()->sum(function ($meter) {
            return $meter->total_water ?? ($meter->water_meter_end - $meter->water_meter_start);
        });
    }

    public function getTotalElectricUsage($year)
    {
        return $this->metersForYear($year)->get()->sum(function ($meter) {
            return $meter->total_electric ?? ($meter->electric_meter_end - $meter->electric_meter_start);
        });
    }
}
