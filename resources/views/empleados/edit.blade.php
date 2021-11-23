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
                <div class="card-header">{{ __('Editar Empleado') }}</div>

                <div class="card-body">  

                    <form method="POST" action="{{ route('empleados.update',$empleado->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="nombre" class="col-md-3 col-form-label text-md-right">{{ __('Nombre')
                                }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text"
                                    class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                    value="{{ $empleado->nombre }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="apellido" class="col-md-3 col-form-label text-md-right">{{ __('Apellido')
                                }}</label>

                            <div class="col-md-6">
                                <input id="apellido" type="text"
                                    class="form-control @error('apellido') is-invalid @enderror" name="apellido"
                                    value="{{ $empleado->apellido }}" required autocomplete="apellido" autofocus>

                                @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cedula" class="col-md-3 col-form-label text-md-right">{{ __('Cedula')
                                }}</label>

                            <div class="col-md-6">
                                <input id="cedula" type="text"
                                    class="form-control @error('cedula') is-invalid @enderror" name="cedula"
                                    value="{{ $empleado->cedula }}" required autocomplete="cedula" autofocus>

                                @error('cedula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="direccion" class="col-md-3 col-form-label text-md-right">{{ __('Direccion')
                                }}</label>

                            <div class="col-md-9">
                                <input id="direccion" type="text"
                                    class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                                    value="{{ $empleado->direccion }}" required autocomplete="direccion" autofocus>

                                @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefono" class="col-md-3 col-form-label text-md-right">{{ __('Telefono')
                                }}</label>

                            <div class="col-md-6">
                                <input id="telefono" type="text"
                                    class="form-control @error('telefono') is-invalid @enderror" name="telefono"
                                    value="{{ $empleado->telefono }}" required autocomplete="telefono" autofocus>

                                @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address')
                                }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $empleado->email }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="salario" class="col-md-3 col-form-label text-md-right">{{ __('Salario')
                                }}</label>

                            <div class="col-md-6">
                                <input id="salario" type="number"
                                    class="form-control @error('salario') is-invalid @enderror" name="salario"
                                    value="{{ $empleado->salario }}" required autocomplete="salario" autofocus step="0.01">

                                @error('salario')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="foto" class="col-md-3 col-form-label text-md-right">{{ __('Foto')
                                }}</label>

                            <div class="col-md-6">
                                <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror"
                                    name="foto" accept="image/*">

                                @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="empresa_id" class="col-md-3 col-form-label text-md-right">{{ __('Empresa')
                                }}</label>

                            <div class="col-md-6">

                                <select class="form-control @error('salario') is-invalid @enderror" name="empresa_id"
                                    required>

                                    <option value=""> --Select-- </option>

                                    @foreach ($empresas as $empresa)

                                    <option {{ $empresa->id==$empleado->empresa_id ? 'selected' : '' }} value="{{ $empresa->id }}"> {{ $empresa->nombre }}</option>
                                        
                                    @endforeach    

                                </select>

                                @error('empresa_id')
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
@endsection