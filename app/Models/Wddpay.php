<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Wddpay extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'description',
        
        // Adicione outros campos aqui conforme necessário
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'wwdpays';

    // App\Models\Service.php

    public function building()
    {
        return $this->hasMany(Building::class);
    }
  
}