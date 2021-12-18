@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Clientes</div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success card shadow">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    
                    <div class="row mb-3 justify-content-around">
                        <div class="col-md-7">

                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('clientes.create') }}" role="button">Crear</a>
                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('clientes.reporte') }}" role="button">Excel</a>

                        </div>
                        <div class="col-md-5">

                            <form class="form-inline" method="GET" 
                            action="{{ route('clientes.search') }}">
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
                                <th scope="col">Nombre</th>
                                <th scope="col">Rif</th>
                                <th scope="col">email</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($clientes as $cliente)

                            <tr>
                                <th scope="row">{{ $cliente->id }}</th>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->rif }}</td>
                                <td>{{ $cliente->email }}</td>
                                

                                <td><form action="{{ route('clientes.destroy', $cliente->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a name="" id="" class="btn btn-success"
                                    href="{{ route('clientes.edit', $cliente->id) }}" role="button"><i class="fas fa-pencil-alt"></i></a>
                                    
                                    @canany(['isSuperadmin','isAdmin'])

                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                                    @endcanany

                                </form></td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    {{ $clientes->links() }}

                   

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection