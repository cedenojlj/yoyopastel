@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Crear Pago') }}</div>

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


                    <form method="POST" action="{{ route('pagos.store') }}">
                        @csrf

                        {{-- pago --}}

                        <div class="form-group row">
                            <label for="pago" class="col-md-3 col-form-label text-md-right">{{ __('pago')
                                }}</label>

                            <div class="col-md-6">
                                <input id="pago" type="number"
                                    class="form-control @error('pago') is-invalid @enderror" name="pago"
                                    value="{{ old('pago') }}" required autocomplete="pago" autofocus step="0.01" placeholder="1">

                                @error('pago')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- referencia --}}

                        <div class="form-group row">
                            <label for="referencia" class="col-md-3 col-form-label text-md-right">{{ __('referencia')
                                }}</label>

                            <div class="col-md-6">
                                <input id="referencia" type="text"
                                    class="form-control @error('referencia') is-invalid @enderror" name="referencia"
                                    value="{{ old('referencia') }}" required autocomplete="referencia" autofocus>

                                @error('referencia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> 

                        {{-- concepto --}}

                        <div class="form-group row">
                            <label for="concepto" class="col-md-3 col-form-label text-md-right">{{ __('concepto')
                                }}</label>

                            <div class="col-md-6">
                                <input id="concepto" type="text"
                                    class="form-control @error('concepto') is-invalid @enderror" name="concepto"
                                    value="{{ old('concepto') }}" required autocomplete="concepto" autofocus>

                                @error('concepto')
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

                                <a name="" id="" class="btn btn-primary" href="{{ route('pagos.index') }}"
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