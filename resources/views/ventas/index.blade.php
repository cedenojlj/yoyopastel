@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ventas</div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success card shadow">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    
                    <div class="row mb-3 justify-content-around">
                        <div class="col-md-7">

                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('ventas.create') }}" role="button" target="_blank">Crear</a>
                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('ventas.reporte') }}" role="button">Excel</a>

                        </div>
                        <div class="col-md-5">

                            <form class="form-inline" method="GET" 
                            action="{{ route('ventas.search') }}">
                                @csrf
                                <input class="form-control mr-sm-2" type="text" placeholder="Search"  name="search">
                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                              </form>

                        </div>
                    </div>

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Factura</th>
                                <th scope="col">Total $</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($ventas as $venta)

                            <tr>

                                <th scope="row">{{ $venta->id }}</th>
                                <td>{{ $venta->fecha }}</td>
                                <td>{{ $venta->factura }}</td>
                                <td>{{ $venta->total}}</td>
                                <td>{{ $venta->cliente->nombre }}</td>
                                

                                <td>
                                    
                                    <form action="{{ route('ventas.destroy', $venta->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <a name="" id="" class="btn btn-info"
                                        href="{{ route('ventas.factura', $venta->id) }}" target="_blank" role="button"><i class="far fa-file-alt"></i></a>

                                        <a name="" id="" class="btn btn-success"
                                        href="{{ route('ventas.show', $venta->id) }}" role="button"><i class="fas fa-pencil-alt"></i></a>
                                       
                                        @canany(['isSuperadmin','isAdmin'])

                                        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                                        @endcanany

                                    </form>
                            
                                </td>

                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    {{ $ventas->links() }}

                   

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection