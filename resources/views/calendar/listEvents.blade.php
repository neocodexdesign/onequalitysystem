<html>
    <head>
        <style>
        .calendar-grid {
            display: flex;
            flex-wrap: wrap;
        }

        .calendar-day {
            width: 14.28%; /* 100% / 7 days to fill the week */
            padding: 10px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .day-number {
            font-weight: bold;
        }
        </style>
    </head>
<body>

{{-- Supondo que você tenha variáveis $year e $month disponíveis para o título --}}
<h2>Calendário {{ $month }}/{{ $year }}</h2>

@php
    $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
@endphp

@foreach(range(1, 31) as $day)

    @php
        $dateString = sprintf("%s-%02d-%02d", $year, $month, $day);
    @endphp

    @if($eventsByDay->has($dateString))
        <div class="day" style="margin-bottom: 20px;">
            <h3>Dia {{ $day }}</h3>
            @foreach($eventsByDay[$dateString] as $event)
                <div>
                    <p>Evento: {{ $event['summary'] }}</p>
                    <p>Local: {{ $event['localName'] }} - {{ $event['address'] }}</p>
                    <p>Nome: {{ $event['nome'] }}</p>
                    <p>Número do Apartamento: {{ $event['numeroDoApartamento'] }}</p>
                </div>
            @endforeach
        </div>
    @endif
@endforeach




</body>
