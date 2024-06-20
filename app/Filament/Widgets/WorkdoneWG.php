<?php

namespace App\Filament\Widgets;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Building; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Toggle;

class WorkdoneWG extends Widget
{
    public Model | string | null $model = Order::class;

    protected static string $view = 'filament.widgets.workdone-w-g';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Buildings Administration';

    public static ?string $title = 'Word Done / Orders';
    protected int | string | array $columnSpan = 'full';

    public $building;
    public $buildings;
    public $form;
    public $order_id;
    
    public $maxOrders;
    public function setLazy(bool $isLazy): self
    {
        $this->isLazy = false;
        return $this;
    }

    public function fetchEvents(array $fetchInfo): array
    {
        // Carrega todos os edifícios com as relações necessárias
        $buildings = Building::with(['orders.service', 'proposal.item_proposal'])->get();            

        // Filtrando edifícios que têm ordens
        $filteredBuildings = $buildings->filter(function ($building) {
            return $building->orders->isNotEmpty(); // Mantém apenas edifícios com ordens
        });

        foreach ($filteredBuildings as $building) {
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
            $building->divideColumn = $building->hasPaint && $building->hasCleaning;
        }
        // Calculando o máximo de ordens após todas as modificações
        $maxOrders = $filteredBuildings->reduce(function ($carry, $building) {
            return max($carry, $building->orders->where('status', 'DONE')->count());
        }, 0);
        $this->buildings = $filteredBuildings;
        $this->maxOrders = $maxOrders;     
        return [];
    }
    
    public function mount() {
        $this->fetchEvents([]); // Assegure-se de que fetchEvents é chamado aqui.
    }

    public function redirectToEdit($recordId)
    {
        //admin/workdone-ups/{record}/edit
        //return redirect()->route('filament.resources.orders.edit', ['record' => $recordId]);
        //return redirect()->route('admin.workdone-ups.edit', ['record' => $recordId]);
        return redirect()->route('filament.admin.resources.workdone-ups.edit', ['record' => $recordId]);
    }     

   
}
