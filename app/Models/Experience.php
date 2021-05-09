<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'user_id',
        'position_id',
        'resume_id',
        'position',
        'company_name',
        'company_address',
        'responsibilities',
        'from_date',
        'to_date',
        'is_shown',
    ];
}
