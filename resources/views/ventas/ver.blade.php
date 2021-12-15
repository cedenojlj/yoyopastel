@extends('layouts.app')

@section('content')

<div class="container">


        <div class="row">

                <div class="col-md-3">
                        <h5>Fecha:</h5>
                        {{ $venta->fecha }}
                </div>

                <div class="col-md-3">
                        <h5>Factura:</h5>                       
                        {{str_pad($venta->factura,15,'0',STR_PAD_LEFT)}}
                </div>

                <div class="col-md-3">

                        <a name="" id="" class="btn btn-primary" href="{{ route('ventas.index') }}"
                                role="button">Regresar
                        </a>

                </div>

        </div>

        <div class="row mt-3">

                <div class="col-md-3">
                        <h5>Rif:</h5>
                        {{ $cliente->rif }}
                </div>
                <div class="col-md-3">
                        <h5>Cliente:</h5>
                        {{ $cliente->nombre }}
                </div>
                <div class="col-md-3">
                        <h5>Telefono:</h5>
                        {{ $cliente->telefono }}
                </div>

        </div>



        <div class="row mt-4">

                <table class="table ">
                        <thead class="thead-light">
                                <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Costo</th>
                                        <th scope="col">Subtotal</th>
                                </tr>
                        </thead>
                        <tbody>

                                @foreach ($productos as $index => $item)

                                <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->cantidad}}</td>
                                        <td>{{ $item->precio }}</td>
                                        <td>{{ $item->subtotal }}</td>
                                </tr>

                                @endforeach

                        </tbody>
                </table>
        </div>


        <div class="row mt-3">

                <div class="col-md-2 offset-md-6">
                        <h5>Subtotal $:</h5>
                </div>

                <div class="col-md-2">{{ round($venta->subtotal,2) }}</div>

        </div>

        <div class="row mt-3">

                <div class="col-md-2 offset-md-6">
                        <h5>Iva %:</h5>
                </div>
                <div class="col-md-4">{{ round(($venta->total - $venta->subtotal),2) }}</div>
        </div>

        <div class="row mt-3">

                <div class="col-md-2 offset-md-6">
                        <h5>Total $:</h5>
                </div>
                <div class="col-md-4">{{ round($venta->total,2) }}</div>
        </div>        


        {{-- fin del contenedor --}}

</div>

@endsection