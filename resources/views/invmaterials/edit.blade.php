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
                <div class="card-header">{{ __('Editar Material') }}</div>

                <div class="card-body">  

                    <form method="POST" action="{{ route('invmaterials.update',$invmaterial->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                         {{-- entrada --}}

                        <div class="form-group row">
                            <label for="entrada" class="col-md-3 col-form-label text-md-right">{{ __('Entrada')
                                }}</label>

                            <div class="col-md-6">
                                <input id="entrada" type="number"
                                    class="form-control @error('entrada') is-invalid @enderror" name="entrada"
                                    value="{{ $invmaterial->entrada }}" required autocomplete="entrada" autofocus placeholder="0">

                                @error('entrada')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- salida --}}

                        <div class="form-group row">
                            <label for="salida" class="col-md-3 col-form-label text-md-right">{{ __('Salida')
                                }}</label>

                            <div class="col-md-6">
                                <input id="salida" type="number"
                                    class="form-control @error('salida') is-invalid @enderror" name="salida"
                                    value="{{ $invmaterial->salida }}" required autocomplete="salida" autofocus placeholder="0">

                                @error('salida')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- select material_id --}}

                        <div class="form-group row">
                            <label for="material_id" class="col-md-3 col-form-label text-md-right">{{ __('material')
                                }}</label>

                            <div class="col-md-6">

                                <select class="form-control @error('material_id') is-invalid @enderror" name="material_id"
                                    required>

                                    <option value=""> --Select-- </option>

                                    @foreach ($materials as $material)

                                    <option {{ $material->id==$invmaterial->material_id ? 'selected' : '' }} value="{{ $material->id }}"> {{ $material->nombre }}</option>
                                        
                                    @endforeach    

                                </select>

                                @error('material_id')
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

                                <a name="" id="" class="btn btn-primary" href="{{ route('invmaterials.index') }}"
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