    <x-filament-panels::page>
        Emilio Dami Silva
        <div>
            {{-- Dentro do seu template do Filament --}}
            {{-- Aqui vai o seu FullCalendar ou outro conteúdo --}}
            @livewire(\App\Filament\Resources\CalendarWidgetResource\Widgets\CalendarWidget::class)
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Seu código JavaScript aqui
            });
            </script>
    </x-filament-panels::page>
