<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'fname', 'lname', 'dob', 'email', 'phone_number', 'county', 'neighbourhood',
    ];
}

