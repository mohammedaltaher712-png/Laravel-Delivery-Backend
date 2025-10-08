<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesWithItems extends Model
{
     protected $table = 'serviceswithitems';

    // هذا ضروري لأن الـ View ليس فيها timestamps
    public $timestamps = false;

    // اجعلها للقراءة فقط
    public function save(array $options = [])
    {
        throw new \Exception("This model is read-only.");
    }
  public function favorites()
{
    return $this->hasMany(Favorite::class, 'favorites_services', 'services_id');
}


}
