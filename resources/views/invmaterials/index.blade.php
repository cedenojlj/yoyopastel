@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Inventario de Materiales</div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success card shadow">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    
                    <div class="row mb-3 justify-content-around">
                        <div class="col-md-7">

                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('invmaterials.create') }}" role="button">Crear</a>
                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('invmaterials.reporte') }}" role="button">Excel</a>

                        </div>
                        <div class="col-md-5">

                            <form class="form-inline" method="GET" 
                            action="{{ route('invmaterials.search') }}">
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
                                <th scope="col">Material</th>
                                <th scope="col">Entrada</th>
                                <th scope="col">Salida</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($invmaterials as $material)

                            <tr>
                                <th scope="row">{{ $material->id }}</th>
                                <td>{{ $material->material->nombre }}</td>
                                <td>{{ $material->entrada }}</td>
                                <td>{{ $material->salida }}</td> 

                                <td><form action="{{ route('invmaterials.destroy', $material->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a name="" id="" class="btn btn-success"
                                    href="{{ route('invmaterials.edit', $material->id) }}" role="button"><i class="fas fa-pencil-alt"></i></a>
                                    
                                    
                                    @canany(['isAdmin','isSuperadmin'])

                                        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                                    @endcanany


                                </form></td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    {{ $invmaterials->links() }}

                   

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection