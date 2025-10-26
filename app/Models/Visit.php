<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'ip',
        'user_id',
        'visitor_id',
        'date',
        'url',
        'user_agent',
        'referer',
        'sec_fetch_site',
        'sec_fetch_mode',
        'sec_fetch_user',
        'accept_language',
        'headers_json'
    ];
}
