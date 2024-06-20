<?php

namespace App\Filament\Resources\WorkdoneUpResource\Pages;

use App\Filament\Resources\WorkdoneUpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkdoneUp extends EditRecord
{
    protected static string $resource = WorkdoneUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
