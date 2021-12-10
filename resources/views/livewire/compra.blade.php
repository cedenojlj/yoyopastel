<div class="container">


    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Crear Compra') }}</div>

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

                    @if ($errorMaterial)

                    <div class="alert alert-danger">

                        <p>Material no encontrado</p>

                    </div>

                    @endif


                    @if (!$mostrar)


                    <form>
                        <div class="form-group row">
                            <div class="col-sm-5 dropdown">
                                <input type="search" wire:model="search" class="form-control" id="search"
                                    placeholder="Proveedor" autocomplete="off">

                                <div class="drop-content">
                                    @if (!empty($proveedores))
                                    <ul>
                                        @foreach ($proveedores as $proveedor)
                                        <li>{{ $proveedor->nombre }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>



                            </div>
                            <button type="button" wire:click="buscarProveedor"
                                class="btn btn-primary mb-2">Buscar</button>
                        </div>

                    </form>

                    @endif


                    @if ($mostrar)

                    <div class="row">

                        <div class="col-md-3">
                            <h5>Rif:</h5>
                            {{ $proveedor->rif }}
                        </div>
                        <div class="col-md-3">
                            <h5>Proveedor:</h5>
                            {{ $proveedor->nombre }}
                        </div>
                        <div class="col-md-3">
                            <h5>Telefono:</h5>
                            {{ $proveedor->telefono }}
                        </div>

                        <div class="col-md-3">
                            <button type="button" wire:click="cerrarProveedor" class="btn btn-danger"><i
                                    class="far fa-trash-alt"></i></button>
                        </div>
                    </div>

                    @endif



                    <div class="row justify-content-between ml-1 mt-5">

                        <h3>Carga de Materiales</h3>

                        <form>

                            
                            {{-- materiales --}}

                            <div class="form-row">

                                <div class="col-md-12 mb-2">
    
                                    <button type="button" wire:click="cargarMaterial" class="btn btn-primary">Nuevo</button>
    
                                </div>

                                <div class="col-md-5 mt-2">

                                    <label for="material" class="form-label">Material</label>
                                    <input id="material" wire:model="material" type="text"
                                            class="form-control @error('material') is-invalid @enderror" name="material"
                                            placeholder="Material" required autocomplete="off">
    
                                        <div class="drop-content materialesCarga">
                                            @if (!empty($materiales))
                                            <ul>
                                                @forelse ($materiales as $material)
                                                <li>{{ $material->nombre }}</li>
                                                @empty
                                                <li>sin resultados</li>
                                                @endforelse
                                            </ul>
                                            @endif
                                        </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input id="cantidad" wire:model="cantidad" type="number"
                                            class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                            value="{{ old('cantidad') }}" required step="0.01" placeholder="1">
    
                                </div>
    
                                <div class="col-md-2 mt-2">
                                    <label for="costo" class="form-label">Costo</label>
                                    <input id="costo" wire:model="costo" type="number"
                                    class="form-control @error('costo') is-invalid @enderror" name="costo"
                                    value="{{ old('costo') }}" required step="0.01" placeholder="1">
    
    
                                </div>
    
                                <div class="col-md-2 mt-2">

                                    <label for="iva" class="form-label">Iva</label>    
                                    <input id="iva" wire:model="iva" type="number"
                                    class="form-control @error('iva') is-invalid @enderror" name="iva"
                                    value="{{ old('iva') }}" required step="0.01" placeholder="1">
    
                                </div>
    
                                
    
                            </div>

                        </form>

                    </div>


                    <div class="row mt-5">
                        <table class="table ">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Costo</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($listaMateriales as $index => $item)

                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $item['nombre'] }}</td>
                                    <td>{{ $item['cantidad']}}</td>
                                    <td>{{ $item['costo'] }}</td>
                                    <td>{{ $item['subtotalitem'] }}</td>

                                    <td>
                                        <button type="button" class="btn btn-danger"><i
                                                class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <h5>Subtotal $:</h5>
                        </div>
                        <div class="col-md-4">{{ $subtotal }}</div>
                    </div>
                   
                    <div class="row mt-3">
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <h5>Iva %:</h5>
                        </div>
                        <div class="col-md-4">{{ ($iva/100)*$subtotal }}</div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <h5>Total $:</h5>
                        </div>
                        <div class="col-md-4">{{ $total }}</div>
                    </div>



                    {{-- fin del body card --}}
                </div>
            </div>
        </div>
    </div>



</div>