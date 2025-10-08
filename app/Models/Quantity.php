<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
   protected $primaryKey = 'quantitys_id';
          protected $table = 'quantitys';

public $timestamps = false;

     protected $fillable = [
        'quantitys_name',
         'quantitys_price',
         'quantitys_menu_details',


    ];
   public function Menu_Detail() {
    return $this->belongsTo(Menu_Detail::class, 'quantitys_menu_details', 'menu_details_id');
}
}
