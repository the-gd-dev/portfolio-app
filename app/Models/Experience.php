<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $appends = ['is_valid'];
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
    public function getIsValidAttribute(){
        if(
            $this->is_shown == '0' || 
            (
                empty($this->position) || 
                empty($this->company_name) || 
                empty($this->company_address) || 
                empty($this->from_date)
            )    
        ){
            return false;
        }
        return true;
    }
}
