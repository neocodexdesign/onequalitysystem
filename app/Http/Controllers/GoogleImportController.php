<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Task;
use Spatie\GoogleCalendar\Event;

class GoogleImportController extends Controller
{  
    public function import(Request $request)
    {
       
        dd($request);

        $fusoHorario = 'America/New_York'; // Fuso horário de Boston
        $startOfDay = Carbon::today($fusoHorario);
        $endOfDay = Carbon::today($fusoHorario)->endOfDay();
        // Define o início e o fim do intervalo de datas desejado
        $startOfDay = Carbon::today($fusoHorario)->startOfDay();
        $endOfDay = Carbon::today($fusoHorario)->endOfDay();

        // Define o início e o fim do intervalo de datas desejado
        $startOfDay = Carbon::today($fusoHorario)->subDays(30)->startOfDay(); // Inicia 30 dias atrás
        $endOfDay = Carbon::today($fusoHorario)->endOfDay();
        $events = Event::get();
        //dd($events);
        // Supondo que $events seja o resultado de $service->events->listEvents($calendarId, $options)
        foreach ($events as $event) {
          
          $task = new Task();
          $task->title = $event->summary;
          $task->summary = $event->description ?? ''; // Usando operador de coalescência nula para campos opcionais
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
}
/*
O método Event::get() do pacote spatie/laravel-google-calendar é usado para buscar eventos do Google Calendar associado à configuração padrão ou específica que você definiu em sua aplicação Laravel. Por padrão, se nenhum parâmetro é passado para Event::get(), ele busca todos os eventos do calendário principal dentro de um intervalo de tempo padrão definido pela biblioteca.

Personalizando o Período da Busca
Para especificar um período para a busca dos eventos, você pode passar parâmetros adicionais ao método get(). 
Os parâmetros que você pode especificar incluem datas de início e término, 
entre outros filtros suportados pela API do Google Calendar. 
Aqui está como você pode fazer isso:

php
Copy code
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

// Define o período para a busca
$startDateTime = Carbon::now()->startOfDay(); // Início do dia atual
$endDateTime = Carbon::now()->addWeek(1)->endOfDay(); // Fim do dia, uma semana a partir de agora

// Busca eventos no período especificado
$events = Event::get($startDateTime, $endDateTime);
Explicação dos Parâmetros
$startDateTime e $endDateTime são instâncias de Carbon que definem o intervalo de tempo dos eventos que você deseja buscar. Carbon é uma biblioteca de manipulação de datas para PHP incluída no Laravel, facilitando o trabalho com datas e horas.

Event::get() aceita estes parâmetros opcionais para personalizar a busca:

DateTimeInterface $startDateTime = null: A data/hora de início para filtrar eventos que começam após essa data/hora.
DateTimeInterface $endDateTime = null: A data/hora final para filtrar eventos que começam antes dessa data/hora.
string|array $queryParameters = []: Parâmetros adicionais de consulta suportados pela API do Google Calendar, como timeZone ou singleEvents.
Observações Importantes
Lembre-se de que as datas de início e término nos parâmetros são usadas para filtrar eventos que começam dentro do intervalo especificado. Eventos que estão em andamento mas começaram antes do startDateTime não serão incluídos.

A utilização de Carbon para definir startDateTime e endDateTime é apenas um exemplo. Você pode usar qualquer objeto que implemente a interface DateTimeInterface para especificar essas datas.

Para mais detalhes sobre os parâmetros que você pode passar e como trabalhar com eventos recorrentes ou de dia inteiro, consulte a documentação oficial da API do Google Calendar.

Ao utilizar Event::get() com parâmetros específicos, você pode personalizar a busca de eventos do Google Calendar para atender às necessidades específicas da sua aplicação.
*/