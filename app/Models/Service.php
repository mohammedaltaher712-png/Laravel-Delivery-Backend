<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
         use SoftDeletes;

   protected $primaryKey = 'services_id';
          protected $table = 'services';

public $timestamps = false;

    protected $fillable = [
    'services_name',
    'services_description',
    'services_icon',
    'services_image',
    'services_status',
    'services_category',
    'services_belongs',  // تأكد من وجوده هنا
];


    public function items()
{
    return $this->belongsToMany(Item::class, 'item_service', 'services_id', 'items_id');
}

public function menus()
{
    return $this->hasMany(Menu::class, 'menus_services', 'services_id');
}

public function menuDetails()
{
    return $this->hasMany(Menu_Detail::class, 'menu_details_services', 'services_id');
}

 public function addressService()
{
    return $this->hasOne(AddressService::class, 'addressservices_service', 'services_id');
}
}
