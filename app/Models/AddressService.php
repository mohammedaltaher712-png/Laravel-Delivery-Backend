<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressService extends Model
{
   
     protected $primaryKey = 'addressservices_id';
          protected $table = 'addressservices';

public $timestamps = false;

     protected $fillable = [
        'addressservices_name',
        'addressservices_description',
        'addressservices_latitude',
        'addressservices_longitude',
        'addressservices_service',

    ];
public function Service()
{
    return $this->belongsTo(Service::class, 'addressservices_service', 'services_id');
}
}
