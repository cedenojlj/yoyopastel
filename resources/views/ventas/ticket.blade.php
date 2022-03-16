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
            border-top: 1px dashed black;
        }

        
        th,
        td {                    
            text-align: center;
        }

      

        .bordes th{

            border-top: 1px dashed black;

        }

        .bordes td{

            border-top: 1px dashed black;

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

        .margensuperior{

            margin-top: 20px;
        }

       
    </style>

</head>

<body class="ticket">

  {{--   <div class="centro">        
        
        <p class="centro">{{ $empresa->nombre }}</p> 
        <p class="centro">{{ $empresa->rif }}</p>           
        <p class="centro">{{ $empresa->direccion }}</p>
        <h4 class="centro">Orden de Entrega</h4>  

    </div>  --}} 
    
    <table>
                
        <tr><td> {{ $empresa->nombre }}</td></tr>    
        <tr><td> {{ $empresa->rif }}</td></tr>    
        <tr><td> {{ $empresa->direccion }}</td></tr>    

    </table>

    <h4 class="centro">Orden de Entrega</h4>  

   
    <table>

    <tr><td> Entregado a:</td></tr>    
    <tr><td> {{ $cliente->nombre }}</td></tr>
    <tr><td> Cedula/Rif: </td></tr>        
    <tr><td> {{ $cliente->rif }}</td></tr>        
    
    <tr><td>Pedido Nº</td></tr>
    <tr><td>{{ str_pad($venta->factura,10,'0',STR_PAD_LEFT) }} </td></tr>
    <tr><td>Fecha:</td></tr>    
    <tr><td>{{ $venta->created_at }}</td></tr>     

    </table>
       
   
    <table class="table bordes margensuperior">
        <thead>
            <tr>
                
                <th>Producto</th>                             
                <th>BsD</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($productos as $indice => $producto)

            <tr>                
                
                <td>{{ $producto->producto }}x{{ round($producto->cantidad,2) }}</td>                
                {{-- <td>{{ round($producto->precio*$venta->paridad,2) }}</td>  --}}
                <td>{{ round($producto->subtotal*$venta->paridad,2) }}</td>

            </tr>

            @endforeach

            <tr>
                <td class="negrita">Subtotal:</td>
                <td class="negrita">{{ round($venta->subtotal*$venta->paridad,2) }}</td>                
            </tr>

            <tr>
                <td class="negrita">Iva:</td>
                <td class="negrita">{{ round((($venta->total - $venta->subtotal)*$venta->paridad),2) }}</td>                
            </tr>

            <tr>
                <td class="negrita">Total:</td>
                <td class="negrita">{{ round($venta->total*$venta->paridad,2) }}</td>                
            </tr>           

        </tbody>
    </table>

    
        <p class="centro"> !!! GRACIAS POR SU COMPRA !!!</p>
    
    


</body>

</html>