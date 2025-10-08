<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'orders_id';
    protected $table = 'orders';

    protected $fillable = [
       'orders_user',
        'orders_address',
     'orders_address_serivce',

        'orders_coupon',
        'orders_pricedelivery',
        'orders_price',
        'orders_paymentmethod',
        'orders_services',
         'orders_comments',
         'orders_status',

    ];
}
