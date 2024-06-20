<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Illuminate\Contracts\View\View;
use App\Imports\OrdersImport;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use App\Models\Order;

use App\Filament\Widgets\WorkdoneWG;



class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WorkdoneWG::class,
        ];
    }
}
