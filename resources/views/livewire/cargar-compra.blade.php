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

                    @if (session()->has('message'))

                        <div class="alert alert-danger">
                            {{ session('message') }}
                        </div>

                    @endif
                   

                    @if ($errorMaterial)

                    <div class="alert alert-danger">

                        <p>Material no encontrado</p>

                    </div>

                    @endif

                    @if ($errorProveedor)

                    <div class="alert alert-danger">

                        <p>Coloque un proveedor valido</p>

                    </div>

                    @endif

                     {{-- Numero de factura --}}
                   
                     <div class="row mb-3">

                        <div class="col-md-4">
                            <label for="factura" class="form-label">Factura</label>
                            <input type="factura" wire:model="factura" class="form-control" id="factura"
                                placeholder="Numero de factura" autocomplete="off">

                        </div>

                        <div class="col-md-4">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" wire:model="fecha" class="form-control" id="fecha">

                        </div>

                    </div>

                    {{-- busqueda de proveedores --}}

                    @if (!$mostrar)

                    <div class="row">

                        <div class="col-md-12 col-sm-12">

                            <button type="button" wire:click="buscarProveedor"
                                class="btn btn-primary mb-2">Buscar</button>

                        </div>

                        <div class="col-md-6 col-sm-12">

                            <div class="search-input">
                                <input type="search" wire:model="search" class="form-control" id="search"
                                    placeholder="Proveedor" autocomplete="off">

                                <div class="autocom">
                                    @if (!empty($proveedores))
                                    <ul>
                                        @foreach ($proveedores as $proveedor)
                                        <li>{{ $proveedor->nombre }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                {{-- <div class="icon">
                                    <i class="fas fa-search"></i>
                                </div> --}}
                            </div>

                        </div>                       


                    </div>


                    @endif

                   

                    {{-- Mostrar datos del proveedor --}}
                    
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


                    {{-- Mostrar carga de materiales --}}

                    <div class="row justify-content-between ml-1 mt-3">

                        <h3>Carga de Materiales</h3>

                        {{-- materiales --}}

                        <div class="row">

                            <div class="col-md-12 mb-2">

                                <button type="button" wire:click="cargarMaterial" class="btn btn-primary">Nuevo</button>

                            </div>

                            <div class="col-md-6 mt-2">

                                <label for="material" class="form-label">Material</label>
                                <div class="search-input">
                                    <input id="material" wire:model="material" type="text"
                                        class="form-control @error('material') is-invalid @enderror" name="material"
                                        placeholder="Material" required autocomplete="off">

                                    <div class="autocom">
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
                            </div>


                            <div class="col-md mt-2">

                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input id="cantidad" wire:model="cantidad" type="number"
                                    class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                    value="{{ old('cantidad') }}" required step="0.01" placeholder="1">

                            </div>

                            <div class="col-md mt-2">
                                <label for="costo" class="form-label">Costo</label>
                                <input id="costo" wire:model="costo" type="number"
                                    class="form-control @error('costo') is-invalid @enderror" name="costo"
                                    value="{{ old('costo') }}" required step="0.01" placeholder="1">


                            </div>

                            <div class="col-md mt-2">

                                <label for="iva" class="form-label">Iva</label>
                                <input id="iva" wire:model="iva" type="number"
                                    class="form-control @error('iva') is-invalid @enderror" name="iva"
                                    value="{{ old('iva') }}" required step="0.01" placeholder="1">

                            </div>


                        </div>

                    </div>


                    <div class="row mt-4">
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
                                        <button type="button" wire:click="borrarMaterial({{ $index }})"
                                            class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="row">

                        <div class="col-md-2 offset-md-6">
                            <h5>Subtotal $:</h5>
                        </div>
                        <div class="col-md-2">{{ round($subtotal,2) }}</div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-2 offset-md-6">
                            <h5>Iva %:</h5>
                        </div>
                        <div class="col-md-4">{{ round((($iva/100)*$subtotal),2) }}</div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-md-2 offset-md-6">
                            <h5>Total $:</h5>
                        </div>
                        <div class="col-md-4">{{ round($total,2) }}</div>
                    </div>


                    <div class="row justify-content-end mt-3">

                        <div class="col-md-3">

                            <a name="" id="" class="btn btn-primary" href="{{ route('compras.index') }}"
                                role="button">Cancel
                            </a>

                            <button type="button" wire:click="cargarCompra" class="btn btn-primary">Aceptar</button>
                        </div>


                    </div>

                    {{-- fin del body card --}}
                </div>
            </div>
        </div>
    </div>



</div>
