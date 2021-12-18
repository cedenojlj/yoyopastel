<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Crear Costos de Fabricacion') }}</div>

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

                    @if ($errorProducto)

                    <div class="alert alert-danger">

                        <p>Coloque un producto valido</p>

                    </div>

                    @endif

                    {{-- busqueda de productos --}}

                    @if (!$mostrar)

                    <div class="row">

                        <div class="col-md-12 col-sm-12">

                            <button type="button" wire:click="buscarProducto"
                                class="btn btn-primary mb-2">Buscar</button>

                        </div>

                        <div class="col-md-6 col-sm-12">

                            <div class="search-input">
                                <input type="search" wire:model="search" class="form-control" id="search"
                                    placeholder="Producto" autocomplete="off">

                                <div class="autocom">
                                    @if (!empty($productos))
                                    <ul>
                                        @foreach ($productos as $producto)
                                        <li>{{ $producto->nombre }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>

                            </div>

                        </div>


                    </div>


                    @endif



                    {{-- Mostrar datos del producto --}}

                    @if ($mostrar)

                    <div class="row">

                        <div class="col-md-3">
                            <h5>Codigo:</h5>
                            {{ $producto->codigo }}
                        </div>

                        <div class="col-md-3">
                            <h5>Producto:</h5>
                            {{ $producto->nombre }}
                        </div>

                        <div class="col-md-3">
                            <button type="button" wire:click="cerrarProducto" class="btn btn-danger"><i
                                    class="far fa-trash-alt"></i></button>
                        </div>

                    </div>

                    @endif


                    {{-- Mostrar carga de materiales --}}

                    <div class="row justify-content-between ml-1 my-3">

                        <h3>Carga de Materiales por Producto</h3>

                    </div>

                    {{-- materiales --}}

                    <div class="row">

                        <div class="col-md-12 mb-2">                           

                           @if ($mostrarBotones)

                            <button type="button" wire:click="cargarMaterial" class="btn btn-primary">Nuevo</button>
                           
                           @endif
                        
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


                        <div class="col-md-3 mt-2">

                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input id="cantidad" wire:model="cantidad" type="number"
                                class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                value="{{ old('cantidad') }}" required step="0.01" placeholder="1">

                        </div>

                    </div>


                    <div class="row mt-4">
                        <table class="table ">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($listaMateriales as $index => $item)

                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $item['codigo'] }}</td>
                                    <td>{{ $item['nombre'] }}</td>
                                    <td>{{ $item['cantidad']}}</td>

                                    <td>
                                        <button type="button" wire:click="borrarMaterial({{ $index }})"
                                            class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>


                    <div class="row justify-content-end mt-3">

                        <div class="col-md-3">

                            @if ($mostrarBotones)

                            <a name="" id="" class="btn btn-primary" href="{{ route('costos.index') }}"
                                role="button">Cancel
                            </a>

                            <button type="button" wire:click="cargarCosto" class="btn btn-primary">Aceptar</button>

                            @endif
                        </div>


                    </div>

                    {{-- fin del body card --}}
                </div>
            </div>
        </div>
    </div>



</div>