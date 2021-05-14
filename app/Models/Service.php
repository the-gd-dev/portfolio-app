<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id',
        'service',
        'service_description',
        'icon',
        'background_color',
        'text_color'
    ];
}
