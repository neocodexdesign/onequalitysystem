
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Proposta</title>
    <style>
        /*
            Titulo:
            --------------------------------
            cod de fundo: #367DA2
            cor da fonte do titulo: white;
            cor da borda: white;

            Corpo da Tabela:
            cod de fundo: white;
            cor da fonte: black;
            cor da borda: black;

            Borda Tra'cada
        */

        body
        {
                font-family: 'Trebuchet MS', Arial, sans-serif;
                margin: 0;
                padding: 20px;
        }

        .container {
            text-align: center; /* Para centralizar o texto e conteúdo inline dentro do contêiner */
        }

        .page {
            text-align: center;
            page-break-after: always;
            page-break-inside: avoid;
            margin: 0 auto; /* Centraliza `.page` horizontalmente dentro de `.container` */
            display: inline-block; /* Faz `.page` se comportar como inline para centralização */
        }

        .border-table {
            margin: 0 auto; /* Centraliza a tabela dentro de `.page` se necessário */
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


        table {
            border-collapse: collapse;
        }
        td {
            border: 1px dashed #000;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #367DA2;
            color: white;
            white-space: nowrap; /* Mantém o conteúdo dos cabeçalhos na mesma linha, ajuste conforme necessário */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-center th, .table-center td {
            text-align: center;
            min-width: 100px; /* Ajuste conforme necessário */
        }

        /* Para ajustar o tamanho específico de colunas, você pode usar classes adicionais ou IDs */
        .paint-date, .cleaning-date {
            min-width: 150px; /* Exemplo de largura específica para datas */
        }

        @page {
            size: A4;
            margin: 0;
        }

        .custom-table {
            width: 100%;
            table-layout: fixed; /* Importante para fixar o layout da tabela */
        }

        .custom-table th:first-child, .custom-table td:first-child {
            width: 30%; /* Define o tamanho da primeira coluna */
        }

        /* Para garantir que a impressão também esteja centralizada */
        @media print {
            white-space: pre-line; /* Assegura que as quebras de linha sejam respeitadas */

            .title_estimate, th, .body_estimate, tr:nth-child(even) {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            td {
                border: 1px dashed #000 !important;
            }
            body, .page, table, th, td {
                visibility: visible !important;
            }

            table {
                page-break-inside: auto;
                page-break-after: auto;
            }

            html, body {
                width: 210mm;
                height: 297mm;
            }

            .center-content {
                text-align: center;
            }

            .table-center th, .table-center td {
                text-align: center;
                min-width: 100px; /* Ajuste conforme necessário */
            }

            /* Para ajustar o tamanho específico de colunas, você pode usar classes adicionais ou IDs */
            .paint-date, .cleaning-date {
                min-width: 150px; /* Exemplo de largura específica para datas */
            }

        }

    </style>
</head>
<body>

    <div class="container a4">

        <div class="page">
            <div class="proposal-details center-content">
                <h1>{{ 'Park Lane' }}</h1>
            </div>
            <table class="border-table table-center">
                <thead>
                    <tr>
                        <th>Unit #</th>
                        <th class="paint-date">Paint Date</th>
                        <th class="cleaning-date">Cleaning Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->unit }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->paint_date)->format('m/d/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->cleaning_date)->format('m/d/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
            // Opcional: fechar a aba atual após a impressão
            window.onafterprint = function(){
            window.close();
            };
        }
    </script>

</body>
</html>

