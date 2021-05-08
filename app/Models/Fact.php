<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
    protected $fillable = [
        'user_id',
        'facts_overview',
        'fact', 
        'fact_value', 
        'fact_icon', 
    ];
}
