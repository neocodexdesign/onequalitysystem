<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use App\Models\Teamleader;
use App\Models\Order;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    //$event = new Event;
    //$event->name = 'test from app';
    //$event->startDateTime = Carbon\Carbon::now();
    //$event->endDateTime = Carbon\Carbon::now();
    //$event->save();

    public function eventos2()
    {

        // Ajuste o fuso horário para Boston
        $fusoHorario = 'America/New_York'; // Fuso horário de Boston

        // Define o início do dia atual no fuso horário de Boston
        $startOfDay = Carbon::today($fusoHorario);

        // Define o fim do dia atual no fuso horário de Boston
        $endOfDay = Carbon::today($fusoHorario)->endOfDay();

        // Busca eventos que ocorrem no intervalo do dia atual, considerando o fuso horário de Boston
        $eventsToday = Event::get($startOfDay, $endOfDay);

        $crews = Teamleader::get();

        // Suponha que $eventsToday seja sua coleção/array de eventos
        $processedEvents = [];

        foreach ($eventsToday as $event) {
            $locationString = $event->location ?? '';
            $localName = $address = 'Não disponível';

            if ($locationString !== '') {
                $locationParts = explode(',', $locationString, 2);
                $localName = trim($locationParts[0]);
                $address = count($locationParts) >= 2 ? trim($locationParts[1]) : 'Endereço não especificado';
            }

            $summary = $event->summary ?? ''; // Fallback para string vazia se não definido
            $pattern = '/^(\w+)\s+(\d+)/';
            $nome = $numeroDoApartamento = 'Não disponível';

            if (preg_match($pattern, $summary, $matches)) {
                $nome = $matches[1];
                $numeroDoApartamento = $matches[2];
            }
            // Exemplo de checagem condicional
            if ($event->startDateTime !== null) {
                dd($event->startDateTime->format('Y-m-d'));
            } else {
                echo 'Data de início não definida.';
            }

            // Usando o operador de fusão de null (PHP 7.0+)
            echo $event->startDateTime?->format('Y-m-d') ?? 'Data de início não definida.';

            $processedEvents[] = [
                'summary' => $event->summary,
                'localName' => $localName,
                'address' => $address,
                'nome' => $nome,
                'numeroDoApartamento' => $numeroDoApartamento,
            ];
        }

        //dd($events, $startOfDay, $endOfDay);

        // Agora $eventsToday contém todos os eventos para o dia atual

        return view('calendar.listEvents', ['events' => $processedEvents]);
    }


    public function eventos()
    {

        $fusoHorario = 'America/New_York'; // Fuso horário de Boston
        $startOfDay = Carbon::today($fusoHorario);
        $endOfDay = Carbon::today($fusoHorario)->endOfDay();
        // Define o início e o fim do intervalo de datas desejado
        $startOfDay = Carbon::today($fusoHorario)->startOfDay();
        $endOfDay = Carbon::today($fusoHorario)->endOfDay();
        // Busca eventos que ocorrem no intervalo do dia atual
        $eventsToday = Event::get($startOfDay, $endOfDay);

        $processedEvents = $eventsToday->map(function ($event) {

            $locationString = $event->location ?? '';
            $localName = $address = 'Não disponível';

            if ($locationString !== '') {
                $locationParts = explode(',', $locationString, 2);
                $localName = trim($locationParts[0]);
                $address = count($locationParts) >= 2 ? trim($locationParts[1]) : 'Endereço não especificado';
            }

            $summary = $event->summary ?? '';
            $pattern = '/^(\w+)\s+(\d+)/';
            $nome = $numeroDoApartamento = 'Não disponível';
            if (preg_match($pattern, $summary, $matches)) {
                $nome = $matches[1];
                $numeroDoApartamento = $matches[2];
            }

            $event->startDateTime = Carbon::parse('2024-03-27 10:00:00');
            $event->endDateTime = Carbon::parse('2024-03-27 11:00:00');

            return [
                'date' => $event->startDateTime->format('Y-m-d'), // Assumindo que startDateTime é um objeto Carbon
                'summary' => $summary,
                'localName' => $localName,
                'address' => $address,
                'nome' => $nome,
                'numeroDoApartamento' => $numeroDoApartamento,
            ];
        });

        $month = $startOfDay->month;
        $year = $startOfDay->year;

        // Organiza os eventos processados por data para fácil acesso
        $eventsByDay = $processedEvents->groupBy('date');

        return view('calendar.listEvents', compact('eventsByDay', 'year', 'month'));
    }

    public function Calendar(Request $request)
    {
        $dateInput = $request->input('date');
        //$dateInput = $dateInput->addDays(30); // Assume que você pode passar uma data via query string.
        $date = empty($dateInput) ? Carbon::now()->addDays(30) : Carbon::parse($dateInput);
        $month = $date->format('m');
        $year = $date->format('Y');

        // Início do mês corrente alinhado ao dia correto da semana.
        $startOfCalendar = $date->copy()->startOfMonth();
        // Final do mês corrente alinhado ao dia correto da semana.
        $endOfCalendar = $date->copy()->endOfMonth();

        // Ajuste para começar no domingo da semana que contém o primeiro dia do mês.
        $startDayOfWeek = $startOfCalendar->copy()->startOfWeek(Carbon::SUNDAY);
        // Ajuste para terminar no sábado da semana que contém o último dia do mês.
        $endDayOfWeek = $endOfCalendar->copy()->endOfWeek(Carbon::SATURDAY);

        $dayLabels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        $days = [];

        for ($day = $startDayOfWeek; $day->lte($endDayOfWeek); $day->addDay()) {
            $days[] = [
                'date' => $day->copy(),
                'isToday' => $day->isToday(),
                'inMonth' => $day->month == $month,
                'notInMonth' => $startOfCalendar->month != $day->month // Agora usando notInMonth
            ];
        }

        // Supondo que você tenha $startOfCalendar e $endOfCalendar definidos corretamente

        $events = Order::whereBetween('service_date', [$startOfCalendar, $endOfCalendar])
            ->get();

        foreach ($days as &$day) {
            $day['hasEvent'] = $events->first(function ($event) use ($day) {
                $eventDate = Carbon::parse($event->service_date);
                return $eventDate->isSameDay(Carbon::parse($day['date']));
            }) !== null;
        }

        return view('calendar.calendar', compact('date', 'days', 'dayLabels', 'year', 'month', 'events'));
    }
}
