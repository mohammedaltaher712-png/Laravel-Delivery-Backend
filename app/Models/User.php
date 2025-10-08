<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'users_name',
        'users_email',
        'users_phone',
        'users_password',
    ];

    protected $primaryKey = 'users_id';
    public $timestamps = false;

    public function addresses()
    {
        return $this->hasMany(AddressUser::class, 'addressusers_users', 'users_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'carts_user', 'users_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'favorites_user', 'users_id');
    }
}
