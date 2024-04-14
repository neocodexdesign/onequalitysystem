{{-- resources/views/buildings/print.blade.php --}}
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Buildings List</title>        
        <style>    
            /* styles.css */
            @media screen {
                .content {
                    display: none; /* Oculta todo o conteúdo na tela, mas disponível para impressão */
                }
            }

            /* Estilos específicos para impressão */
            @media print {
                .printable {
                    width: 100%;
                    border-collapse: collapse;
                }

                .printable, .printable th, .printable td {
                    border: 1px solid black;
                    padding: 8px;
                }

                body {
                    width: 210mm; /* Largura do papel A4 */
                    height: 297mm; /* Altura do papel A4 */
                    margin: 10mm; /* Margens para impressão */
                    font-size: 8pt; /* Ajuste o tamanho da fonte conforme necessário */
                    font-family: Arial, sans-serif;
                }

                table {
                    width: 100%;
                    page-break-inside: auto;
                }

                th, td {
                    page-break-inside: avoid;
                    border: 1px solid black;
                }

                /* Garante que o endereço esteja sempre em uma única linha */
                .name {
                    white-space: nowrap; /* Não permite quebra de linha */
                    width: 10%;
                }
                .address {
                    white-space: nowrap; /* Não permite quebra de linha */
                    width: 25%;
                }
                .city {
                    white-space: nowrap; /* Não permite quebra de linha */
                    width: 20%;
                }
                .state {
                    white-space: nowrap; /* Não permite quebra de linha */
                    width: 10%;
                }
                .phone {
                    white-space: nowrap; /* Não permite quebra de linha */
                    align-items: center;
                    width: 20%;
                }

                .clear {
                    clear: both; /* Limpa os floats para elementos seguintes */
                }

                /* Oculta elementos desnecessários para impressão */
                .no-print {
                    display: none;
                }
                
            }
        </style>
    </head>

    <body onload="window.print();">
        <div class="content">
            <table class="printable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buildings as $building)
                    <tr>                        
                        <td style="width: 36%">{{ $building->name }}</td>
                        <td style="width: 24%">{{ $building->address }}</td>
                        <td style="width: 20%; text-align: center;">{{ $building->city }}</td>
                        <td style="width: 5%; text-align: center;">{{ $building->state }}</td>
                        <td style="width: 15%; text-align: center;">{{ $building->phone }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            // script.js
            window.onload = function() {
                window.print();  // Dispara a impressão assim que a página carrega
                window.onafterprint = function() {
                    window.location.href = '/admin/buildings';  // Substitua '/buildings' pelo caminho correto
                }
            }
        </script>
    </body>
</html>

