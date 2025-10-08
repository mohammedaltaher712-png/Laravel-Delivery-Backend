<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerCategory extends Model
{
     protected $primaryKey = 'banner_categorys_id';
          protected $table = 'banner_categorys';

public $timestamps = false;

     protected $fillable = [
        'banner_categorys_image',
         'banner_categorys_category',

    ];
 public function category()
    {
        return $this->belongsTo(Category::class, 'banner_categorys_category', 'category_id');
    }


}
