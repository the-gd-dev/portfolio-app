<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioCategory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'is_active',
        'order'
    ];
}
