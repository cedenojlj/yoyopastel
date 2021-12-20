<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <style>
        table {

            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }

        h1,td,h2 {

            text-align: center;
        }

        th,td {

            padding: 5px;
        }

        table,td,th {

            border: 1px solid black;
        }

        tr:nth-child(even) {
            
            background-color: #D6EEEE;
        }

    </style>

</head>

<body>

    <h1>Reporte de Stock de Materiales</h1>
    <h2>Empresa {{ $nombre }}</h2>

    <table class="tabla">
        <thead>
            <tr>
                <th>#</th>
                <th>Material</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($materials as $indice => $material)

            <tr>
                <td>{{ $indice +1 }}</td>
                <td>{{ $material->material }}</td>
                <td>{{ $material->entradas }}</td>
                <td>{{ $material->salidas }}</td>
                <td>{{ $material->Stock }}</td>
            </tr>

            @endforeach

        </tbody>
    </table>

    
</body>

</html>