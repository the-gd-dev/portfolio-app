<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    
    protected $fillable = [
        'profile_id',
        'skill',
        'icon',
        'background_color',
        'text_color'
    ];
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
