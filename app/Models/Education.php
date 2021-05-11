<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $appends = ['is_valid'];
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
    public function getIsValidAttribute(){
        if(
            $this->is_shown == '0' || 
            (
                empty($this->course) || 
                empty($this->institute) || 
                empty($this->from_date) || 
                empty($this->to_date)
            )    
        ){
            return false;
        }
        return true;
    }
}
