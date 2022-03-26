<div class="container">


    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Crear Venta') }}</div>

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


                    @if ($errorProducto)

                    <div class="alert alert-danger">

                        <p>Producto no encontrado</p>

                    </div>

                    @endif

                    @if ($errorCliente)

                    <div class="alert alert-danger">

                        <p>Coloque un cliente valido</p>

                    </div>

                    @endif

                    {{-- Numero de factura --}}

                    <div class="row mb-3">

                        <div class="col-md-4">
                            <h5>Factura:</h5>
                            {{str_pad($factura,15,'0',STR_PAD_LEFT)}}

                        </div>

                        <div class="col-md-4">
                            <h5>Fecha:</h5>
                            {{$fecha}}

                        </div>

                        <div class="col-md-4">
                            <h5>Tasa de Cambio:</h5>
                            {{$paridad}}

                        </div>

                    </div>

                    {{-- busqueda de clientes --}}

                    @if (!$mostrar)

                    <div class="row">

                        <div class="col-md-12 col-sm-12">

                            <button type="button" wire:click="buscarCliente"
                                class="btn btn-primary mb-2">Buscar</button>

                        </div>

                        <div class="col-md-6 col-sm-12">

                            <div class="search-input">
                                <input type="search" wire:model="search" class="form-control" id="search"
                                    placeholder="Cliente" autocomplete="off">

                                <div class="autocom">
                                    @if (!empty($clientes))
                                    <ul>
                                        @foreach ($clientes as $cliente)
                                        <li>{{ $cliente->nombre }}</li>
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



                    {{-- Mostrar datos del cliente --}}

                    @if ($mostrar)

                    <div class="row">

                        <div class="col-md-3">
                            <h5>Rif:</h5>
                            {{ $cliente->rif }}
                        </div>
                        <div class="col-md-3">
                            <h5>Cliente:</h5>
                            {{ $cliente->nombre }}
                        </div>
                        <div class="col-md-3">
                            <h5>Telefono:</h5>
                            {{ $cliente->telefono }}
                        </div>

                        <div class="col-md-3">
                            <button type="button" wire:click="cerrarCliente" class="btn btn-danger"><i
                                    class="far fa-trash-alt"></i></button>
                        </div>
                    </div>

                    @endif

                    {{-- Metodo de pago y moneda de pago --}}


                    <div class="row mt-3">

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="metodo">Metodo</label>
                                <select wire:model="metodo" class="form-control" name="metodo" id="metodo">
                                    <option value="Debito">Debito</option>
                                    <option value="Credito">Credito</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="moneda">Moneda</label>
                                <select wire:model="moneda" class="form-control" name="moneda" id="moneda">
                                    <option value="Bs">Bs</option>
                                    <option value="Usd">Usd</option>
                                </select>
                            </div>

                        </div>


                    </div>


                    {{-- Mostrar carga de productos --}}

                    <div class="row justify-content-between ml-1 mt-3">

                        <h3>Carga de Productos</h3>

                        {{-- productos --}}

                        <div class="row">

                            <div class="col-md-12 mb-2">

                                <button type="button" wire:click="cargarProducto" class="btn btn-primary">Nuevo</button>

                            </div>

                            <div class="col-md-6 mt-2">

                                <label for="producto" class="form-label">Producto</label>
                                <div class="search-input">
                                    <input id="producto" wire:model="producto" type="text"
                                        class="form-control @error('producto') is-invalid @enderror" name="producto"
                                        placeholder="producto" required autocomplete="off">

                                    <div class="autocom">
                                        @if (!empty($productos))
                                        <ul>
                                            @forelse ($productos as $producto)
                                            <li>{{ $producto->nombre }}</li>
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
                                <label for="precio" class="form-label">Precio</label>
                                <input id="precio" wire:model="precio" type="number"
                                    class="form-control @error('precio') is-invalid @enderror" name="precio"
                                    value="{{ old('precio') }}" required step="0.01" placeholder="1">


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
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($listaProductos as $index => $item)

                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $item['nombre'] }}</td>
                                    <td>{{ $item['cantidad']}}</td>
                                    <td>{{ $item['precio'] }}</td>
                                    <td>{{ $item['subtotalitem'] }}</td>

                                    <td>
                                        <button type="button" wire:click="borrarProducto({{ $index }})"
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

                    <div class="row mt-3">

                        <div class="col-md-2 offset-md-6">
                            <h5>Total Bs:</h5>
                        </div>
                        <div class="col-md-4">{{ round($total*$paridad,2) }}</div>
                    </div>


                    
                    {{-- Para controlar los pagos y vueltos y cuadrar la caja --}}

                    <div class="row mt-3">

                        <div class="col-md-3">
                            <label for="pagoBs" class="form-label">pagoBs</label>
                                <input id="pagoBs" wire:model="pagoBs" type="number"
                                    class="form-control @error('pagoBs') is-invalid @enderror" name="pagoBs"
                                    value="" step="0.01" placeholder="0">
                        </div>

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="metodoPagoBs">Metodo</label>
                                <select wire:model="metodoPagoBs" class="form-control" name="metodoPagoBs" id="metodoPagoBs">
                                    <option value="Debito">Debito</option>
                                    <option value="Credito">Credito</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-3">
                            <label for="vueltoBs" class="form-label">vueltoBs</label>
                                <input id="vueltoBs" wire:model="vueltoBs" type="number"
                                    class="form-control @error('vueltoBs') is-invalid @enderror" name="vueltoBs"
                                    value="" step="0.01" placeholder="0">
                        </div>

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="metodoVueltoBs">Metodo</label>
                                <select wire:model="metodoVueltoBs" class="form-control" name="metodoVueltoBs" id="metodoVueltoBs">
                                    <option value="Debito">Debito</option>
                                    <option value="Credito">Credito</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                            </div>

                        </div>

                        
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <label for="pagoDol" class="form-label">pagoDol</label>
                                <input id="pagoDol" wire:model="pagoDol" type="number"
                                    class="form-control @error('pagoDol') is-invalid @enderror" name="pagoDol"
                                    value="" step="0.01" placeholder="0">
                        </div>

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="metodoPagoDol">Metodo</label>
                                <select wire:model="metodoPagoDol" class="form-control" name="metodoPagoDol" id="metodoPagoDol">
                                    <option value="Debito">Debito</option>
                                    <option value="Credito">Credito</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-3">
                            <label for="vueltoDol" class="form-label">vueltoDol</label>
                                <input id="vueltoDol" wire:model="vueltoDol" type="number"
                                    class="form-control @error('vueltoDol') is-invalid @enderror" name="vueltoDol"
                                    value="" step="0.01" placeholder="0">
                        </div>

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="metodoVueltoDol">Metodo</label>
                                <select wire:model="metodoVueltoDol" class="form-control" name="metodoVueltoDol" id="metodoVueltoDol">
                                    <option value="Debito">Debito</option>
                                    <option value="Credito">Credito</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                            </div>

                        </div>

                        
                    </div>

                    {{-- fin de control del flujo de caja --}}



                    <div class="row justify-content-end mt-3">

                        <div class="col-md-3">

                            <a name="" id="" class="btn btn-primary" href="{{ route('ventas.index') }}"
                                role="button">Cancel
                            </a>

                            <button type="button" wire:click="cargarVenta" class="btn btn-primary">Aceptar</button>
                        </div>


                    </div>

                    <div class="row modal-open">

                       
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Permiso de Eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12 mt-2">
                                                <label for="clave" class="form-label">Clave</label>
                                                <input id="clave" wire:model.defer="clave" type="password"
                                                    class="form-control @error('clave') is-invalid @enderror" name="clave"
                                                    value="{{ old('clave') }}" placeholder="1">
                
                
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" wire:click="borrarProductoModal" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>

                    {{-- fin del body card --}}
                </div>
            </div>
        </div>
    </div>



</div>