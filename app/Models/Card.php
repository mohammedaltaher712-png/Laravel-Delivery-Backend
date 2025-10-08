<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $primaryKey = 'carts_id';
    protected $table = 'carts';

    public $timestamps = false;

    protected $fillable = [
       'carts_menu_details',
       'carts_quantitys',
       'carts_user',
       'carts_orders',
    ];

    public function menuDetail()
    {
        return $this->belongsTo(Menu_Detail::class, 'carts_menu_details', 'menu_details_id');
    }

    public function quantity()
    {
        return $this->belongsTo(Quantity::class, 'carts_quantitys', 'quantitys_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'carts_user', 'users_id');
    }
}
