<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'profile',
    ];
    public function skills(){
        return $this->hasMany(Skill::class);
    }
}
