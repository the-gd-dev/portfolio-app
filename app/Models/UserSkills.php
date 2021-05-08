<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkills extends Model
{
    protected $fillable = [
        'user_id',
        'skill_id',
        'skill_accuracy',
        'skill_summery',
        'skills_order',
    ];
    public function skill(){
        return $this->belongsTo(Skill::class);
    }
}
