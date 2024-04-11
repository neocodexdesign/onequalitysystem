<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Toggle;

use App\Models\Order;
use Carbon\Carbon;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Order::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Order::with(['service', 'building']) // Pré-carregar as relações
            ->where('service_date', '>=', $fetchInfo['start'])
            ->where('service_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Order $event) {
                $title = $event->unit;
                // Adicionando o nome do teamleader ao título, se disponível
                if ($event->teamleader) {
                    $title .= '-' . $event->teamleader->name; // Assumindo que a coluna 'name' existe em teamleader
                }
                // Adicionando o nome do serviço ao título, se disponível
                if ($event->service) {
                    $title .= '-' . $event->service->name_order; // Assumindo que a coluna 'name' existe em Service
                }
                // Adicionando o nome do prédio ao título, se disponível
                if ($event->building) {
                    $title .= '-' . $event->building->name; // Assumindo que a coluna 'name' existe em Building
                }
                // Supondo que $event->service_date contém '2024-04-01 00:00:00'
                //$title = $event->id;
                //dd($event->service_data, $event->color);
                $dateOnlyEvent =  Carbon::parse($event->service_date)->format('Y-m-d');
                return [
                    'id'    => $event->id,
                    'title' => $title,
                    'start' => $dateOnlyEvent,
                    'color' => $event->color, // override!
                ];
            })
            ->toArray();
    }

    public static function canView(): bool
    {
        return false;
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('unit'),
                    Forms\Components\TextInput::make('status'),
                    Forms\Components\DatePicker::make('service_date'),
                ]),

            Forms\Components\Textarea::make('description'),

            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Select::make('service_id')
                        ->relationship('service', 'name_order')
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name_order')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                        ]),
                    Forms\Components\Select::make('technician_id')
                        ->relationship('teamleader', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                ]),
                            Forms\Components\TextInput::make('phone')
                                ->tel()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                            Toggle::make('receive_email')
                                ->onColor('success')
                                ->offColor('danger'),
                            Toggle::make('receive_sms')
                                ->onColor('success')
                                ->offColor('danger'),
                            Toggle::make('receive_app')
                                ->onColor('success')
                                ->offColor('danger'),
                        ]),
                ]),
        ];
    }
}
