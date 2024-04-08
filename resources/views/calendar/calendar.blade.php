<html>
    <head>
        <style>

.calendar {
    display: flex;
    position: relative;
    padding: 16px;
    margin: 0 auto;
    max-width: 450px;
    background: white;
    border-radius: 4px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    font-family: Poppins, Helvetica, Arial, sans-serif;
    /* font-size: 1.875rem; */
    font-size: 1.3rem;
}

.month-year {
    position: absolute;
    bottom: 92px;
    right: -40px;
    font-size: 2rem;
    line-height: 1;
    font-weight: 300;
    color: #94A3B8;
    transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
}

.year {
    margin-left: 4px;
    color: #CBD5E1;
}

.days {
    display: flex;
    flex-wrap: wrap;
    flex-grow: 1;
    margin-right: 46px;
}

.day-label {
    position: relative;
    flex-basis: calc(14.286% - 2px);
    margin: 1px 1px 12px 1px;
    font-weight: 700;
    font-size: 1.25rem;
    text-transform: uppercase;
    color: #1E293B;
}

.day.dull {
    color: #94A3B8;
}

.day.today {
    color: #0EA5E9;
    font-weight: 600;
}
/*
.day::before {
    content: '';
    display: block;
    padding-top: 50%;
} */

.day:hover {
    background: #E0F2FE;
}
/*
.day .content {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    } */

    .day.dull {
        opacity: 0.3;
       /* color: #CBD5E1;*/
    } /* Ou 'display: none;' para ocultá-los */

    .today { background-color: yellow; } /* Destaca o dia atual */

    .hasEvent { background-color: #D2E3FC; } /* Destaca o dia atual */

    .calendar_title {
        font-size: 1.5775rem;
    }

.day {
    position: relative;
    margin: 3px;
    width: 50px; /* Largura do círculo */
    height: 50px; /* Altura do círculo, tem que ser igual à largura */
    border-radius: 50%; /* Arredonda as bordas para fazer um círculo perfeito */
    cursor: pointer;
    font-weight: 300;
    display: flex;
    align-items: center; /* Centraliza o conteúdo verticalmente */
    justify-content: center; /* Centraliza o conteúdo horizontalmente */
    overflow: hidden; /* Isso garante que nada saia do círculo */
    border-radius: 999px;
}

.day::before {
    content: '';
    display: block;
    padding-top: 50%; /* Mantém a proporção do círculo */
}

.day .content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Ajusta precisamente para o centro */
    width: 100%; /* Ocupa toda a largura do elemento pai */
    text-align: center; /* Garante que o texto esteja centralizado */
}

#events-section .event {
    border: 1px solid #ccc;
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
}
.events-table {
    width: 100%;
    border-collapse: collapse;
}

.events-table th, .events-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.events-table th {
    background-color: #f2f2f2;
}

#events-tooltip {
    max-width: 800px; /* Limita a largura da tooltip */
    box-shadow: 0 2px 4px rgba(0,0,0,0.2); /* Adiciona uma sombra leve */
    font-family: Poppins, Helvetica, Arial, sans-serif;
    font-size: 0.7rem; /* Ajusta o tamanho da fonte para menor */
    color: #333; /* Cor do texto */
}

#events-tooltip h3 {
    font-size: 0.5rem; /* Tamanho específico para títulos dentro do tooltip */
}

#events-tooltip p {
    font-size: 0.3rem; /* Tamanho específico para parágrafos dentro do tooltip */
}


</style>
    </head>
