<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit',
        'building',
        'paint_date',
        'cleaning_date',
        'status',
        'title', 'start', 'end'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'events';
}
