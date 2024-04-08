<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_wwd', 'phone', 'email', 'website',
        'address', 'city', 'state',  'country', 'image',
        'property_id', 'assistant_id', 'maintenance_id', 'technician_id',
    ];

    protected $casts = [
        'contract' => 'array',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'buildings';


    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function assistant()
    {
        return $this->belongsTo(Assistant::class);
    }
    public function teamleader()
    {
        return $this->belongsTo(Teamleader::class);
    }
    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }
    public function Technician()
    {
        return $this->belongsTo(Technician::class);
    }
    public function proposals()
    {
        return $this->hasMany(Proposal::class); // Tenha certeza que o nome da classe está correto, deve ser singular se sua classe for 'Proposal' e não 'Proposals'
    }
    // App\Models\Building.php

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function proposal()
    {
        return $this->hasOne(Proposal::class);
    }
    public function wwdpay()
    {
        return $this->belongsTo(Wwdpay::class, 'wwdpay_id');
    }

    
}
