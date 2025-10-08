<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
     use SoftDeletes;
     protected $primaryKey = 'menus_id';
          protected $table = 'menus';

public $timestamps = false;

     protected $fillable = [
        'menus_name',
         'menus_services',

    ];
   public function Service() {
    return $this->belongsTo(Service::class, 'menus_services', 'services_id');
}

public function Menu_Details()
{
    return $this->hasMany(Menu_Detail::class, 'menu_details_menus', 'menus_id');
}

}
