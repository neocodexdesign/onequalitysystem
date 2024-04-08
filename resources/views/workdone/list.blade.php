<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        body {
            font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;            
        }

        .dateline {
            width: 100%;
            text-align: center;
        }

        .zoom-container {
            transform-origin: top left; /* Define o ponto de origem para o zoom */
            overflow: auto; /* Permite a rolagem se o conteúdo exceder a área visível */
            border: 1px solid #000; /* Para visualização */
        }
        table {
            width: 100%;
            border-collapse: collapse;
           table-layout: fixed;
       }
        th, td {
            border: 1px solid black; /* Apenas para visualização */
            padding: 8px;
            text-align: center;
            word-wrap: break-word; /* Permite quebra de texto dentro da célula */
            min-width: 180px; /* Largura mínima da célula */
            min-height: 50px; /* Altura mínima da célula */
            vertical-align: top; /* Isso faz com que o conteúdo inicie no topo */
            white-space: normal; /* Permite que o texto use mais de uma linha */
            text-overflow: clip; /* Remove a elipse e mostra o texto como está */
        }

        th {
            background-color: #f2f2f2;
        }
        /* Estilos adicionais para as cores de fundo das linhas baseadas no service_id */
        .service-1 { background-color: #D8EAD3; }
        .service-3 { background-color: #FEF2CC; }
        .cleaning {
        background-color: #FEF2CC;
    }
    .title {
        background-color: #F6B26B;
    }
    .non-cleaning {
        background-color: #D8EAD3;
    }
    .empty {
        background-color: white;
    }
    </style>
</head>
<body>
@php 
$maxOrders = $buildings->reduce(function ($carry, $building) {
    return max($carry, $building->orders->where('status', 'DONE')->count());
}, 0);
@endphp
<!-- Botões de Zoom fora do .zoom-container -->
<div>
    <button onclick="zoomIn()">Zoom In (+)</button>
    <button onclick="zoomOut()">Zoom Out (-)</button>
</div>

@php
            $totalColunas = 0;
            foreach ($buildings as $building) {
                // Cada edifício contribui com pelo menos 1 coluna (PAINT).
                $totalColunas += 1;
                
                // Se o edifício tiver ordens de CLEANING, adiciona mais 1 coluna.
                if ($building->hasCleaning) {
                    $totalColunas += 1;
                }
            }
        @endphp
<div id="zoomContainer" class="zoom-container">    
<table>
    <thead>
    <tr>
        <th colspan="{{ $totalColunas }}" style="text-align: center;">APR 1 - APR 6, 2024</th>
    </tr>    
    <tr class="title">
        <th colspan="{{ $totalColunas }}" style="text-align: center;">Work Done</th>
        <!-- Ajuste o valor de colspan para corresponder ao número total de colunas -->
    </tr>
        <tr class="title">            
            @foreach ($buildings as $building)
                <th class="title" {{ $building->hasCleaning ? 'colspan=2' : '' }}>{{ $building->name_wwd }}
                @if ($building->wwdpay) <!-- Acessando um único Wwdpay relacionado -->
                    <br />{{ $building->wwdpay->description }}
                @endif
                </th> <!-- Coluna única ou duas colunas dependendo de hasCleaning -->
            @endforeach
        </tr>
        @if ($buildings->contains->hasCleaning) <!-- Verifica se algum dos edifícios tem ordens de Cleaning -->
            <tr>
                @foreach ($buildings as $building)
                    <th class="title">PAINT</th> <!-- Sempre exibe a coluna PAINT -->
                    @if ($building->hasCleaning)
                        <th class="title">CLEANING</th> <!-- Exibe a coluna Cleaning somente se o edifício tem ordens de Cleaning -->
                    @endif
                @endforeach
            </tr>
        @endif
    </thead>
    <tbody>
    @for ($i = 0; $i < $maxOrders; $i++)
        <tr style="min-height: 50px; min-width: 50px; vertical-align: top;">
            @foreach ($buildings as $building)
                @php
                    $ordersForRow = $building->orders->where('status', 'DONE');
                    $nonCleaningOrder = $ordersForRow->where('service_id', '<>', 3)->skip($i)->first();
                    $cleaningOrder = $ordersForRow->where('service_id', '=', 3)->skip($i)->first();
                @endphp
                <td class="{{ $nonCleaningOrder ? 'non-cleaning' : 'empty' }}">
                    <div style="min-height: 50px; min-width: 150px; !important"></div>
                        @if ($nonCleaningOrder)
                        <!--    {{-- $nonCleaningOrder->service->name_order }} - {{ $nonCleaningOrder->service_value --}} -->
                            {{ $nonCleaningOrder->unit ?? 'N/A' }} ({{ $nonCleaningOrder->size ?? 'N/A' }}) <br /><br />
                            {{ $nonCleaningOrder->description ?? 'N/A' }} ({{ $nonCleaningOrder->description ?? 'N/A' }})<br />
                        @else
                            &nbsp;
                        @endif
                    </div>
                </td>
                @if ($building->hasCleaning)                    
                    <td class="{{ $cleaningOrder ? 'cleaning' : 'empty' }}">
                        <div style="min-height: 50px; min-width: 150px; vertical-align: top !important;"></div>
                            @if ($cleaningOrder)
                                <!-- {{ $cleaningOrder->service->name_order }} - {{ $cleaningOrder->service_value }} -->
                                {{ $nonCleaningOrder->unit ?? 'N/A' }} ({{ $nonCleaningOrder->size ?? 'N/A' }}) <br /><br />
                                {{ $cleaningOrder->description ?? 'N/A' }} ({{ $cleaningOrder->description ?? 'N/A' }}) <br /><br />
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </td>
                @endif
            @endforeach
        </tr>
    @endfor
    </tbody>
</table>
</div>

<script>
let zoomLevel = 1.4; // Nível de zoom inicial é 1 (sem zoom)

function zoomIn() {
    console.log('Zoom In: ', zoomLevel);
    zoomLevel += 0.1; // Aumenta o zoom em 10%
    updateZoom();
}

function zoomOut() {
    console.log('Zoom Out: ', zoomLevel);
    zoomLevel -= 0.1; // Diminui o zoom em 10%
    updateZoom();
}

function updateZoom() {
    const container = document.getElementById('zoomContainer');
    container.style.transform = `scale(${zoomLevel})`;
}
</script>

</body>
</html>
