<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo_geral',
        'contact',
        'image_cover',
        'titulo_images',
        'images',
        'logo_cover',
        'titulo_description',
        'description',
        'addition_description',
        'additional_notes',
        'thanks',
        'building_id',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'proposals';

    // App\Models\Manager.php
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('F, Y');
    }
    // App\Models\Proposal.php
    public function item_proposal(): HasMany
    {
        return $this->hasMany(related: Item_proposal::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'items_proposals')->withPivot('service_id', 'value');
    }


    public function services()
    {
        return $this->hasMany(Service::class);
    }



}
