<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
class BuildingController extends Controller
{
    
    public function print()
    {
        $buildings = Building::all();  // Pegue todos os buildings ou faça uma consulta específica
        return view('buildings.print', compact('buildings'));
    }
    
}
