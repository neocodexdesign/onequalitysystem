<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'phone', 'email',
        'receive_email', 'receive_sms', 'receive_app',
        'user_id'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'masters';

    // App\Models\Master.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
