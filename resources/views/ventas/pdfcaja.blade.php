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

        h1,
        td,
        h2,
        h3 {

            text-align: center;
        }

        th,
        td {

            padding: 5px;
            height: 40px;
        }

        table,
        td,
        th {

            border: 1px solid black;
        }

        tr:nth-child(even) {

            background-color: #D6EEEE;
        }
    </style>

</head>

<body>

    <h1>Reporte de Caja</h1>
    <h2>Empresa {{ $empresa }}</h2>
    <h3>Empleado {{ $empleado }}</h3>
    <h3>Fecha {{ $fecha }}</h3>

    <h4>Moneda Bolivares</h4>

    <table>

        @foreach ($bolivares as $bolivar)

        <tr>
            <th>{{ $bolivar->metodo }}</th>
            <td>{{ $bolivar->total }}</td>
        </tr>

        @endforeach


        @if ($totalbolivares>0)

        <tr>
            <th>Total</th>
            <td>{{ $totalbolivares }}</td>
        </tr>

        @else

        <p>Sin Resultados</p>

        @endif

    </table>

    <h4>Moneda Dolares</h4>

    <table>

        @foreach ($dolares as $dolar)

        <tr>
            <th>{{ $dolar->metodo }}</th>
            <td>{{ $dolar->total }}</td>
        </tr>

        @endforeach


        @if ($totaldolares>0)

        <tr>
            <th>Total</th>
            <td>{{ $totaldolares }}</td>
        </tr>

        @else

        <p>Sin Resultados</p>

        @endif  

    </table>
</body>

</html>