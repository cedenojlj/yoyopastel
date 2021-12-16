@extends('layouts.app')

@section('content')

<div class="container">


        <div class="row mt-3">

                <div class="col-md-3">

                        <h5>Codigo:</h5>
                        {{ $producto->codigo }}

                </div>

                <div class="col-md-3">

                        <h5>Producto:</h5>
                        {{ $producto->nombre }}

                </div>


                <div class="col-md-3">

                        <a name="" id="" class="btn btn-primary" href="{{ route('costos.index') }}"
                                role="button">Regresar
                        </a>

                </div>


        </div>



        <div class="row mt-4">

                <table class="table ">
                        <thead class="thead-light">
                                <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Material</th>
                                        <th scope="col">Cantidad</th> 
                                </tr>
                        </thead>
                        <tbody>

                                @foreach ($materiales as $index => $item)

                                <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->codigo }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->cantidad}}</td>                                        
                                       
                                </tr>

                                @endforeach

                        </tbody>
                </table>
        </div>


        {{-- fin del contenedor --}}

</div>

@endsection