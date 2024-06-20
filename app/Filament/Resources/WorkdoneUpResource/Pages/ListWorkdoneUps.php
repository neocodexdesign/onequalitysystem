<?php

namespace App\Filament\Resources\WorkdoneUpResource\Pages;

use App\Filament\Resources\WorkdoneUpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\WorkdoneWG;

class ListWorkdoneUps extends ListRecords
{
    protected static string $resource = WorkdoneUpResource::class;
    public static ?string $title = 'Word Done';

    protected function getHeaderWidgets(): array
    {
        return [
            WorkdoneWG::class,
        ];
    }

}
