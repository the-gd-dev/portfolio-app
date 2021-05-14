<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioSettings extends Model
{
    protected $fillable = [
        'user_id',
        'setting',
        'value',
        'is_apply'
    ];
}
