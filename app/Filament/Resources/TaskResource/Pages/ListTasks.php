<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Illuminate\Http\Request;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use App\Models\Task;
use Spatie\GoogleCalendar\Event;
use Illuminate\Contracts\View\View;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    public $status; // Adiciona a propriedade status
    public $dateFrom;
    public $dateTo;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function save(Request $request)
    {
        {
            // Acessa as propriedades diretamente
            $dateFrom = $this->dateFrom;
            $dateTo = $this->dateTo;
            $status = $this->status;

            $this->validate([
                'dateFrom' => 'required|date',
                'dateTo' => 'required|date|after_or_equal:dateFrom',
                'status' => 'required|in:active,inactive',
            ]);

            $fusoHorario = 'America/New_York'; // Fuso horário de Boston

            // Converte as datas de entrada para instâncias Carbon, considerando o fuso horário
            $startOfDay = Carbon::createFromFormat('Y-m-d', $dateFrom, $fusoHorario)->startOfDay();
            $endOfDay = Carbon::createFromFormat('Y-m-d', $dateTo, $fusoHorario)->endOfDay();

            // Agora $startOfDay e $endOfDay representam o início e o fim do intervalo de datas fornecido
            // Você pode usar essas variáveis conforme necessário

            // Exemplo: buscar eventos dentro do intervalo de datas
            $events = Event::get($startOfDay, $endOfDay);

        //    $fusoHorario = 'America/New_York'; // Fuso horário de Boston
        //    $startOfDay = Carbon::today($fusoHorario);
        //    $endOfDay = Carbon::today($fusoHorario)->endOfDay();
            // Define o início e o fim do intervalo de datas desejado
        //    $startOfDay = Carbon::today($fusoHorario)->startOfDay();
        //    $endOfDay = Carbon::today($fusoHorario)->endOfDay();
    
            // Define o início e o fim do intervalo de datas desejado
        //    $startOfDay = Carbon::today($fusoHorario)->subDays(30)->startOfDay(); // Inicia 30 dias atrás
        //    $endOfDay = Carbon::today($fusoHorario)->endOfDay();
        //    $events = Event::get();
            //dd($events);
            // Supondo que $events seja o resultado de $service->events->listEvents($calendarId, $options)
            foreach ($events as $event) {
              
              $task = new Task();
              $task->title = $event->summary;
              //$task->summary = $event->description ?? ''; // Usando operador de coalescência nula para campos opcionais
              $task->status = $event->status;
              $task->location = $event->location ?? '';
              $task->description = $event->description ?? '';
              $task->url = $event->htmlLink;
              $task->event_id = $event->id;
              $task->kind = $event->kind;
              
              // Para start e end, você precisa verificar se são objetos EventDateTime e extrair a data/hora correta
              $task->start = isset($event->start->dateTime) ? new \DateTime($event->start->dateTime) : new \DateTime($event->start->date);
              $task->end = isset($event->end->dateTime) ? new \DateTime($event->end->dateTime) : new \DateTime($event->end->date);
          
              $task->updated = new \DateTime($event->updated);
              $task->created = new \DateTime($event->created);
          
              $task->save(); // Salva a nova task no banco de dados
    
          }  
        }

        // Lógica para processar os dados do formulário
        // Você pode acessar as propriedades, como $this->dateFrom, $this->dateTo, e $this->status

        // Por exemplo:
        // Sua lógica de salvamento aqui

        // Depois de salvar, você pode redirecionar ou definir uma mensagem de sucesso
        // $this->redirect('/alguma-rota');
        // ou
        // $this->emit('mensagemSucesso', 'Dados salvos com sucesso!');
    }
  
    public function getHeader(): ?View
    {
        return view('filament.events.importfromgoogle');
        // Você pode definir aqui o que acontece quando o modal deve ser aberto
        // Por exemplo, definir alguma variável de estado ou preparar dados
    }
}
