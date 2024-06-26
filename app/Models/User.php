<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // App\Models\User.php
    public function master()
    {
        return $this->hasOne(Master::class);
    }

    public function property()
    {
        return $this->hasOne(Property::class);
    }

    public function technician()
    {
        return $this->hasOne(Technician::class);
    }

    public function assistance()
    {
        return $this->hasOne(Assistant::class);
    }

    public function teamleader()
    {
        return $this->hasOne(Teamleader::class);
    }

    public function maintenance()
    {
        return $this->hasOne(maintenance::class);
    }
}
