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
                <div class="card-header">{{ __('Actualizar Tasa') }}</div>

                <div class="card-body">  

                    <form method="POST" action="{{ route('paridads.update',$paridad->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- paridad --}}

                        <div class="form-group row">
                            <label for="paridad" class="col-md-3 col-form-label text-md-right">{{ __('paridad')
                                }}</label>

                            <div class="col-md-6">
                                <input id="paridad" type="number"
                                    class="form-control @error('paridad') is-invalid @enderror" name="paridad"
                                    value="{{ $paridad->paridad }}" required autocomplete="paridad" autofocus step="0.01" placeholder="1">

                                @error('paridad')
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

                                <a name="" id="" class="btn btn-primary" href="{{ route('paridads.index') }}"
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