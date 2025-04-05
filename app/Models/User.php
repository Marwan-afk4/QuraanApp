<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable; // Extend from Authenticatable
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'uuid',
        'fcm_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted(){
        parent::boot();
        static::created(function ($user) {
            $user->uuid = $user->uuid ?? Str::uuid()->toString();
        });
    }

    public function payments(){
        return $this->hasMany(Payments::class);
    }
}
