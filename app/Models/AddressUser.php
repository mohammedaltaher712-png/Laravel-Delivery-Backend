<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressUser extends Model
{
     protected $primaryKey = 'addressusers_id';
          protected $table = 'addressusers';

public $timestamps = false;

     protected $fillable = [
        'addressusers_name',
        'addressusers_description',
        'addressusers_latitude',
        'addressusers_longitude',
        'addressusers_users',

    ];
public function user()
{
    return $this->belongsTo(User::class, 'addressusers_users', 'users_id');
}

}
