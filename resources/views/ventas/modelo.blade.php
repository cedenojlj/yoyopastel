<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <style>
        table {

            width: 60%;
            border-collapse: collapse;
            margin: auto;
        }

        h1,td {

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

    <h1>hola soy gestion</h1>

    <table class="tabla">
        <thead>
            <tr>
                <th>#</th>
                <th>fecha</th>
                <th>fectura</th>
                <th>subtotal</th>
            </tr>
        </thead>
        <tbody>

           {{--  @foreach ($ventas as $indice => $venta)

            <tr>
                <td>{{ $indice +1 }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->factura }}</td>
                <td>{{ $venta->subtotal }}</td>
            </tr>

            @endforeach --}}

        </tbody>
    </table>


    <table>

       
            <tr>
                <th>Ventas</th>
                <td>{{ $ventas }}</td>                
            </tr>

            <tr>
                <th>Costos</th>
                <td>$1012</td>                
            </tr>

            <tr>
                <th>Pagos</th>
                <td>$1012</td>                
            </tr>

            <tr>
                <th>Total</th>
                <td>$1012</td>                
            </tr>
        
        
    </table>
</body>

</html>