<body>

    <div id="events-tooltip" style="display: none; position: absolute; background-color: white; border: 1px solid #ccc; padding: 10px; border-radius: 5px; z-index: 100;"></div>
    {{-- calendar.blade.php --}}
    <div class="calendar">
        <div class="month-year">
            <span class="month">{{ $date->format('M') }}</span>
            <span class="year">{{ $date->format('Y') }}</span>
        </div>
        @php
            $extraClass = '';
        @endphp
        <div class="days">
            @foreach($dayLabels as $dayLabel)
                <span class="day-label">{{ $dayLabel }}</span>
            @endforeach
            @foreach($days as $day)
                @php
                    $extraClass = $day['notInMonth'] ? 'dull' : '';
                    $extraClass .= $day['isToday'] ? ' today' : '';
                    $extraClass .= $day['hasEvent'] ? ' hasEvent' : '';

                    $classes = ['day'];
                    if ($day['notInMonth']) $classes[] = 'dull';
                    if ($day['isToday']) $classes[] = 'today';
                    if ($day['hasEvent']) $classes[] = 'hasEvent';
                @endphp
                <span class="day {{ $extraClass }} " data-date="{{ $day['date']->format('Y-m-d') }}">
                    <span class="{{ implode(' ', $classes) }}">
                        <span class="content">{{ $day['date']->format('j') }}</span>
                    </span>
                </span>
                {{--
                    <span class="day{{ $extraClass }}" data-date="{{ $day['date']->format('Y-m-d') }}">
                        <span class="day{{ $extraClass }}">
                        <span class="content">{{ $day['date']->format('j') }}</span>
                    </span>
                --}}
                @endforeach
        </div>
    </div>
    <!-- Certifique-se de que este elemento exista no seu HTML/Blade -->
    <div id="events-section">
    <!-- Os detalhes dos eventos serão injetados aqui pelo JavaScript -->
    </div>
    <script>
        document.querySelectorAll('.day').forEach(day => {
            day.addEventListener('click', function() {
                const date = this.getAttribute('data-date');
                console.log(' a proxima e get orders by date ', date);
                if (!date) {
                    return Promise.resolve(`<div>Buscando ordens do dia...</div>`); // Retorna uma promessa resolvida com uma mensagem de erro
                }
                fetch(`/get-orders-by-date?date=${date}`)
                    .then(response => response.json())
                    .then(events => {
                        updateEventsSection(events);
                    })
                    .catch(error => console.error('Erro ao buscar eventos:', error));
            });
        });
        function updateEventsSection(events) {
            const eventsSection = document.getElementById('events-section');
            // Limpa a seção antes de adicionar novos eventos
            eventsSection.innerHTML = events.length > 0 ? '' : '<p>Nenhum evento para este dia.</p>';
            const table = document.createElement('table');
            table.className = 'events-table';
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th>Descrição</th>
                    <th>Serviço</th>
                    <th>Prédio</th>
                    <th>Líder de Equipe</th>
                    <th>Data de Início</th>
                    <th>Data de Fim</th>
                    <th>Status</th>
                </tr>
            `;
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            events.forEach(event => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${event.description}</td>
                    <td>${event.service.name}</td>
                    <td>${event.building.name}</td>
                    <td>${event.teamleader.name}</td>
                    <td>${new Date(event.startDate).toLocaleString()}</td>
                    <td>${new Date(event.endDate).toLocaleString()}</td>
                    <td>${event.status}</td>
                `;
                tbody.appendChild(row);
            });
            table.appendChild(tbody);
            eventsSection.appendChild(table);
        }

        let currentTooltipDate = null; // Guarda a data atualmente mostrada no tooltip
        document.querySelectorAll('.day').forEach(day => {
            day.addEventListener('mouseenter', function(e) {
                const date = this.getAttribute('data-date');
                // Se já estamos mostrando o tooltip para esta data, não faça nada
                if (currentTooltipDate === date) {
                    return;
                }
                currentTooltipDate = date; // Atualiza a data atual do tooltip
                const tooltip = document.getElementById('events-tooltip');
                // Ajusta o posicionamento para evitar sobreposição com o cursor
                const offsetX = 20; // Distância horizontal do cursor
                const offsetY = 20; // Distância vertical do cursor
                tooltip.style.left = `${e.pageX + offsetX}px`;
                tooltip.style.top = `${e.pageY + offsetY}px`;
                fetchEventsForDate(date).then(html => {
                    tooltip.innerHTML = html;
                    tooltip.style.display = 'block';
                });
            });
            day.addEventListener('mouseleave', function() {
                // Reinicializa a data do tooltip quando o mouse sai
                currentTooltipDate = null;
                const tooltip = document.getElementById('events-tooltip');
                tooltip.style.display = 'none';
            });
        });

        let lastRequestedDate = null;
        function fetchEventsForDate(date) {
            if (!date) {
                return Promise.resolve(`<div>Buscando ordens do dia...</div>`); // Retorna uma promessa resolvida com uma mensagem de erro
            }
            lastRequestedDate = date; // Atualiza a última data solicitada
            return fetch(`/get-orders-by-date?date=${date}`)
                .then(response => {
                        if (!response.ok) {
                            throw new Error('Falha na requisição: ' + response.statusText);
                        }
                            return response.json();
                    })
                .then(events => {
                    if (date === lastRequestedDate) {
                        let html = '<div><strong>Eventos:</strong></div>';
                        if (events.length > 0) {
                            console.log(events);
                            html += '<table class="events-table"><thead><tr><th>Service</th><th>Team Leader</th><th>Date</th><th>Description</th><th>Status</th></tr></thead><tbody>';
                                    events.forEach(event => {
                                        html += `<tr>

                                                    <td>${event.service.name_order ?? 'No name for Service'}</td>
                                                    <td>${event.teamleader?.name || ''}</td>
                                                    <td>${event.formatted_service_date }</td>
                                                    <td>${event.description}</td>
                                                    <td>${event.status}</td>
                                                </tr>`;
                                    });
                                html += '</tbody></table>';
                        } else {
                            html = '<div>Nenhum evento encontrado para este dia.</div>';
                        }
                        return html;
                    } else {
                        return ''; // Retorna uma string vazia para evitar atualização do tooltip com dados desatualizados
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar eventos:', error);
                    return '<div>Erro ao buscar eventos.</div>';
                });

        }

        function updateEventsSection(events) {
            const eventsSection = document.getElementById('events-section');
            // A função fetchEventsForDate já retorna HTML formatado, então podemos reutilizá-la aqui
            fetchEventsForDate(events).then(html => {
                eventsSection.innerHTML = html;
            });
        }
    </script>
</body>


{{--
<script>
document.querySelectorAll('.day').forEach(day => {
    day.addEventListener('click', function() {
        const date = this.getAttribute('data-date'); // A data está armazenada como um atributo data-date
        fetch(`/get-orders-by-date?date=${date}`)
            .then(response => response.json())
            .then(events => {
                updateEventsSection(events); // Chama a função para atualizar a seção de eventos
            })
            .catch(error => console.error('Erro ao buscar eventos:', error));
    });
});

function updateEventsSection1(events) {
    const eventsSection = document.getElementById('events-section');
    eventsSection.innerHTML = ''; // Limpa a seção antes de adicionar novos eventos

    if (events.length > 0) {
        events.forEach(event => {
            // Cria elementos HTML para cada evento e os adiciona à seção de eventos
            const eventElement = document.createElement('div');
            eventElement.className = 'event';
            eventElement.innerHTML = `
                <h3>${event.description}</h3>
                <p>Serviço: ${event.service.name}</p>
                <p>Prédio: ${event.building.name}</p>
                <p>Líder de Equipe: ${event.teamleader.name}</p>
                <p>Data de Início: ${new Date(event.startDate).toLocaleString()}</p>
                <p>Data de Fim: ${new Date(event.endDate).toLocaleString()}</p>
                <p>Status: ${event.status}</p>
            `;
            eventsSection.appendChild(eventElement);
        });
    } else {
        eventsSection.innerHTML = '<p>Nenhum evento para este dia.</p>';
    }
}


function updateEventsSection(events) {
    const eventsSection = document.getElementById('events-section');
    eventsSection.innerHTML = ''; // Limpa a seção antes de adicionar novos eventos

    // Cria a tabela e o cabeçalho
    const table = document.createElement('table');
    table.className = 'events-table';
    const thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>Descrição</th>
            <th>Serviço</th>
            <th>Prédio</th>
            <th>Líder de Equipe</th>
            <th>Data de Início</th>
            <th>Data de Fim</th>
            <th>Status</th>
        </tr>
    `;
    table.appendChild(thead);

    const tbody = document.createElement('tbody');

    if (events.length > 0) {
        events.forEach(event => {
            // Cria uma linha para cada evento
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${event.description}</td>
                <td>${event.service.name}</td>
                <td>${event.building.name}</td>
                <td>${event.teamleader.name}</td>
                <td>${new Date(event.startDate).toLocaleString()}</td>
                <td>${new Date(event.endDate).toLocaleString()}</td>
                <td>${event.status}</td>
            `;
            tbody.appendChild(row);
        });
    } else {
        const row = document.createElement('tr');
        row.innerHTML = '<td colspan="7">Nenhum evento para este dia.</td>';
        tbody.appendChild(row);
    }

    table.appendChild(tbody);
    eventsSection.appendChild(table);
}

