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

        
        th,
        td {

            padding: 5px;
            height: 22px;
            text-align: left;
        }

        table,
        td,
        th {

            border: 1px solid black;
        }

        .der{

            text-align:right;
        }
        p{
            line-height: 20%;
        }

        .negrita{

            font-weight: bold;
        }

       
    </style>

</head>

<body>

    <h2>Empresa {{ $empresa->nombre }}</h2>
    <p>Rif: {{ $empresa->rif }}</p>
    <p>Dirección: {{ $empresa->direccion }}</p>  
    <p>Fecha: {{ $venta->fecha }}</p>

    <h3>Pedido Nº {{ str_pad($venta->factura,10,'0',STR_PAD_LEFT) }} </h3>
    <p>Entregado a:</p>
    <p>Nombre: {{ $cliente->nombre }}</p>
    <p>Rif: {{ $cliente->rif }}</p>
    

   
    <table class="table">
        <thead>
            <tr>                
                <th>Prod Cant</th>                
                <th>total</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($productos as $indice => $producto)

            <tr>                
                
                <td>{{ $producto->producto }}</td>
                <td>{{ round($producto->cantidad,2) }}</td>
                <td>{{ round($producto->precio*$venta->paridad,2) }}</td>                
                <td>{{ round($producto->subtotal*$venta->paridad,2) }}</td>
            </tr>

            @endforeach

            <tr>
                <td colspan="4" class="der negrita">Subtotal:</td>
                <td class="negrita">{{ round($venta->subtotal*$venta->paridad,2) }}</td>                
            </tr>

            <tr>
                <td colspan="4" class="der negrita">Iva:</td>
                <td class="negrita">{{ round((($venta->total - $venta->subtotal)*$venta->paridad),2) }}</td>                
            </tr>

            <tr>
                <td colspan="4" class="der negrita">Total:</td>
                <td class="negrita">{{ round($venta->total*$venta->paridad,2) }}</td>                
            </tr>

        </tbody>
    </table>

</body>

</html>