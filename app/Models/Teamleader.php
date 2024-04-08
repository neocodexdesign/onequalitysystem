<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teamleader extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_order', 'phone', 'email', 'id_users',
        'receive_email', 'receive_sms', 'receive_app',
        'user_id'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'teamleaders';

    // App\Models\Manager.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function building()
    {
        return $this->hasMany(Building::class);
    }
    // App\Models\Teamleader.php

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
