<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building; // Certifique-se de usar o namespace correto para o modelo Building
use App\Models\Item_proposal;

class WorkdoneController extends Controller
{
    public function list() {
        $buildings = Building::with(['orders.service', 'proposal.item_proposal'])->get();
    
        $maxOrders = 0;
    
        foreach ($buildings as $building) {
            $building->hasPaint = false;
            $building->hasCleaning = false;
    
            // Preparando um mapa dos valores dos ItemProposals para acesso rápido
            $itemValuesMap = $building->proposal ? $building->proposal->item_proposal->keyBy('service_id')->mapWithKeys(function($item) {
                return [$item->service_id => $item->value];
            }) : collect();
    
            foreach ($building->orders as $order) {
                if ($order->service->id == 3) {
                    $building->hasCleaning = true;
                    $order->service_value = $itemValuesMap->get($order->service_id, 'Valor não encontrado');
                } else {
                    $building->hasPaint = true;
                    $order->service_value = $itemValuesMap->get($order->service_id, 'Valor não encontrado');
                }
            }
    
            $ordersCount = $building->orders->count();
            $maxOrders = max($maxOrders, $ordersCount);
    
            $building->divideColumn = $building->hasPaint && $building->hasCleaning;
            
        }
    
        return view('workdone.list', compact('buildings', 'maxOrders'));
    }



}
