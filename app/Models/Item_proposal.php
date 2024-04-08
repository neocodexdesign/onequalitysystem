<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'value', 'item_id', 'service_id'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'items_proposals';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}