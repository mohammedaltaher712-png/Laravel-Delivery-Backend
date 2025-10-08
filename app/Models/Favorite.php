<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $primaryKey = 'favorites_id';
    protected $table = 'favorites';

    public $timestamps = false;

    protected $fillable = [
       'favorites_user',
       'favorites_services',

    ];

     public function user()
    {
        return $this->belongsTo(User::class, 'favorites_user', 'users_id');
    }

   public function service()
{
    return $this->belongsTo(ServicesWithItems::class, 'favorites_services', 'services_id');
}

}
