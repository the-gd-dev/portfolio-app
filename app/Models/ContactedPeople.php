<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactedPeople extends Model
{
    protected $fillable = [
        'recipient',
        'secret_id',
        'name',
        'email',
        'subject',
        'message',
        'email_recieved',
        'email_checked',
    ];
}
