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
}
