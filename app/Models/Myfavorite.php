<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Myfavorite extends Model
{
    protected $table = 'myfavorites';

    // هذا ضروري لأن الـ View ليس فيها timestamps
    public $timestamps = false;
}
