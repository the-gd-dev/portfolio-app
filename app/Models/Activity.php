<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'activity_data',
        'activity',
        'page'
    ];
    protected $hidden = ['activity_data'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
