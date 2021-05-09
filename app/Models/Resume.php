<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'user_id',
        'resume_summery',
        'education',
        'experience',
        'template_id',
        'is_downloadable'
    ];
    
    public function qualifications()
    {
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
