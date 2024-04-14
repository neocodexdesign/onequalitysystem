<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use App\Models\Task;
use Spatie\GoogleCalendar\Event;
use App\Models\Teamleader;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    public $status; // Adiciona a propriedade status
    public $dateFrom;
    public $dateTo;
    public $statusMessage;
    public $isLoading;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function consistbuildings(Request $request) 
    {
        try {
            $this->isLoading = true;
            $this->statusMessage = 'Processando buildings...';
            $tasks = Task::all();
            set_time_limit(300); 
            
            foreach ($tasks as $task) {
                 // Dividir a location nas suas partes constituintes
                $parts = explode(',', $task->location);
                if (count($parts) < 5) {
                    // Se não tem todas as partes esperadas, talvez trate o erro ou pule este task
                    continue;
                }
                // Remover espaços em branco extras e converter para minúsculas para comparação
                $name = trim($parts[0]);
                $address = trim($parts[1]);
                $city = trim($parts[2]);
                $stateZip = explode(' ', trim($parts[3]), 2); // Espera-se que tenha 2 partes: State e Zip
                if (count($stateZip) < 2) {
                    // Se não tem ambos state e zip, talvez trate o erro ou pule este task
                    continue;
                }
                $state = $stateZip[0];
                $zip = $stateZip[1];
                $country = trim($parts[4]);
                // Verifica se o building já existe nos campos 'name' ou 'name_wwd'
                $buildingExists = DB::table('buildings')
                    ->where(function($query) use ($name) {
                        $query->whereRaw('LOWER(name) = ?', [strtolower($name)])
                            ->orWhereRaw('LOWER(name_wwd) = ?', [strtolower($name)]);
                    })
                    ->exists();
                $name = strtoupper(trim($parts[0]));
                
                if (!$buildingExists) {
                    // Se não existe, cria um novo registro em buildings
                    DB::table('buildings')->insert([
                        'name' => $name,
                        'name_wwd' => $name,
                        'address' => $address,
                        'city' => $city,
                        'state' => $state,
                        'zip' => $zip,
                        'country' => $country,
                        'property_id' => '1',
                        'assistant_id' => '1',
                        'maintenance_id' => '1',
                        'tecHnician_id' => '1',

                    ]);
                }
                
            }        
            $this->statusMessage = 'Buildings processados com sucesso!';
        } catch (\Exception $e) {
            $this->statusMessage = 'Falha na importação: ' . $e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    public function processarTeamLeaders() 
    {
        $tasks = Task::all();
        set_time_limit(300); 
        foreach ($tasks as $task) {
            /*
            // Exemplos de uso
            $titles = [
                'ARTUR 1304*',
                'TIAGO J1603 DOOR',
                'GILMAR B412 / B512 / B611 / B712 / B811',
                'PAULO + CLAUDEMIR G216',
                'A409 / A509 / A609 / A709 / A809 / A909 / A1009 / APH5',
                'Some other format that does not match any pattern'
            ];
            foreach ($titles as $title) {
                $result = parseTitle($title);
                echo "Pintor: " . ($result['painter'] ?? "N/A") . "\n";
                echo "Unidades: " . implode(', ', $result['units']) . "\n";
                echo "Descrição: " . ($result['description'] ?? "Nenhuma descrição") . "\n";
            }
            */
            $result = $this->parseTitle($task->title);                
            $painter = $result['painter'] ?? "N/A";
            if ($painter !== "N/A") {
                $this->ensureTeamLeaderExists($painter);
            }
        }
    }

    function ensureTeamLeaderExists($name) {
        // Verificar se o TeamLeader já existe
        $teamLeader = TeamLeader::where('name', $name)->first();
        // Se não existir, cria um novo
        if (!$teamLeader) {
            $teamLeader = TeamLeader::create(['name' => $name]);
            echo "Novo TeamLeader criado: " . $name . "\n";
        } else {
            echo "TeamLeader existente: " . $name . "\n";
        }
        return $teamLeader;
    }

    public function save(Request $request)
    {
        try {
            set_time_limit(300); 
            $this->isLoading = true;
            $this->statusMessage = 'Importando eventos o Google Calendar...';
            // Acessa as propriedades diretamente
            $dateFrom = $this->dateFrom;
            $dateTo = $this->dateTo;
            $status = $this->status;
            $fusoHorario = 'America/New_York'; // Fuso horário de Boston
            // Converte as datas de entrada para instâncias Carbon, considerando o fuso horário
            $startOfDay = Carbon::createFromFormat('Y-m-d', $dateFrom, $fusoHorario)->startOfDay();
            $endOfDay = Carbon::createFromFormat('Y-m-d', $dateTo, $fusoHorario)->endOfDay();
            // Agora $startOfDay e $endOfDay representam o início e o fim do intervalo de datas fornecido
            // Você pode usar essas variáveis conforme necessário
            // Exemplo: buscar eventos dentro do intervalo de datas
            $events = Event::get($startOfDay, $endOfDay);
            foreach ($events as $event) {
                if (!is_null($event)) {                  
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
            $this->statusMessage = 'Eventos importados com sucesso!';
        } catch (\Exception $e) {
            $this->statusMessage = 'Falha na importação: ' . $e->getMessage();
        } finally {
            $this->isLoading = false;
        }     
    }
  
    public function getHeader(): ?View
    {
        return view('filament.events.importfromgoogle');
        // Você pode definir aqui o que acontece quando o modal deve ser aberto
        // Por exemplo, definir alguma variável de estado ou preparar dados
    }

    function parseTitle($title) {
        // Remove espaços extras e prepara a string
        $title = trim(preg_replace('/\s+/', ' ', $title));
    
        // Tenta capturar padrões com pintor, unidades e casos especiais
        if (preg_match('/^([a-zA-Z\s]+)(?:\s\+\s[a-zA-Z\s]+)?\s([A-Z0-9]+)(?:\s?\/\s?[A-Z0-9]+)*$/', $title, $matches)) {
            $painter = trim($matches[1]); // Primeiro pintor antes de qualquer '+'
            $unitsString = trim($matches[2]); // String das unidades
    
            // Separa as unidades em um array usando '/'
            $units = array_map('trim', explode('/', $unitsString));
    
            return [
                'painter' => $painter,
                'units' => $units,
                'description' => null // Sem descrição adicional necessária
            ];
        } elseif (preg_match('/^((?:[A-Z0-9]+\s?(?:\/\s?)?)+)$/', $title, $matches)) {
            // Trata caso com apenas unidades
            $units = array_map('trim', explode('/', $title));
    
            return [
                'painter' => null,
                'units' => $units,
                'description' => null
            ];
        } else {
            // Fallback para descrição geral se nenhum padrão for identificado
            return [
                'painter' => null,
                'units' => [],
                'description' => $title // Usa a linha inteira como descrição
            ];
        }
    }
}
    


   /*

    Explicação Detalhada
    Expressões Regulares:
    A primeira expressão regular captura possíveis nomes de pintor seguidos por unidades, permitindo também casos com múltiplos pintores (separados por +) e múltiplas unidades (separadas por /).
    A segunda expressão regular é para capturar strings que contêm apenas unidades sem um pintor claramente identificável.
    O fallback captura qualquer texto que não se encaixe nos padrões como uma descrição geral.
    Manipulação e Saída:
    Cada caso processado tenta extrair e organizar as informações em um formato estruturado, com pintores, unidades e descrições claras.
    Este script agora é capaz de processar uma ampla gama de formatos de entrada e oferece uma maneira robusta de lidar com dados possivelmente inconsistentes ou não padronizados, proporcionando flexibilidade e confiabilidade na manipulação de dados variados.
    */