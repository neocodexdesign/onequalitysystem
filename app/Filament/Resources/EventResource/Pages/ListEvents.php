<?php

namespace App\Filament\Resources\EventResource\Pages;

use Illuminate\Contracts\View\View;

use Filament\Actions;
use App\Filament\Resources\EventResource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use App\Models\Event;
use App\Imports\EventsImport;


class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        return view('filament.events.upload');
        // Você pode definir aqui o que acontece quando o modal deve ser aberto
        // Por exemplo, definir alguma variável de estado ou preparar dados
    }

    public $file = '';

    public $building_name = '';

    public function save()
    {
        if ($this->file != '') {
            $import = new EventsImport($this->building_name);
            Excel::import($import, $this->file);
        }
    }
}
