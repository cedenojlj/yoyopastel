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
            text-align: center;
        }

        table,
        td,
        th {

            border-top: 1px dashed black;
        }

        .der{

            text-align:right;
        }
        p{
            line-height: 20%;
        }

        .centro{

            text-align:center;

        }

        .negrita{

            font-weight: bold;
        }

        .ticket{

            width: 100%;
        }

       
    </style>

</head>

<body class="ticket">

    <div class="centro">
        
        <h3 class="centro">SENIAT</h3>
        <p class="centro">{{ $empresa->rif }}</p>
        <p class="centro">{{ $empresa->nombre }}</p>    
        <p class="centro">{{ $empresa->direccion }}</p>  

    </div>  
    <p>Facturado a:</p>
    <p>Nombre o Razon Social: {{ $cliente->nombre }}</p>
    <p>Cedula/Rif: {{ $cliente->rif }}</p>
    <p>Direccion Fiscal: {{ $cliente->direccion }}</p>
    
    <p>Factura Nº {{ str_pad($venta->factura,10,'0',STR_PAD_LEFT) }} </p>
    <p>Fecha: {{ $venta->created_at }}</p>
   
    <table class="table">
        <thead>
            <tr>
                
                <th>Producto</th>
                <th>Cantidad</th>                
                <th>BsD</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($productos as $indice => $producto)

            <tr>                
                
                <td>{{ $producto->producto }}</td>
                <td>{{ round($producto->cantidad,2) }}</td>
                {{-- <td>{{ round($producto->precio*$venta->paridad,2) }}</td>  --}}
                <td>{{ round($producto->subtotal*$venta->paridad,2) }}</td>

            </tr>

            @endforeach

            <tr>
                <td colspan="2" class="der negrita">Subtotal:</td>
                <td class="negrita">{{ round($venta->subtotal*$venta->paridad,2) }}</td>                
            </tr>

            <tr>
                <td colspan="2" class="der negrita">Iva:</td>
                <td class="negrita">{{ round((($venta->total - $venta->subtotal)*$venta->paridad),2) }}</td>                
            </tr>

            <tr>
                <td colspan="2" class="der negrita">Total:</td>
                <td class="negrita">{{ round($venta->total*$venta->paridad,2) }}</td>                
            </tr>

        </tbody>
    </table>

    <p class="centro">!!! GRACIAS POR SU COMPRA !!!</p>


</body>

</html>