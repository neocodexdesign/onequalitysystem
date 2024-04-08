<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

use App\Models\Event;

class EventsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public $building_name;

    public function __construct($building_name = null)
    {
        $this->building_name = $building_name;
    }

    public function model(array $row)
    {
        // Precisamos buscar na tabela de eventos
        // Se existir um evento que seja unit e paint iguais
        // Passa e nao inclui o registro.

        try {
            $paintDate = Carbon::parse($row[1])->format('Y-m-d');
        } catch (\Exception $e) {
            // Trate o erro, talvez definindo $cleaningDate como null ou uma data padrão
            $paintDate = null; // ou use uma data padrão
        }
        try {
            $cleaningDate = Carbon::parse($row[2])->format('Y-m-d');
        } catch (\Exception $e) {
            // Trate o erro, talvez definindo $cleaningDate como null ou uma data padrão
            $cleaningDate = null; // ou use uma data padrão
        }

        $unit = $row[0]; // Substitua 'valorUnit' pelo valor real que você está buscando
        $paintDate = $paintDate; // Substitua '2024-01-01' pela data real que você está buscando

        $exists = DB::table('events')
            ->where('unit', '=', $unit)
            ->whereDate('paint_date', '=', $paintDate)
            ->exists();

        if (!$exists) {
            try {
                return new Event([
                    'unit' => $row[0],
                    'paint_date' => $paintDate,
                    'cleaning_date' => $cleaningDate,
                    'building' => $this->building_name,
                    'status' => 'IMPORTED FROM EXCEL',
                ]);
            } catch (\Exception $e) {
                Log::error("Erro ao importar linha: ", [$e->getMessage()]);
                return null; // Também retorna null em caso de erro
            }
        } else {
            Log::error("Erro ao importar linha porque a unit nessa data já tem no banco de dados: ", [$e->getMessage()]);
            return null;
        }
    }
}
