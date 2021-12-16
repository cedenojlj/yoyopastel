@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Compras</div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success card shadow">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    
                    <div class="row mb-3 justify-content-around">
                        <div class="col-md-7">

                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('compras.create') }}" role="button">Crear</a>
                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('compras.reporte') }}" role="button">Excel</a>

                        </div>
                        <div class="col-md-5">

                            <form class="form-inline" method="GET" 
                            action="{{ route('compras.search') }}">
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
                                <th scope="col">Proveedor</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($compras as $compra)

                            <tr>

                                <th scope="row">{{ $compra->id }}</th>
                                <td>{{ $compra->fecha }}</td>
                                <td>{{ $compra->factura }}</td>
                                <td>{{ $compra->total}}</td>
                                <td>{{ $compra->proveedor->nombre }}</td>
                                

                                <td>
                                    
                                    <form action="{{ route('compras.destroy', $compra->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a name="" id="" class="btn btn-success"
                                        href="{{ route('compras.show', $compra->id) }}" role="button"><i class="fas fa-pencil-alt"></i></a>
                                        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </form>
                            
                                </td>

                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    {{ $compras->links() }}

                   

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection