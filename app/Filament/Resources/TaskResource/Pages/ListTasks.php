<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use App\Models\Teamleader;
use App\Models\Order;
use App\Models\Task;
use App\Models\Building;
use App\Models\Tasklog;

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

    public function exportToOrders() {
        
        $tasks = Task::whereBetween('start', [$this->dateFrom, $this->dateTo])->get();
        //dd($tasks, $this->dateFrom, $this->dateTo);
        // Recuperar todas as Tasks
        //tasks_logs
        foreach ($tasks as $task) {
            // Criar uma nova Logs
            $errors = []; // Array para coletar erros
            // Extração do nome do prédio
            $location = $task->location;
            $commaPosition = strpos($location, ',');
            if ($commaPosition === false) {
                $errors[] = "Localização sem vírgula: {$location}";
                continue;
            }
            $buildingName = strtoupper(substr($location, 0, $commaPosition));
            // Busca na tabela Buildings
            try {
                $building = Building::where('name', $buildingName)->firstOrFail();
                $task->building_id = $building->id;
                $task->save();
            } catch (ModelNotFoundException $e) {
                // Gravação do log se não encontrar o prédio
                TaskLog::create(['message' => "Building not found: {$buildingName}"]);
                $errors[] = "Building not found: {$buildingName}";
            }    
            //$result = $this->parseTitle($task->title);                
            list($team, $unit, $additional) = $this->parseTitleEmilio($task->title);
            //return [$team, $unit, $additional];
            // if ($task->id === 275) {
            //  dd($task->title, $team, ($team !== "N/A"), $team, $unit, $additional);          
            // }

            if ($team !== "N/A") {
                $this->ensureTeamLeaderExists($team);
                list($bed_part, $complement_size) = $this->normalizeBed($task->description); 
                $teamLeader = TeamLeader::where('name', $team)->first();
                
                $task->unit = $unit;
                $task->size = $task->description;
                $task->size_complement = $complement_size;
                $task->teamleader_id = $teamLeader->id;
                $task->descriptionTask = $additional;      
                $task->save();
            }        
        }    
        // Exibindo erros após processamento
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } 
        if (empty($errors)) {
            foreach ($tasks as $task) {
                // Criar uma nova Order com dados mapeados de Task
                //dd([
                //    'unit' => $task->size, // Descrição da Task mapeada para unit em Order
                //    'building_id' => $task->building_id, // Localização da Task mapeada para building_id em Order
                //    'teamleader_id' => $task->teamleader_id, // Título da Task mapeado para teamleader_id em Order
                //    'service_id' => 1, // Exemplo fixo, você pode precisar de lógica adicional aqui
                //    'description' => $task->descriptionTask, // Descrição da Task mapeada para description em Order
                //    'service_date' => $task->start, // Data de início da Task mapeada para service_date em Order
                //    'notes' => $task->summary, // Resumo da Task mapeado para notes em Order
                //    'from' => $task->created, // Data de criação da Task mapeada para from em Order
                //    'status' => 'CREATED', // Status da Task mapeado para status em Order
                //    'size' => $task->size, // Este campo precisa ser determinado, deixado como null por enquanto
                //]);
                if ($task->unit !== 'NOORDERS') {
                    Order::create([
                        'unit' => $task->unit, // Descrição da Task mapeada para unit em Order
                        'building_id' => $task->building_id, // Localização da Task mapeada para building_id em Order
                        'teamleader_id' => $task->teamleader_id, // Título da Task mapeado para teamleader_id em Order
                        'service_id' => 1, // Exemplo fixo, você pode precisar de lógica adicional aqui
                        'description' => $task->descriptionTask, // Descrição da Task mapeada para description em Order
                        'service_date' => $task->start, // Data de início da Task mapeada para service_date em Order
                        'notes' => $task->summary, // Resumo da Task mapeado para notes em Order
                        'from' => 'From Tasks - Export to Orders', // Data de criação da Task mapeada para from em Order
                        'startDate' => $task->created, // Data de criação da Task mapeada para from em Order
                        'status' => 'DONE', // Status da Task mapeado para status em Order
                        'size' => $task->size, // Este campo precisa ser determinado, deixado como null por enquanto
                        'description_original' => $task->description,
                        'title_original' => $task->title,
                    ]);
                }
            }       
        }
    }

    function parseSizeDescription($x) {
        // Verifica se a string segue o padrão já conhecido
        if (preg_match('/^(\d+BED)\b(.*)$/i', $x, $matches)) {
            $size = $matches[1];
            $description = trim($matches[2]);
            return [$size, $description];
        }
    
        // Novo padrão para capturar casos problemáticos específicos
        // Tenta capturar unidades como 'J1603', '6-313', '10-205', etc.
        if (preg_match('/([A-Z]?[0-9]+[-]?[A-Z0-9]*)/i', $x, $matches)) {
              $unitNumber = $matches[1];
            dd($unitNumber);
            // Remove o número da unidade da descrição original para isolá-lo como size
            $description = trim(str_replace($unitNumber, '', $x));
            return [$unitNumber, $description];
        }
    
        // Retorna o original se nenhum padrão for reconhecido
        return [null, $x];
    }
    
   

    function normalizeBed($x) {
        if (preg_match('/^(\d+BED)\b(.*)$/i', $x, $matches)) {
            $size = $matches[1];
            $description = trim($matches[2]);
            return [$size, $description];
        }
        return [null, $x];  // Retorna a entrada original como descrição se não corresponder ao padrão.
    }
   

    public function consistbuildings(Request $request) 
    {
        try {
            $this->isLoading = true;
            $this->statusMessage = 'Processando buildings...';
            $tasks = Task::whereBetween('start', [$this->dateFrom, $this->dateTo])->get();
            //$tasks = Task::all();
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
        //$tasks = Task::all();
        $tasks = Task::whereBetween('start', [$this->dateFrom, $this->dateTo])->get();
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
            $teamLeader = TeamLeader::create(['name' => $name, 'user_id' => 1]);
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
  
/*

    function parseTitle($title) {
        // Limpa espaços iniciais e finais e normaliza espaços internos
        $title = trim(preg_replace('/\s+/', ' ', $title));
    
        // Expressão regular ajustada para capturar "2BED" seguido por qualquer coisa
        if (preg_match('/^(\d+BED)\b(.*)$/i', $title, $matches)) {
            $size = $matches[1]; // O tamanho capturado, e.g., "2BED"
            $description = trim($matches[2]); // Restante da descrição, removendo espaços iniciais
    
            return [
                'painter' => null, // Não identificado
                'units' => [$size], // A unidade é o número seguido de "BED"
                'description' => $description // Restante do texto após "BED"
            ];
        } else {
            // Caso não encontre o padrão esperado
            return [
                'painter' => null,
                'units' => [], // Sem unidades identificadas
                'description' => $title // Toda a entrada como descrição
            ];
        }
    }*/


    function parseTitle($title) {
        // Remove espaços extras e prepara a string
        $title = trim(preg_replace('/\s+/', ' ', $title));
    
        // Regex ajustada para capturar padrões de unidade como 'J1603', 'G308', etc.
        if (preg_match('/\b([A-Z]\d+[-]?[A-Z0-9]*)\b/i', $title, $matches)) {
            $unit = $matches[1];
            $description = trim(str_replace($unit, '', $title)); // Remove a unidade da descrição
            return [
                'painter' => null,
                'units' => [$unit],
                'description' => $description
            ];
        }
    
        // Fallback se nenhum padrão de unidade for encontrado
        return [
            'painter' => null,
            'units' => [],
            'description' => $title // Usa a linha inteira como descrição
        ];
    }

    function parseTitleEmilio($title)
    {   
        $string = $title;
        $additional = '';
        $unit = '';

        //335 => quando for somente numero temos uma unidade aqui. 
        if ($this->isAllDigits($string)) {
            $team = '';
            $unit = $string;
        } else {
            // Recebe title e pega as unidades do title primeiro.
            // vai desde o primeiro digito ate o primeiro space.
            // Encontra a posição do primeiro espaço
            // PASTOR 417
            $spacePosition = strpos($string, ' ');
            // Se não houver espaço, retorna a string inteira
            if ($spacePosition === false) {
                $team = $string;
            } else {
                // Retorna a substring desde o início até a posição do primeiro espaço
                list($team, $unit, $additional) = $this->extractThreeParts($string);            
            }
        }
        return [$team, $unit, $additional];
    }

    function extractThreeParts($string) {
        // Remove espaços extras e prepara a string
        $name = '';
        $unit = '';
        $additional = '';
        $string = trim(preg_replace('/\s+/', ' ', $string));
           // Regex para capturar uma palavra seguida por uma sequência opcional de letra e números, e qualquer texto adicional
  
        if (preg_match('/^(\D+?)\s+([A-Z]?\d+-?\d*)\s*(.*)$/i', $string, $matches)) {
            $name = trim($matches[1]);       // Primeira palavra ou grupo de palavras antes do número
            $unit = trim($matches[2]);       // Sequência de número possivelmente precedida por uma letra
            $additional = trim($matches[3]); // Restante da string após a unidade
        } else if (strpos($string, '/') !== false ) {
            $unit = $string;
        } else if (preg_match('/^(Proposal|Rodrigo|Ruana|Meet)\b/i', $string) > 0) {
            $unit = 'NOORDERS';
        } else if (preg_match('/\blobby\b/i', $string) > 0) {
            $unit = 'LOBBY';
        } else {
            $unit = $this->extractUnits($string);
        }               
        return [$name, $unit, $additional];
    }

    function extractUnits($string) {
        // Regex para encontrar sequências de números e padrões de letras seguidos por números
        $pattern = '/\b(\d+|[A-Z]+\d+[A-Z]*)\b/i';
        $matches = []; // Inicializa o array que armazenará as correspondências
        $numMatches = preg_match($pattern, $string, $matches); // Usa preg_match para encontrar a primeira correspondência
        // Verifica se houve correspondências
        if ($numMatches > 0) {
            return $matches[1]; // Retorna a primeira correspondência encontrada como uma string
        } else {
            return null; // Retorna null se não houver correspondências
        }
    }
        
        
/*
CARLOS MAINTENANCE
CARLOS - **TRASH REMOVAL
MIKE'S HOUSE TV MONT
MIKE'S HOUSE *ACCENT WALL
GILMAR - MIRROR PAINT
TIAGO + CARLOS - WALL PANEL INSTALLATION
ALYSON REMOVE CEILING DRYWALL
DRYWALL CEILING REPAIR AND WALL PAINT 
*/


    function isAllDigits($string_input) {
        return ctype_digit($string_input);
    }
}
    
/* Exemplos basicos:
GILMAR B412 / B512 / B611 / B712 / B811
GILMAR B912 / B1012 / BPH11 / B309
TIAGO + CARLOS - WALL PANEL INSTALLATION
PAULO + CLAUDEMIR G216
B405 / B505/ B605 / B705 / B805 / B905 / B1005 / BPH5 
B404 / B504 / B604 / B704 / B805 / B904 / B1004 
TIAGO BASEBOARD OUTSIDE OF 14118 / 14120
ALYSON REMOVE CEILING DRYWALL
PAULO + CLAUDEMIR  G204


PASTOR 417
ARTUR 706 *
PAULO J1014
ALYSON 21-217
TIAGO J1603 DOOR
TITO 2016
TITO 2003
PEDRINHO 4121
PAULO 2108
PASTOR 1007
MARCELO 21-203
PAULO 1815
MARCELO 21-108
ALYSON 1106
Dr. TILE 6-313 RENO BACKSPLASH
Dr. TILE 6-107 RENO BACKSPLASH
Dr. TILE  10-205 RENO BACKSPLASH
335 => quando for somente numero temos uma unidade aqui. 
PASTOR 703
PAULO G308 **DRYWALL REPAIR
PASTOR 1408
ALYSON 8-107
PASTOR 313
MARCELO 9-612
PASTOR J305 FIX
ARTUR 437
MARCELO 8-613




        /* Problemas


        B405 / B505/ B605 / B705 / B805 / B905 / B1005 / BPH5 
B404 / B504 / B604 / B704 / B805 / B904 / B1004 
PAULO G308 **DRYWALL REPAIR
PASTOR J305 FIX
PAULO 2110 **FIX
TIAGO 14120 BASEBOARD
A409 / A509 / A609 / A709 / A809 / A909 / A1009 / APH5
A410 / A510 / A610 / A710 / A810 / A910 / A1010 
5305
TIAGO 11AM 809 CHECK THE DOOR
ARTUR 8-411 **(PAINT / PUNCH / CLEAN) + TRASH REMOVAL
431
PASTOR 1603 FIX
PASTOR 417 LIVING ROOM CEILING
TIAGO + FERNANDO 8AM CABINETS 335 **
CLEYTON 6-107 RENO OUTLET
CLEYTON 6-313 RENO OUTLET
CLEYTON  10-205 RENO OUTLET
TIAGO 1PM INSTALL GRAB BAR
RODRIGO - 10:30 WALK WITH JOSH AND ANTONIO
PASTOR 1105 70% RENO DONE
PASTOR 6119 RENO 80% DONE
ALYSON 10-410 HALF BATH CEILING REMOVAL
241 * 
ALYSON 2-507 BATHROOM PATCH
PASTOR 6106 RENO 70% DONE
PAULO G216 FIX
TIAGO 1304* CHANGE VINYL
TIAGO 436 - SINK IS FALLING (FIRST THING IN THE MORNING)
A407 / A507 / A607 / A707 / A807 / A907 / A1007 / APH4
ALYSON 10-410 FINISH HALF BATH CEILING 
A406 / A506 / A606 / A706 / A806 / A906 / A1006 / APH3 
A307 / A308 / A309 / A310 / A311 / A312
A408 / A508 / A608 / A708 / A808 / A908 / A1008 
PASTOR 419  9AM - 12PM CEILING PACTH
    }



}


    


   /*


TIAGO J1603 DOOR
Dr. TILE 6-313 RENO BACKSPLASH
Dr. TILE 6-107 RENO BACKSPLASH
Dr. TILE  10-205 RENO BACKSPLASH
335
PAULO G308 **DRYWALL REPAIR
PASTOR J305 FIX
PAULO 2110 **FIX
TIAGO 14120 BASEBOARD
5305
TIAGO 11AM 809 CHECK THE DOOR
ARTUR 8-411 **(PAINT / PUNCH / CLEAN) + TRASH REMOVAL
431
PASTOR 1603 FIX
PASTOR 417 LIVING ROOM CEILING
TIAGO + FERNANDO 8AM CABINETS 335 **
CLEYTON 6-107 RENO OUTLET
CLEYTON 6-313 RENO OUTLET
CLEYTON  10-205 RENO OUTLET
TIAGO 1PM INSTALL GRAB BAR
PASTOR 1105 70% RENO DONE
PASTOR 6119 RENO 80% DONE
ALYSON 10-410 HALF BATH CEILING REMOVAL
241 * 
ALYSON 2-507 BATHROOM PATCH
PASTOR 6106 RENO 70% DONE
PAULO G216 FIX
TIAGO 1304* CHANGE VINYL
TIAGO 436 - SINK IS FALLING (FIRST THING IN THE MORNING)
ALYSON 10-410 FINISH HALF BATH CEILING 
PASTOR 419  9AM - 12PM CEILING PACTH

   fim

TIAGO J1603 DOOR
Dr. TILE 6-313 RENO BACKSPLASH
Dr. TILE 6-107 RENO BACKSPLASH
Dr. TILE  10-205 RENO BACKSPLASH
335
B405 / B505/ B605 / B705 / B805 / B905 / B1005 / BPH5 
B404 / B504 / B604 / B704 / B805 / B904 / B1004 
PAULO G308 **DRYWALL REPAIR
PASTOR J305 FIX
PAULO 2110 **FIX
TIAGO 14120 BASEBOARD
A409 / A509 / A609 / A709 / A809 / A909 / A1009 / APH5
A410 / A510 / A610 / A710 / A810 / A910 / A1010 
5305
TIAGO 11AM 809 CHECK THE DOOR
ARTUR 8-411 **(PAINT / PUNCH / CLEAN) + TRASH REMOVAL
431
PASTOR 1603 FIX
PASTOR 417 LIVING ROOM CEILING
TIAGO + FERNANDO 8AM CABINETS 335 **
CLEYTON 6-107 RENO OUTLET
CLEYTON 6-313 RENO OUTLET
CLEYTON  10-205 RENO OUTLET
TIAGO 1PM INSTALL GRAB BAR
RODRIGO - 10:30 WALK WITH JOSH AND ANTONIO
PASTOR 1105 70% RENO DONE
PASTOR 6119 RENO 80% DONE
ALYSON 10-410 HALF BATH CEILING REMOVAL
241 * 
ALYSON 2-507 BATHROOM PATCH
PASTOR 6106 RENO 70% DONE
PAULO G216 FIX
TIAGO 1304* CHANGE VINYL
TIAGO 436 - SINK IS FALLING (FIRST THING IN THE MORNING)
A407 / A507 / A607 / A707 / A807 / A907 / A1007 / APH4
ALYSON 10-410 FINISH HALF BATH CEILING 
A406 / A506 / A606 / A706 / A806 / A906 / A1006 / APH3 11
A307 / A308 / A309 / A310 / A311 / A312
A408 / A508 / A608 / A708 / A808 / A908 / A1008 
PASTOR 419  9AM - 12PM CEILING PACTH


    Explicação Detalhada
    Expressões Regulares:
    A primeira expressão regular captura possíveis nomes de pintor seguidos por unidades, permitindo também casos com múltiplos pintores (separados por +) e múltiplas unidades (separadas por /).
    A segunda expressão regular é para capturar strings que contêm apenas unidades sem um pintor claramente identificável.
    O fallback captura qualquer texto que não se encaixe nos padrões como uma descrição geral.
    Manipulação e Saída:
    Cada caso processado tenta extrair e organizar as informações em um formato estruturado, com pintores, unidades e descrições claras.
    Este script agora é capaz de processar uma ampla gama de formatos de entrada e oferece uma maneira robusta de lidar com dados possivelmente inconsistentes ou não padronizados, proporcionando flexibilidade e confiabilidade na manipulação de dados variados.
    */