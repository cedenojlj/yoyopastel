@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pagos $</div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success card shadow">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    
                    <div class="row mb-3 justify-content-start">
                        <div class="col-md-12">

                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('pagos.create') }}" role="button">Crear</a>
                            <a name="" id="" class="btn btn-primary" 
                            href="{{ route('pagos.reporte') }}" role="button">Excel</a>

                        </div>                        
                    </div>

                    <div class="row mb-3 justify-content-start">
                        
                        <div class="col-md-12">

                            <form class="form-inline" method="GET" 
                            action="{{ route('pagos.search') }}">
                                @csrf
                                <input class="form-control mr-sm-2" type="text" placeholder="Search"  name="search">
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
                                <th scope="col">Monto $</th>                                
                                <th scope="col">Referencia</th>                                
                                <th scope="col">Concepto</th>                                
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($pagos as $pago)

                            <tr>
                                <th scope="row">{{ $pago->id }}</th>
                                <td>{{ $pago->created_at }}</td>                               
                                <td>{{ $pago->pago }}</td>
                                <td>{{ $pago->referencia }}</td>
                                <td>{{ $pago->concepto }}</td>
                                

                                <td><form action="{{ route('pagos.destroy', $pago->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a name="" id="" class="btn btn-success"
                                    href="{{ route('pagos.edit', $pago->id) }}" role="button"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                </form></td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    {{ $pagos->links() }}

                   

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection