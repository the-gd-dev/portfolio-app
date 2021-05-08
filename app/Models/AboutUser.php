<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUser extends Model
{
    protected $fillable = [
        'user_id',
        'about_image',
        'about_summery', 
        'work_profiles', 
        'work_profiles_summery',
        'skills_summery',
        'birthday', 
        'age', 
        'website', 
        'degree', 
        'phone', 
        'country_code', 
        'email', 
        'city', 
        'freelancer' 
    ];
}
