<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'category_id';
    protected $table = 'category';

    public $timestamps = false;

    protected $fillable = [
       'category_name',
        'category_image',

    ];

    public function bannerCategories()
    {
        return $this->hasMany(BannerCategory::class, 'banner_categorys_category', 'category_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'items_category', 'category_id');
    }

}
