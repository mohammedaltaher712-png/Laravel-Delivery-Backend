<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'payments_id';
    protected $table = 'payments';

    public $timestamps = false;

    protected $fillable = [
       'payments_name',
       'payments_icon'

    ];
}
