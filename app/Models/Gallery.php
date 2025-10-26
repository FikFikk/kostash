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
        'is_gallery',
        'is_carousel',
    ];

    protected $casts = [
        'categories' => 'array',
        'is_gallery' => 'boolean',
        'is_carousel' => 'boolean',
    ];
}
