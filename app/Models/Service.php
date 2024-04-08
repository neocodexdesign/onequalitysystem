<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_order'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'services';

    // App\Models\Service.php

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
    
}
