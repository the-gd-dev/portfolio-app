<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'user_id',
        'resume_id',
        'course_id',
        'course',
        'institute_id',
        'institute',
        'from_date',
        'to_date',
        'course_description',
        'is_shown',
    ];
}
