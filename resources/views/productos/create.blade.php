@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Crear Producto') }}</div>

                <div class="card-body">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                        @csrf

                         {{-- codigo --}}

                        <div class="form-group row">
                            <label for="codigo" class="col-md-3 col-form-label text-md-right">{{ __('Codigo')
                                }}</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text"
                                    class="form-control @error('codigo') is-invalid @enderror" name="codigo"
                                    value="{{ old('codigo') }}" required autocomplete="codigo" autofocus>

                                @error('codigo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- nombre --}}

                        <div class="form-group row">
                            <label for="nombre" class="col-md-3 col-form-label text-md-right">{{ __('Nombre')
                                }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text"
                                    class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                    value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                         {{-- descripcion --}}

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-3 col-form-label text-md-right">{{ __('Descripcion')
                                }}</label>

                            <div class="col-md-6">
                                <input id="descripcion" type="text"
                                    class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                                    value="{{ old('descripcion') }}" required autocomplete="descripcion" autofocus>

                                @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>                        

                        {{-- precio --}}

                        <div class="form-group row">
                            <label for="precio" class="col-md-3 col-form-label text-md-right">{{ __('Precio')
                                }}</label>

                            <div class="col-md-6">
                                <input id="precio" type="number"
                                    class="form-control @error('precio') is-invalid @enderror" name="precio"
                                    value="{{ old('precio') }}" required autocomplete="precio" autofocus step="0.01" placeholder="1">

                                @error('precio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- costo --}}

                        <div class="form-group row">
                            <label for="costo" class="col-md-3 col-form-label text-md-right">{{ __('Costo')
                                }}</label>

                            <div class="col-md-6">
                                <input id="costo" type="number"
                                    class="form-control @error('costo') is-invalid @enderror" name="costo"
                                    value="{{ old('costo') }}" required autocomplete="costo" autofocus step="0.01" placeholder="1">

                                @error('costo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- ganancia --}}

                        <div class="form-group row">
                            <label for="ganancia" class="col-md-3 col-form-label text-md-right">{{ __('Ganancia')
                                }}</label>

                            <div class="col-md-6">
                                <input id="ganancia" type="number"
                                    class="form-control @error('ganancia') is-invalid @enderror" name="ganancia"
                                    value="{{ old('ganancia') }}" required autocomplete="ganancia" autofocus step="0.01" placeholder="1">

                                @error('ganancia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- stock --}}

                        <div class="form-group row">
                            <label for="stock" class="col-md-3 col-form-label text-md-right">{{ __('Stock')
                                }}</label>

                            <div class="col-md-6">
                                <input id="stock" type="number"
                                    class="form-control @error('stock') is-invalid @enderror" name="stock"
                                    value="{{ old('stock') }}" required autocomplete="stock" autofocus placeholder="0">

                                @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- stock minimo --}}

                        <div class="form-group row">
                            <label for="stock_min" class="col-md-3 col-form-label text-md-right">{{ __('stock_min')
                                }}</label>

                            <div class="col-md-6">
                                <input id="stock_min" type="number"
                                    class="form-control @error('stock_min') is-invalid @enderror" name="stock_min"
                                    value="{{ old('stock_min') }}" required autocomplete="stock_min" autofocus placeholder="0">

                                @error('stock_min')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- select categotia_id --}}

                        <div class="form-group row">
                            <label for="categoria_id" class="col-md-3 col-form-label text-md-right">{{ __('Empresa')
                                }}</label>

                            <div class="col-md-6">

                                <select class="form-control @error('salario') is-invalid @enderror" name="categoria_id"
                                    required>

                                    <option value=""> --Select-- </option>

                                    @foreach ($categorias as $categoria)

                                    <option value="{{ $categoria->id }}"> {{ $categoria->nombre }}</option>
                                        
                                    @endforeach    

                                </select>

                                @error('categoria_id')
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

                                <a name="" id="" class="btn btn-primary" href="{{ route('productos.index') }}"
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