<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerHome extends Model
{
    protected $primaryKey = 'banner_homes_id';
public $timestamps = false;

     protected $fillable = [
        'banner_homes_image',

    ];


}
