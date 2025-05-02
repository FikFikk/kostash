<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    protected $fillable = [
        'monthly_room_price',
        'water_price',
        'electric_price',
    ];
}
