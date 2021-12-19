<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <style>
        table {

            width: 80%;
            border-collapse: collapse;
            margin: auto;
        }

        h1,td,h2 {

            text-align: center;
        }

        th,td {

            padding: 5px;
            height: 40px;
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

    <h1>Reporte de Ganancias y Perdidas</h1>
    <h2>Empresa {{ $nombre }}</h2>
    <h2>Moneda $</h2>

    
    <table>

       
        <tr>
            <th>Ventas</th>
            <td>{{ $ventas }}</td>                
        </tr>

        <tr>
            <th>Costos</th>
            <td>{{ $costos }}</td>                
        </tr>

        <tr>
            <th>Pagos</th>
            <td>{{ $pagos }}</td>                
        </tr>

        <tr>
            <th>Total</th>
            <td>{{ $total }}</td>                
        </tr>
        
        
    </table>
</body>

</html>