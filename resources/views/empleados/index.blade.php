@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Empleados</div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success card shadow">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="row mb-3 justify-content-around">
                        <div class="col-md-7">

                            <a name="" id="" class="btn btn-primary" href="{{ route('empleados.create') }}"
                                role="button">Crear</a>
                            <a name="" id="" class="btn btn-primary" href="{{ route('empleados.reporte') }}"
                                role="button">Excel</a>

                        </div>
                        <div class="col-md-5">

                            <form class="form-inline" method="GET" action="{{ route('empleados.search') }}">
                                @csrf
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                            </form>

                        </div>
                    </div>

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Cedula</th>                               
                                <th scope="col">Telefono</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($empleados as $empleado)

                            <tr>
                                <th scope="row">{{ $empleado->id }}</th>
                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->apellido }}</td>
                                <td>{{ $empleado->cedula }}</td>                                
                                <td>{{ $empleado->telefono }}</td>


                                <td>
                                    <form action="{{ route('empleados.destroy', $empleado->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a name="" id="" class="btn btn-success"
                                            href="{{ route('empleados.edit', $empleado->id) }}" role="button"><i
                                                class="fas fa-pencil-alt"></i></a>

                                        @canany(['isAdmin','isSuperadmin'])

                                        <a name="" id="" class="btn btn-info"
                                            href="{{ route('empleados.rolEdit', $empleado->id) }}" role="button"><i
                                                class="far fa-file-alt"></i></a>

                                        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>

                                        @endcanany

                                    </form>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    {{ $empleados->links() }}




                </div>
            </div>
        </div>
    </div>
</div>
@endsection