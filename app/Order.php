<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'customer_id', 'user_id', 'total', 'lat', 'lon', 'drop_off',
    ];
}

