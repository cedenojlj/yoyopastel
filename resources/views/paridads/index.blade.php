@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tipo de cambio $</div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success card shadow">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    
                    <div class="row mb-3 justify-content-around">
                        <div class="col-md-5">

                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('paridads.create') }}" role="button">Crear</a>
                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('paridads.reporte') }}" role="button">Excel</a>

                        </div>
                        <div class="col-md-7">

                            <form class="form-inline" method="GET" 
                            action="{{ route('paridads.search') }}">
                                @csrf
                                <input class="form-control mr-sm-2" type="date"   name="inicio">
                                <input class="form-control mr-sm-2" type="date"   name="fin">
                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                              </form>

                        </div>
                    </div>

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>                                
                                <th scope="col">Tasa</th>                                
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($paridads as $paridad)

                            <tr>
                                <th scope="row">{{ $paridad->id }}</th>
                                <td>{{ $paridad->created_at }}</td>                               
                                <td>{{ $paridad->paridad }}</td>                               
                                

                                <td><form action="{{ route('paridads.destroy', $paridad->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a name="" id="" class="btn btn-success"
                                    href="{{ route('paridads.edit', $paridad->id) }}" role="button"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                </form></td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    {{ $paridads->links() }}

                   

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection