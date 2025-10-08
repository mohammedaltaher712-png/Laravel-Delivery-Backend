<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Service_Provider extends Model
{
        use HasApiTokens, Notifiable;

    protected $table = 'service_provider';

    protected $primaryKey = 'service_provider_id';

    public $timestamps = false;

    protected $fillable = [
        'service_provider_name',
        'service_provider_email',
        'service_provider_phone',
        'service_provider_password',
    ];

    // protected $hidden = [
    //     'service_provider_password',
    //     'remember_token',
    // ];

    // public function getAuthPassword()
    // {
    //     return $this->service_provider_password;
    // }
}
