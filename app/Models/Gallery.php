<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'filename',
        'uploader_name',
        'categories',
        'description',
    ];

    protected $casts = [
        'categories' => 'array',
    ];
}
