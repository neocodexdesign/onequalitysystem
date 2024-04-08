<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proposal Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 60px; /* Tamanho da fonte para o título */
            text-align: center; /* Centraliza o título */
            margin: 20px 0; /* Espaçamento acima e abaixo do título */
        }

        table {
            width: 100%; /* Largura total da tabela */
            border-collapse: collapse; /* Colapsa as bordas das células para uma única linha */
            font-size: 12px; /* Tamanho da fonte para o texto dentro da tabela */
        }

        th, td {
            padding: 8px; /* Espaçamento interno nas células da tabela */
            text-align: left; /* Alinhamento de texto para a esquerda */
            vertical-align: top; /* Alinha o conteúdo das células ao topo */
            border-top: 1px solid #84CDC1; /* Cor da borda superior */
            border-bottom: 1px solid #84CDC1; /* Cor da borda inferior */
        }

        th {
            background-color: #B8E2DB; /* Cor de fundo para o cabeçalho da tabela */
            font-weight: bold; /* Texto em negrito para o cabeçalho da tabela */
        }

        td {
            background-color: #D6EEEA; /* Cor de fundo para as células */
        }

        /* Centraliza o texto na coluna "Cost per Unit" */
        td:nth-child(3) {
            text-align: center;
        }

        .service-break td {
            padding-top: 20px; /* Espaçamento extra acima para a linha de quebra de serviço */
            border: none; /* Remove a borda */
        }
        .a4 {
            width: 794px; /* Largura aproximada de uma folha A4 */
            height: 1123px; /* Altura aproximada de uma folha A4 */
            margin: auto; /* Centraliza o formulário na página */
            padding: 20px; /* Espaçamento interno */
            border: 1px solid #D3D3D3; /* Borda para visualizar o contorno do formulário A4 */
            background: white; /* Cor de fundo */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra para um pouco de profundidade (opcional) */
        }

        /* Estilos adicionais para garantir que o background da página seja diferente do formulário, para destacá-lo */
        body {
            background: #f0f0f0;
        }
        @media print {
        .a4 {
            width: 210mm;
            height: 297mm;
            margin: 0;
            page-break-after: always;
        }
    }

    </style>
</head>
    <body>
    <div class="a4">

        <div class="proposal-details">
            <h1>{{ $proposal->building->name }}</h1>
            <section class="building-info">
                <table class="border-table">
                    <!-- Linha para Endereço -->
                    <tr>
                        <td>{{ $proposal->building->address }}</td>
                        <td>Manager: {{ $proposal->building->property->name ?? 'N/A' }}
                            {{ $proposal->building->maintenance->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <!-- Linha para Cidade, Estado e CEP -->
                    <tr>
                        <td>{{ $proposal->building->city }}, {{ $proposal->building->state }} {{ $proposal->building->zip }}</td>
                        <td>Phone: {{ $proposal->building->phone }}</td>
                    </tr>
                    <!-- Linha para Website -->
                    <tr>
                        <td>Website: {{ $proposal->building->website ?? 'N/A' }}</td>
                        <td>Email: {{ $proposal->building->email }}</td>
                    </tr>
                    <!-- Linha para Outras Informações -->
                    <tr>
                        <td colspan="2">Outras informações aqui como vendor café ou outra informação</td>
                    </tr>
                </table>
            </section>
            <br />
            <table class="border-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Service</th>
                        <th>Cost per Unit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->item_proposal as $index => $itemProposal)
                        <tr>
                            <td>{{ $itemProposal->item->name }}</td>
                            <td>{{ $itemProposal->service->name }}</td>
                            <td class="value-center">${{ number_format($itemProposal->value, 2) }}</td>
                            <td>{{ $itemProposal->notes }}</td>
                        </tr>
                        @if (isset($proposal->item_proposal[$index + 1]) && $proposal->item_proposal[$index + 1]->service->name !== $itemProposal->service->name)
                            <tr class="service-break"><td colspan="4"></td></tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <p>{{ $proposal->formatted_updated_at }}</p>
    </div>
    <script type="text/javascript">
        /*window.onload = function() {
            window.print();
            // Opcional: fechar a aba atual após a impressão
            window.onafterprint = function(){
               window.close();
            };
        }*/
    </script>
</body>
</html>
