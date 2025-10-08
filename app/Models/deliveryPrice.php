<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class deliveryPrice extends Model
{
    protected $primaryKey = 'delivery_prices_id';
    protected $table = 'delivery_prices';

    public $timestamps = false;

    protected $fillable = [
       'delivery_prices_prices',
    ];

}
