@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <div class="card">
                <div class="card-header">{{ __('Editar Rol Empleado') }}</div>

                <div class="card-body">  

                    {{-- Para cargar los datos del Empleado --}}

                    <div class="row">

                        <div class="col-md-3">
                            <h5>Cedula o Rif:</h5>
                            {{ $empleado->cedula }}

                        </div>

                        <div class="col-md-3">
                            <h5>Nombre:</h5>
                            {{ $empleado->nombre }}

                        </div>

                        <div class="col-md-3">
                            <h5>Apellido:</h5>
                            {{ $empleado->apellido }}

                        </div>

                        <div class="col-md-3">

                            <a name="" id="" class="btn btn-primary" href="{{ route('empleados.index') }}"
                                role="button">Regresar
                        </a>

                        </div>

                    </div>

                   <div class="row mt-3">
                       <div class="col-md-12">

                        <form method="POST" action="{{ route('empleados.rolUpdate',$empleado->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
    
                            {{-- rol --}}
                            
                            <div class="form-group row">
                                <label for="rol" class="col-md-3 col-form-label text-md-right">{{ __('Rol')
                                    }}</label>
    
                                <div class="col-md-6">
    
                                    <select class="form-control @error('rol') is-invalid @enderror" name="rol"
                                        required>
    
                                        <option value=""> --Select-- </option>    
                                            
                                        <option {{ $rol=='superadmin' ? 'selected' : '' }} value="1"> Superadmin</option>                                         
                                        <option {{ $rol=='admin' ? 'selected' : '' }} value="2"> Admin</option>                                         
                                        <option {{ $rol=='user' ? 'selected' : '' }} value="3"> User</option>                                         
                                        <option {{ $rol=='saller' ? 'selected' : '' }} value="4"> Vendedor</option>                                        
                                          
    
                                    </select>
    
                                    @error('rol')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
    
    
    
    
                            <div class="form-group row mb-0 justify-content-center">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Aceptar') }}
                                    </button>
    
                                    <a name="" id="" class="btn btn-primary" href="{{ route('empleados.index') }}"
                                        role="button">Cancel</a>
                                </div>
                            </div>
    
    
                        </form>

                       </div>                       
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection