<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    //
    protected $fillable = [
        'customer_id','order_id', 'product_id', 'quantity', 'customer_id', 'user_id',
    ];
}
