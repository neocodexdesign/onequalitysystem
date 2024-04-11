<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit',
        'building_id',
        'teamleader_id',
        'service_id',
        'description',
        'service_date',
        'notes',
        'from',
        'status',
        'size',
    ];

    protected $dates = ['service_date', 'paint_date', 'cleaning_date'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'orders';

    protected $appends = ['formatted_service_date'];

    protected $casts = ['service_date' => 'datetime'];

    public function getServiceDateAttribute($value)
    {
        return Carbon::parse($value)->format('M-d-Y');
    }

    public function getFormattedServiceDateAttribute()
    {
        return Carbon::parse($this->service_date)->format('M-d-Y');
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function teamleader()
    {
        return $this->belongsTo(Teamleader::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getColorAttribute()
    {

        $color = null; // Inicia com null para indicar que a cor ainda não foi definida

        // Primeiro verifica o status
        switch ($this->status) {
            case 'CREATED':
                if ($this->service_id == 3) {
                    $color = '#A79B8E';
                } else {
                    $color = 'defaultColor';
                }
                break;
            case 'PROCESSING':
                //if ($this->service_id =)
                if ($this->service_id == 3) {
                    $color = 'orange';
                } else {
                    $color = 'yellow';
                }
                break;
            case 'DONE':
                if ($this->service_id == 3) {
                    $color = '#33B679';
                } else {
                    $color = 'GREEN';
                }
                break;
        }

        // Se a cor ainda não foi definida pelo status, então verifica o service_id
        if (is_null($color)) {
            switch ($this->service_id) {
                case 1:
                    $color = '#B39DDB';
                    break;
                case 3:
                    $color = '#1a73e8'; // Atenção na digitação correta da cor
                    break;
            }
        }

        // Retorna a cor definida ou uma cor padrão se nenhuma condição anterior foi atendida
        return $color ?? 'defaultColor'; // Substitua 'defaultColor' pela sua cor padrão

    }
}
#E67C73
