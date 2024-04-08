<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function getOrdersByDate(Request $request)
    {
        Log::info("Iniciando busca por ordens na data: " . $request);

        $date = $request->date; // Espera-se uma data no formato 'Y-m-d'

        $orders = Order::with(['building', 'teamleader', 'service'])
            ->whereDate('service_date', '=', $date)
            ->get();

        Log::info("Busca completada." . $orders);

        return response()->json($orders);
    }
}
