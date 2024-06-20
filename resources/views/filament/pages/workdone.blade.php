{{-- resources/views/filament/pages/workdone.blade.php --}}

<x-filament-panels::page>
    @push('head')
        <style>
            body {
                font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif !important;            
            }
            .zoom-container {
                position: relative;
                width: 100vw;  // 100% da largura da viewport
                height: 100vh; // 100% da altura da viewport
                overflow: auto; // Permite a rolagem se necessário
                display: flex;
                justify-content: flex-start; // Alinha o conteúdo à esquerda
                align-items: flex-start; // Ancora o conteúdo no topo do container
            }
            .filament-table-container table {
                width: auto;
                min-width: 100%;
                border-collapse: collapse;
                transform-origin: left top; // Muda o ponto de origem para o canto esquerdo superior
                transition: transform 0.3s ease;
            }
            th, td {
                border: 1px solid #ccc !important;
                text-align: center;
                padding: 10px; /* Espaçamento adequado dentro das células */
            }
            th {
                background-color: #f2f2f2 !important;
            }
            .dateline {
                width: 100%;
                text-align: center;
            }
            /* Estilos adicionais para as cores de fundo das linhas baseadas no service_id */
            .service-1 { background-color: #D8EAD3 !important;; }
            .service-3 { background-color: #FEF2CC !important; }
            .cleaning {
                background-color: #FEF2CC !important;
            }
            .title {
                background-color: #F6B26B !important;
            }
            .non-cleaning {
                background-color: #D8EAD3 !important;
            }
            .empty {
                background-color: white !important;
            }
        </style>        
    @endpush
    {{-- Blade view for the Workdone page --}}
    <div class="container">
        @php 
            $maxOrders = $buildings->reduce(function ($carry, $building) {
                return max($carry, $building->orders->where('status', 'DONE')->count());
            }, 0);
        @endphp
        <div class="flex space-x-2 items-center">
            <!-- Botões aqui -->
            <!-- Botões de Zoom fora do .zoom-container -->
            <x-filament::icon-button
            onclick="zoomIn()"
            icon="heroicon-m-plus"
            color="success"
            label="Zoom + "
            />
            <!-- Botões de Zoom fora do .zoom-container -->
            <x-filament::icon-button
            onclick="zoomOut()"
            icon="heroicon-m-minus"
            color="danger"
            label="Zoom - "
            />
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
            <table style="    
                    border: 1px solid #272626 !important;   
                    width: auto; /* Ajusta automaticamente a largura baseada no conteúdo */
                    min-width: 100%; /* Garante no mínimo a largura do container */
                    border-collapse: collapse; /* Espaços de borda colapsados */
                    transform-origin: center center; /* Ajusta o ponto de origem para o topo e centro */
                    transition: transform 0.3s ease; /* Suaviza a transformação */
                ">
                <thead style="border: 1px solid #272626;">
                    <tr style="background-color: #F6B26B;">
                       <th colspan="{{ $totalColunas }}" style="text-align: center;">Work Done</th>
                    </tr>
                    <tr style="background-color: #F6B26B">
                        <th colspan="{{ $totalColunas }}" style="text-align: center;">APR 1 - APR 6, 2024</th>
                    </tr>

                    <!-- Ajuste o valor de colspan para corresponder ao número total de colunas -->
                    </tr>
                    <tr style="background-color: #F6B26B;">            
                        @foreach ($buildings as $building)
                            <th style="border: 1px solid #272626; background-color: #F6B26B" {{ $building->hasCleaning ? 'colspan=2' : '' }}>{{ $building->name_wwd }}
                            @if ($building->wwdpay) <!-- Acessando um único Wwdpay relacionado -->
                                <br />{{ $building->wwdpay->description }}
                            @endif
                            </th> <!-- Coluna única ou duas colunas dependendo de hasCleaning -->
                        @endforeach
                    </tr>
                    @if ($buildings->contains->hasCleaning) <!-- Verifica se algum dos edifícios tem ordens de Cleaning -->
                        <tr>
                            @foreach ($buildings as $building)
                                <th style="border: 1px solid #272626; background-color: #F6B26B">PAINT</th> <!-- Sempre exibe a coluna PAINT -->
                                @if ($building->hasCleaning)
                                    <th style="border: 1px solid #272626; background-color: #F6B26B">CLEANING</th> <!-- Exibe a coluna Cleaning somente se o edifício tem ordens de Cleaning -->
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
                                    if ($cleaningOrder) {
                                        $cleaningOrder_record = $cleaningOrder->id;
                                    }
                                    if ($nonCleaningOrder) {
                                        $cleaningOrder_record = $nonCleaningOrder->id;
                                    }
                                   
                                @endphp 
                                <td style="{{ $nonCleaningOrder ? 'background-color: #D8EAD3;
                                    border: 1px solid #272626 !important; 
                                    text-align: center;
                                    
                                    ' : 'background-color: defaultColor;                        
                                ' }}">
                                     <div style="min-height: 50px; min-width: 150px; !important">
                                        @if ($nonCleaningOrder)
                                            <div class="flex justify-end">
                                                <button wire:click="editOrder({{ $nonCleaningOrder->id }})">Editar Pedido</button>

                                               
                                            </div>
                                            {{--EditAction
                                                  wire:click="$emit('openWorkdoneEditModal', {{ $record->id }})"
                                                    
                                                $nonCleaningOrder->service->name_order }} - {{ $nonCleaningOrder->service_value --}} 
                                            {{  $nonCleaningOrder->unit ?? 'N/A' }} <br /> ({{ $nonCleaningOrder->size ?? 'N/A' }}) <br /><br />
                                            {{  $nonCleaningOrder->description ?? 'N/A' }}<br /> 
                                        @else
                                            &nbsp;
                                        @endif
                                    </div>
                                </td>
                                @if ($building->hasCleaning) 

                                    <td style="{{ $cleaningOrder ? 'background-color: #FEF2CC;
                                      border: 1px solid #272626 !important; 
                                    text-align: center;
                                   
                                    ' : 'background-color: defaultColor;                        
                                ' }}">

                                    
                                        <div style="min-height: 50px; min-width: 150px; !important">
                                            @if ($cleaningOrder)
                                                <div class="flex justify-end">
                                                    <x-filament::icon-button
                                                        wire:click="$emit('editOrder', {{ $nonCleaningOrder->id }})"  
                                                        icon="heroicon-m-ellipsis-horizontal"
                                                        color="warning"
                                                        tooltip='Edit'
                                                    />
                                                </div>    
                                                

                                                {{-- $cleaningOrder->service->name_order }} - {{ $cleaningOrder->service_value --}} 
                                                {{ $nonCleaningOrder->unit ?? 'N/A' }} ({{ $nonCleaningOrder->size ?? 'N/A' }}) <br /><br />
                                                {{ $cleaningOrder->description ?? 'N/A' }} ({{ $cleaningOrder->description ?? 'N/A' }}) <br /><br />
                                                
                                            @else
                                                &nbsp;
                                            @endif
                                        </div>
                                        
                                @endif
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    
    @push('scripts')   
        <script>
            var currentScale = 1.0; // Escala inicial de 100%
            function zoomIn() {
                currentScale *= 1.1; // Aumenta a escala em 10%
                applyZoom();
            }
            function zoomOut() {
                currentScale = Math.max(0.5, currentScale - 0.1); // Diminui a escala, mínimo de 50%
                applyZoom();
            }
            function applyZoom() {
                var zoomContainer = document.getElementById('zoomContainer');
                zoomContainer.style.transform = `scale(${currentScale})`;
                zoomContainer.style.transformOrigin = 'left top'; // Mantém o ponto de origem à esquerda no topo
            }
            window.addEventListener('resize', adjustZoomToFit);
            function adjustZoomToFit() {
                var zoomContainer = document.getElementById('zoomContainer');
                var scaleWidth = window.innerWidth / zoomContainer.offsetWidth;
                zoomContainer.style.transform = `scale(${scaleWidth})`;
                zoomContainer.style.transformOrigin = 'left top'; // Mantém a tabela ancorada no canto esquerdo superior
            }
          
                document.addEventListener('DOMContentLoaded', function () {
                    // Adicionar listeners para botões, etc.
                    Array.from(document.querySelectorAll('.edit-order-button')).forEach(button => {
                        button.addEventListener('click', () => {
                            window.location.href = button.getAttribute('data-url');
                        });
                    });
                });

                  
        </script>    
    @endpush
</x-filament-panels::page>
