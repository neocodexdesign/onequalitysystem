<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'status',
        'location',
        'description',
        'url',
        'event_id',
        'kind',
        'start',
        'end',    
        'updated',
        'created',
    ];


    protected $dates = [
        'start',
        'end',    
        'updated',
        'created',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'tasks';

    protected $casts = ['start' => 'datetime', 'end' => 'datetime'];

    public function getServiceDateAttribute($value)
    {
        return Carbon::parse($value)->format('M-d-Y');
    }
}