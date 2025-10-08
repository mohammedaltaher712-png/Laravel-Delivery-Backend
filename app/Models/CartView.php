<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartView extends Model
{
protected $table = 'cardview';

    // هذا ضروري لأن الـ View ليس فيها timestamps
    public $timestamps = false;

}
