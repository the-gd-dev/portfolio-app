<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioImages extends Model
{
    protected $fillable = [
        'user_id',
        'portfolio_id',
        'name',
        'size',
        'mime',
        'height',
        'width',
        'order'
    ];
}
