<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu_Detail extends Model
{
     use SoftDeletes;
    protected $primaryKey = 'menu_details_id';
          protected $table = 'menu_details';

public $timestamps = false;

     protected $fillable = [
        'menu_details_name',
         'menu_details_description',
         'menu_details_price',
         'menu_details_image',
         'menu_details_menus',
         'menu_details_services',



    ];
   public function Service() {
    return $this->belongsTo(Service::class, 'menu_details_services', 'services_id');
}
 public function menu() {
    return $this->belongsTo(Menu::class, 'menu_details_menus', 'menus_id');
}

public function quantitys()
{
    return $this->hasMany(Quantity::class, 'quantitys_menu_details', 'menu_details_id');
}

}
