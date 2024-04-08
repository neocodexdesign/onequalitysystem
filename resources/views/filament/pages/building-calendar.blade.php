<x-filament-panels::page>
    <div>
        {{-- Dentro do seu template do Filament --}}
        <livewire:event-details-modal />
        {{-- Aqui vai o seu FullCalendar ou outro conteúdo --}}
    </div>
</x-filament-panels::page>

<script>
var calendar = new FullCalendar.Calendar(calendarEl, {
    // suas configurações do FullCalendar
    eventContent: function(arg) {
        // Criação do elemento DOM para o evento
        let dom = document.createElement('div');
        dom.innerHTML = `
            <div class="event-inner">
                ${arg.event.title}
                <button onclick="editEvent('${arg.event.id}')">Editar</button>
                <button onclick="deleteEvent('${arg.event.id}')">Excluir</button>
            </div>
        `;

        return { domNodes: [dom] };
    },
});
calendar.render();
</script>
