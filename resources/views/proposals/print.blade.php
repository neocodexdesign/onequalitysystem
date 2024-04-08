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

        body {

                visibility: hidden;
                font-family: 'Trebuchet MS', Arial, sans-serif;
                margin: 0;
                padding: 20px;

            }

            .title_estimate {
                font-family: 'Trebuchet MS', Arial, sans-serif;
                /*font-size: 28px; /* Exemplo de tamanho de fonte */
                font-weight: bold; /* Aplica negrito */
                white-space: pre-wrap; /* Garante que a formatação com <br> seja respeitada na impressão */
                background-color: #367DA2;
                border: 1px solid #fff;
                white-space: pre-line; /* Faz quebras de linha e espaços em branco serem respeitados */
                width: 20%;
            }

            .container {
                width: 100%;
            }

            img {
                max-width: 100%;
                height: auto;
            }
            .title_proposal {
                font-family: 'Trebuchet MS', Arial, sans-serif;
                font-size: 28px; /* Exemplo de tamanho de fonte */
                font-weight: bold; /* Aplica negrito */
            }

        table {
            width: 100%;
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
        @page {
            size: A4;
            margin: 0;
        }

        .page {
            page-break-after: always;
            page-break-inside: avoid;
            margin: 20mm;
        }

        /* Para centralizar a imagem na tela */
        .img-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            /*width: 50%; /* ou a porcentagem desejada */
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

            .title_estimate {
                font-family: 'Trebuchet MS', Arial, sans-serif;
                font-weight: bold; /* Aplica negrito */
                white-space: pre-wrap; /* Garante que a formatação com <br> seja respeitada na impressão */
                background-color: #367DA2 !important;
                border: 1px solid #fff;
                white-space: pre-line; /* Faz quebras de linha e espaços em branco serem respeitados */
                width: 20%;
            }
            .img-center {
                text-align: center;
                width: 100%; /* Ajuste conforme necessário para a impressão */
            }
            .img-center img {
                max-width: 100%;
                height: auto;
            }
            .body_estimate {
                table-layout:fixed;
                overflow: hidden;
                width: 20%;
            }
        }

    </style>
</head>
<body>
    <div class="container">

        <div class="page">
            <!-- Cabeçalho da página 1 -->
            @if($proposal->logo_cover)
                <div class="img-center">
                    <img src="{{ asset('storage/'.$proposal->logo_cover) }}" alt="Capa da Proposta">
                </div>
                <hr />
            @endif

            <br >
            <br >
            <br >
            <br >

            <!-- Conteúdo da página 1 -->
            @if($proposal->image_cover)
                <div class="img-center">
                <img src="{{ asset('storage/'.$proposal->image_cover) }}" alt="Capa da Proposta">
                </div>
            @endif
            <br >
            <br >
            <br >
            <br >
            <br >
            <br >
            <br >
            <br >
            <h1 class="title_proposal">{{ $proposal->titulo_geral }}</h1>
            <p>Prepared for {{ $proposal->contact }}</p>
            {{ $proposal->formatted_updated_at }}
        </div>
        <div class="page">
            @if($proposal->logo_cover)
                <div class="img-center">
                    <img src="{{ asset('storage/'.$proposal->logo_cover) }}" alt="Capa da Proposta">
                </div>
                <hr />
            @endif
            <!-- Conteúdo da página 2 -->
            <!-- Exemplo simples para imagens. Adapte conforme necessário -->
            <p class="title_proposal">{!! $proposal->titulo_description !!}</p>
            <p>{!! $proposal->description !!}</p>
            <p>{!! $proposal->addition_description !!}</p>
            <p>{!! $proposal->additional_notes !!}</p>
        </div>
       <div class="page">
            @if($proposal->logo_cover)
                <div class="img-center">
                    <img src="{{ asset('storage/'.$proposal->logo_cover) }}" alt="Capa da Proposta">
                </div>
                <hr />
            @endif
            <p class="title_proposal">Estimate</p>
            <table class="custom-table">
            <thead  class="title_estimate">
                <tr>
                    <th>Description</th>
                    @foreach($data[array_key_first($data)] as $service => $value)
                        <th class='title_estimate'>{{ $service }}</th> {{-- Quebra de linha nos cabeçalhos --}}
                    @endforeach
                </tr>
            </thead>
            <tbody class='body_estimate'>
                @foreach($data as $item => $services)
                    <tr>
                        <td style="width: 30%">{{ $item }}</td>
                        @foreach($services as $service => $value)
                            <td class="center-content";>${{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <p>{!! $proposal->thanks !!}</p>
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



