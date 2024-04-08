<?php

namespace App\Filament\Resources\WwdpayResource\Pages;

use App\Filament\Resources\WwdpayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWwdpays extends ListRecords
{
    protected static string $resource = WwdpayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
