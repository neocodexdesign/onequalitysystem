<?php

namespace App\Filament\Resources\WwdpayResource\Pages;

use App\Filament\Resources\WwdpayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWwdpay extends EditRecord
{
    protected static string $resource = WwdpayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
