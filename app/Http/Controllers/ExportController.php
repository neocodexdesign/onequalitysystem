<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Event;
use App\Models\Order;

class ExportController extends Controller
{
    public function exportorder()
    {

        $paint_service_id = DB::table('services')
            ->whereRaw('LOWER(name_order) = ?', [strtolower('paint')])
            ->first()
            ->id;
        $cleaning_service_id = DB::table('services')
            ->whereRaw('LOWER(name_order) = ?', [strtolower('cleaning')])
            ->first()
            ->id;
        $building_id = DB::table('buildings')
            ->whereRaw('LOWER(name) = ?', [strtolower('PARK LANE SEAPORT')])
            ->first()
            ->id;
        //dd(event::all());

        Event::all()->each(function ($event) use ($paint_service_id, $cleaning_service_id, $building_id) {
            // Cria o registro de pintura
            Order::create([
                'unit' => $event->unit,
                'service_date' => $event->paint_date,
                'service_id' => $paint_service_id,
                'building_id' => $building_id, // Usando $building_id aqui
                'from' => 'Automatic Created Order From OQS 1.0',
                'status' => 'CREATED',
            ]);

            // Cria o registro de limpeza
            Order::create([
                'unit' => $event->unit,
                'service_date' => $event->cleaning_date,
                'service_id' => $cleaning_service_id,
                'building_id' => $building_id, // E aqui
                'from' => 'Automatic Created Order From OQS 1.0',
                'status' => 'CREATED',
            ]);
        });
        return redirect('/admin/orders');
    }
}
