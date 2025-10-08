<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'coupons_id';
    protected $table = 'coupons';
    public $timestamps = false;

    protected $fillable = [
       'coupons_name',
        'coupons_discount',
         'coupons_user',
         'coupons_start_date',
         'coupons_end_date',
        'coupons_is_active',

    ];
}
