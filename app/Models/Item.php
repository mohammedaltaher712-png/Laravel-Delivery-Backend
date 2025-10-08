<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'items_id';
    protected $table = 'items';

    public $timestamps = false;

    protected $fillable = [
       'items_name',
        'items_image',
       'items_category',

    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'items_category', 'category_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'item_service', 'items_id', 'services_id');
    }

}
