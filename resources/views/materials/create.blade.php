@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Crear Material') }}</div>

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


                    <form method="POST" action="{{ route('materials.store') }}" enctype="multipart/form-data">
                        @csrf

                         
                        
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
                       

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Aceptar') }}
                                </button>

                                <a name="" id="" class="btn btn-primary" href="{{ route('materials.index') }}"
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