<?php

namespace App\Filament\Resources\CalendarWidgetResource\Widgets;

use Illuminate\Database\Eloquent\Model; // Garanta que esta linha esteja aqui
use App\Filament\Resources\EventResource;
use Filament\Widgets\Widget;

use Filament\Forms;
use Filament\Forms\Form;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Event; // Seu modelo Event já está sendo importado corretament
use App\Models\Order;
use Filament\Actions\Action;
use Saade\FilamentFullCalendar\Actions;
use Illuminate\Support\Facades\Log;

use Filament\Forms\Components\TextInput;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;


class CalendarWidget extends FullCalendarWidget implements HasForms
{
    public $showModal = false;
    use InteractsWithForms;
    //protected static string $view = 'filament.resources.calendar-widget-resource.widgets.calendar-widget';
    public Model | string | null $model = Event::class;

    // Dentro do seu método de renderização do FullCalendar em CalendarWidget.php

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
            ])
            ->statePath('data');
    }

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\CalendarWidgetResource\Widgets\CalendarWidget::class,
        ];
    }

    public function eventClick($event)
    {

        // Chame um método no componente Livewire para abrir a modal
        $this->emit('openEventModal', $event);
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Order::query()
            ->with(['service', 'building']) // Pré-carregar as relações
            ->where('service_date', '>=', $fetchInfo['start'])
            ->where('service_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Order $event) {
                // Construindo o título
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
                //$title = $event->id;

                // Construção da URL para editar o evento. Substitua 'EventResource' pelo nome do recurso correto se for diferente.
                $url = ''; // Inicializa a variável $url como string vazia para evitar erros se o próximo passo falhar
                return Carbon::parse($value)->format('Y-m-d');

                try {
                    $url = EventResource::getUrl('edit', ['record' => $event->getKey()]);
                } catch (\Exception $e) {
                    Log::error("Erro ao gerar URL para o evento: {$e->getMessage()}");
                }

                return [
                    'title' => $title,
                    'start' => $event->service_date,
                    'end' => $event->service_date,
                    'shouldOpenUrlInNewTab' => false,
                    //'url' => route('events.show', ['id' => $event->id]),
                    'url' => route('events.modal', ['eventId' => $event->id]),

                ];
            })
            ->all();
        // 'url' => route('emilio', ['id' => $event->id]),
        //'url' => EventResource::getUrl(name: 'view', parameters: ['event' => $event]),
        //'url' => EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
        //*$url = View('livewire.event-details-modal', compact('event')),
        //$url = wire:click="$emit('openEventDetailsModal', {{ $event->id }})"
        //'url' => '<a href="{{ $url }}">Visualizar Detalhes</a>'
    }

    protected function view(): Action
    {
        return Actions\ViewAction::make();
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Emilio Dami Silva'),

            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\DateTimePicker::make('starts_at'),
                    Forms\Components\DateTimePicker::make('ends_at'),
                ]),
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
        }
    JS;
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mountUsing(
                    function (Event $record, Forms\Form $form, array $arguments) {
                        dd('emilio');
                        $form->fill([
                            'name' => $record->name,
                            'starts_at' => $arguments['event']['start'] ?? $record->starts_at,
                            'ends_at' => $arguments['event']['end'] ?? $record->ends_at
                        ]);
                    }
                ),
            Actions\DeleteAction::make(),
            /* Actions\ViewAction::make()
                ->record($this->record)
                ->form([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    // ... outros campos do formulário
                ]),*/
        ];
    }
}
