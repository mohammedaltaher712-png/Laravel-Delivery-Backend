<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admins';

    protected $primaryKey = 'admins_id';

    public $timestamps = false;

    protected $fillable = [
        'admins_name',
        'admins_email',
        'admins_phone',
        'admins_password',
    ];

    protected $hidden = [
        'admins_password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->admins_password;
    }
}
