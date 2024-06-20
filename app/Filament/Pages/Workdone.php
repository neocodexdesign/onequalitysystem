<?php

namespace App\Filament\Pages;

use Illuminate\Database\Eloquent\Model;

use Filament\Pages\Page;
use Filament\Pages\Forms;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Label;
 
use Filament\Actions\CreateAction; // Import from previous solution
use Filament\Actions\EditAction; // Import EditAction class
use Filament\Actions\DeleteAction; // Import DeleteAction class


use Carbon\Carbon;
use App\Models\Order;
use App\Models\Building; 
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;

class Workdone extends Page
{
    
    public Model | string | null $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.workdone';

    public static $label = 'Custom Navigation Label';

    public static ?string $slug = 'custom-url-slug';

    // Ensure that the $title property type matches the one in the parent class
    public static ?string $title = 'Word Done (WWD+)';

    public $building;
    public $buildings;
    public $form;
    public $order_id;
    
    public $maxOrders;

    public function redirectToEditOrder($orderId)
    {
        // Gera a URL para a página de edição de ordem usando a rota do resource
        return redirect()->route('filament.resources.orders.edit', ['record' => $orderId]);
    }

    public function table(Table $table): Table{
    return $table
        ->actions([
            // ...
        ]);
}

    public function mount() {
        // Carrega todos os edifícios com as relações necessárias
        $buildings = Building::with(['orders.service', 'proposal.item_proposal'])->get();            
        $maxOrders = 0;
        // Filtrando edifícios que têm ordens
        $buildings = $buildings->filter(function ($building) {
            return $building->orders->isNotEmpty(); // Mantém apenas edifícios com ordens
        });
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
            
            $maxOrders = $buildings->reduce(function ($carry, $building) {
                return max($carry, $building->orders->where('status', 'DONE')->count());
            }, 0);          
        }
        $this->buildings = $buildings;
        $this->maxOrders = $maxOrders;      
    }  
}
   
    
    