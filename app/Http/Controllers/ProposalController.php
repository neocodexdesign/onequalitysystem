<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

use App\Models\Proposal;
use App\Models\Service;

use App\Models\Item_proposal;

use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Mostra a view de impressão para uma proposta específica.
     *
     * @param  Proposal $proposal
     * @return \Illuminate\Http\Response
     */
    public function print(Proposal $proposal)
    {
        //$proposal = Proposal::with(['Item_proposal.item', 'Item_proposal.service'])->find($proposal);
        //$proposal = Proposal::with(['Item_proposal.item', 'Item_proposal.service']);
        $proposal->load(['Item_proposal.item', 'Item_proposal.service']);

        // Agora, você pode usar $proposal com as relações carregadas para o que precisar,
        // por exemplo, passá-lo para uma view:
        if ($proposal instanceof \App\Models\Proposal) {
            // Agrupar dados conforme necessário para a view
            $uniqueServices = [];
            // Primeiro, colete todos os serviços únicos presentes na proposta
            foreach ($proposal->Item_proposal as $item_proposal) {
                $service = $item_proposal->service->name; // Assumindo que existe um campo 'name' no modelo Service
                $uniqueServices[$service] = true; // Utiliza a chave do array para evitar duplicatas
            }

            $data = [];
            foreach ($proposal->Item_proposal as $item_proposal) {
                $item = $item_proposal->item->name; // Assumindo que existe um campo 'name' no modelo Item
                // Inicializa o item se ele ainda não foi inicializado
                $service = $item_proposal->service->name; // Assumindo que existe um campo 'name' no modelo Service
                $value = $item_proposal->value; // Assumindo que existe um campo 'value' na tabela items_proposals
                if (!isset($data[$item])) {
                    foreach ($uniqueServices as $serviceName => $_) {
                        $data[$item][$serviceName] = null; // ou outro valor padrão que faça sentido
                    }
                }
                // Agrupar por item, depois serviço, e então valor
                $data[$item][$service] = $value;
            }
            //dd($data);
            // Assumindo que você tem uma view 'proposals.print' para renderizar a proposta
            return view('proposals.print', compact('proposal', 'data'));
        } else {
            return view('proposals.print', compact('Proposta com erro'));
        }
    }

    public function tabelaPreco(Proposal $proposal)
    { {
            // Retornando a view com os dados da proposta específica
            //$proposal = Proposal::with('.`item_proposal'); // Carrega uma Proposal com seus Item_proposal relacionados
            $proposal->load(['Item_proposal.item', 'Item_proposal.service']);

            return view('proposals.tabelaPreco', compact('proposal'));
        }
    }
    public function printContract($contract)
    {
        // Gerar a URL para um arquivo no disco público.
        $url = Storage::disk('public')->url($contract);
        return view('proposals.contract', compact('url'));
    }
}