document.querySelectorAll('.day').forEach(day => {
    day.addEventListener('mouseenter', function(event) {
        const date = this.getAttribute('data-date');
        const eventsPreview = document.getElementById('events-preview');

        fetch(`/get-orders-by-date?date=${date}`)
            .then(response => response.json())
            .then(events => {
                // Aqui, você construiria o HTML da tabela com os dados dos eventos
                let tableHtml = '<table>';
                // Adicione cabeçalhos e linhas à tabela com base em `events`
                tableHtml += '</table>';

                eventsPreview.innerHTML = tableHtml;
                eventsPreview.style.display = 'block';
                eventsPreview.style.left = `${event.clientX}px`;
                eventsPreview.style.top = `${event.clientY}px`;
            })
            .catch(error => console.error('Erro ao buscar eventos:', error));
    });

    day.addEventListener('mouseleave', function() {
        const eventsPreview = document.getElementById('events-preview');
        eventsPreview.style.display = 'none';
    });
});

document.querySelectorAll('.day').forEach(day => {
    day.addEventListener('mouseenter', function(e) {
        const date = this.getAttribute('data-date');
        const tooltip = document.getElementById('events-tooltip');

        // Mostra a tooltip perto do cursor do mouse
        tooltip.style.left = e.pageX + 'px';
        tooltip.style.top = e.pageY + 'px';
        tooltip.style.display = 'block';

        // Busca e mostra os eventos para a data
        fetchEventsForDate(date).then(html => {
            tooltip.innerHTML = html;
        });
    });

    day.addEventListener('mouseleave', function() {
        // Esconde a tooltip quando o mouse sai do elemento
        const tooltip = document.getElementById('events-tooltip');
        tooltip.style.display = 'none';
    });
});

function fetchEventsForDate(date) {
    return fetch(`/get-orders-by-date?date=${date}`)
        .then(response => response.json())
        .then(events => {
            let html = '<div>
                <strong>Eventos:</strong>
            </div>';
            events.forEach(event => {
                html += `<div>${event.description} - ${new Date(event.startDate).toLocaleDateString()}</div>`;
            });
            return html || '<div>Nenhum evento encontrado.</div>';
        })
        .catch(error => {
            console.error('Erro ao buscar eventos:', error);
            return '<div>Erro ao buscar eventos.</div>';
        });
}
--}}
