@extends('layouts.app')

@section('content')

<div class="container">
        <div class="row justify-content-center">
                <div class="col-md-12">
                        <div class="card">
                                <div class="card-header">{{ __('Escoger Empresa') }}</div>

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


                                        <form method="POST" action="{{ route('ventas.pdfempresarial') }}"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group row">
                                                        <label for="empresa_id"
                                                                class="col-md-3 col-form-label text-md-right">{{
                                                                __('Empresa')
                                                                }}</label>



                                                        {{-- Empresa --}}
                                                        <div class="col-md-6">

                                                                <select class="form-control @error('empresa_id') is-invalid @enderror"
                                                                        name="empresa_id" required>

                                                                        <option value=""> --Select-- </option>

                                                                        @foreach ($empresas as $empresa)

                                                                        <option value="{{ $empresa->id }}"> {{
                                                                                $empresa->nombre }}</option>

                                                                        @endforeach

                                                                </select>

                                                                @error('empresa_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                        </div>
                                                </div>


                                                <div class="form-group row">
                                                        <label for="reporte_id"
                                                                class="col-md-3 col-form-label text-md-right">{{
                                                                __('Reporte')
                                                                }}</label>



                                                        {{-- Reporte --}}
                                                        <div class="col-md-6">

                                                                <select class="form-control @error('reporte_id') is-invalid @enderror"
                                                                        name="reporte_id" required>

                                                                        <option value=""> --Select-- </option>

                                                                        <option value="1"> Gestion </option>
                                                                        <option value="2"> Stock Material </option>
                                                                        <option value="3"> Stock Productos </option>                                                                       

                                                                </select>

                                                                @error('reporte_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                        </div>
                                                </div>


                                                <div class="form-group row mb-0 justify-content-left">
                                                        <div class="col-md-4 offset-md-3">
                                                                <button type="submit" class="btn btn-primary">
                                                                        {{ __('Aceptar') }}
                                                                </button>
                                                        </div>
                                                </div>


                                        </form>
                                </div>
                        </div>
                </div>
        </div>
</div>

@endsection