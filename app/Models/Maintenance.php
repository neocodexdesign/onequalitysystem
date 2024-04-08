<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email', 'id_users',
        'receive_email', 'receive_sms', 'receive_app',
        'user_id'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'maintenances';

    // App\Models\Manager.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function building()
    {
        return $this->hasMany(Building::class);
    }
}
