<?php

namespace App\Filament\Resources\TeamleaderResource\Pages;

use App\Filament\Resources\TeamleaderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamleaders extends ListRecords
{
    protected static string $resource = TeamleaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
