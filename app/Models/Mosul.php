<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mosul extends Authenticatable
{
         use SoftDeletes;

    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'mosuls_name',
        'mosuls_email',
        'mosuls_phone',
        'mosuls_password',
    ];

    protected $primaryKey = 'mosuls_id';
    public $timestamps = false;
}
