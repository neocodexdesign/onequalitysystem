<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
class BuildingController extends Controller
{
    
    public function print()
    {
        $buildings = Building::WhereIn('cleaning', [1, 3])->orderby('name_wwd')->get();  // Pegue todos os buildings ou faça uma consulta específica
       
        // Para cada prédio, definir o serviço correspondente
        foreach ($buildings as $building) {
            switch ($building['cleaning']) {
                case 1:
                    $building['service'] = 'Cleaning';
                    break;
                case 2:
                    $building['service'] = 'Paint';
                    break;
                case 3:
                    $building['service'] = 'Cleaning and Paint';
                    break;
                default:
                    $building['service'] = 'Inativo';
            }
        }
    
        return view('buildings.print', compact('buildings'));
    }
    
}
