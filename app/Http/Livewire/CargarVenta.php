<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Invproducto;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;




class CargarVenta extends Component
{

    //mostrar mensajes de errores

    public $mostrar = false;
    public $errorProducto = false;
    public $errorCliente = false;
    public $clave = "";


    //busqueda de clientes

    public $search;
    public $clientes = [];
    public $cliente;


    //busqueda de producto

    public $producto;
    public $productos = [];
    public $indiceProducto;

    // Campos para realizar la carga de productos y la venta

    public $cantidad = 1;
    public $costo;
    public $subtotal = 0;
    public $iva = 16;
    public $total = 0;
    public $listaProductos = [];
    public $factura;
    public $fecha;
    public $precio;
    public $subtotalCosto = 0;
    public $paridad;
    public $metodo = "Debito";
    public $moneda = "Bs";
    public $subcosto = 0;




    protected $rules = [


        'producto' => 'required|min:2',
        'cantidad' => 'required|numeric|min:1',
        'precio' => 'required|numeric|min:0.1',

    ];

    public function mount()
    {

        $id = auth()->user()->id;

        $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;

        $numfactura = Empresa::where('id', $idempresa)->value('factura');

        $this->factura = $numfactura + 1;

        $this->fecha = Carbon::now()->format('Y-m-d');

        $this->paridad = DB::table('paridads')->latest()->value('paridad');
    }

    public function buscarCliente()
    {
        if (count($this->clientes) == 1) {

            $this->cliente = Cliente::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('rif', 'like', '%' . $this->search . '%')->first();

            $this->errorCliente = false;

            $this->clientes = [];

            $this->mostrar = true;
        } else {

            $this->errorCliente = true;
        }
    }

    public function cerrarCliente()
    {
        $this->search = '';
        $this->clientes = [];
        $this->mostrar = false;
    }

    public function cargarProducto()
    {
        $this->validate();

        $searchProducto = Producto::where('nombre', 'like', '%' . $this->producto . '%')
            ->orWhere('codigo', 'like', '%' . $this->producto . '%')->first();


        $productoRepetido = $this->verificarProducto($searchProducto->id);


        $this->precio = Producto::where('id', $searchProducto->id)->value('precio');

        $this->costo = Producto::where('id', $searchProducto->id)->value('costo');


        if ($productoRepetido == false) {

            if (!empty($searchProducto)) {

                $subtotalitem = $this->cantidad * $this->precio;

                $totalitemiva = $subtotalitem + $subtotalitem * ($this->iva / 100);

                $this->subtotal = $this->subtotal + $subtotalitem;

                $this->total = $this->total + $totalitemiva;


                $subtotalItemCosto = $this->cantidad * $this->costo;

                $this->subcosto = $this->subcosto +  $subtotalItemCosto;


                $this->listaProductos[] = [

                    'id' => $searchProducto->id,
                    'nombre' => $searchProducto->nombre,
                    'cantidad' => $this->cantidad,
                    'precio' => $this->precio,
                    'costo' => $this->costo,
                    'subtotalitem' => $subtotalitem,
                    'totalitemiva' => $totalitemiva,
                    'subtotalItemCosto'=> $subtotalItemCosto

                ];

                $this->limpiar();

                $this->productos = [];

            } else {

                $this->errorProducto = true;
            }
        }
    }

    public function borrarProducto($indice)
    {
        //dd(count($this->listaProductos));


        if (auth()->user()->rol == "user" or auth()->user()->rol == "saller") {

            $this->indiceProducto = $indice;

            $this->emit('userStore');           

        } else {

            $this->subtotal = $this->subtotal - $this->listaProductos[$indice]['subtotalitem'];
            $this->total = $this->total - $this->listaProductos[$indice]['totalitemiva'];
            $this->subcosto = $this->subcosto - $this->listaProductos[$indice]['subtotalItemCosto'];

            unset($this->listaProductos[$indice]);

            if (count($this->listaProductos) < 1) {
                $this->subtotal = 0;
                $this->total = 0;
            }
        }
    }


    public function borrarProductoModal()
    {
        $indice = $this->indiceProducto;

        if ($this->clave == 202101) {

            $this->subtotal = $this->subtotal - $this->listaProductos[$indice]['subtotalitem'];
            $this->total = $this->total - $this->listaProductos[$indice]['totalitemiva'];
            $this->subcosto = $this->subcosto - $this->listaProductos[$indice]['subtotalItemCosto'];

            unset($this->listaProductos[$indice]);

            if (count($this->listaProductos) < 1) {
                $this->subtotal = 0;
                $this->total = 0;
            }

            $this->clave = "";
        }

        $this->emit('userClose');   
       
    }

    public function verificarProducto($id)
    {
        foreach ($this->listaProductos as $key => $value) {

            if ($value['id'] == $id) {

                $this->precio = Producto::where('id', $id)->value('precio');

                $this->costo = Producto::where('id', $id)->value('costo');


                $subtotalItemCosto = $this->cantidad * $this->costo;

                $this->subcosto = $this->subcosto +  $subtotalItemCosto;

                $subtotalitem = $this->cantidad * $this->precio;

                $totalitemiva = $subtotalitem + $subtotalitem * ($this->iva / 100);

                $this->subtotal = $this->subtotal + $subtotalitem;

                $this->total = $this->total + $totalitemiva;



                $this->listaProductos[$key]['subtotalitem'] = $this->listaProductos[$key]['subtotalitem'] + $subtotalitem;

                $this->listaProductos[$key]['totalitemiva'] = $this->listaProductos[$key]['totalitemiva'] + $totalitemiva;

                $this->listaProductos[$key]['subtotalItemCosto'] = $this->listaProductos[$key]['subtotalItemCosto'] + $subtotalItemCosto;

                $this->listaProductos[$key]['cantidad'] = $this->listaProductos[$key]['cantidad'] + $this->cantidad;

                $this->listaProductos[$key]['precio'] = $this->precio;

                $this->limpiar();

                $this->productos = [];

                return true;
            };
        }

        return false;
    }

    public function limpiar()
    {
        $this->producto = '';
        $this->cantidad = 0;
        $this->costo = 0;
    }

    public function cargarVenta()
    {

        if (count($this->listaProductos) >= 1 and $this->cliente->id >= 1) {

            $id = auth()->user()->id;

            $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;

            $ivaVenta = $this->total - $this->subtotal;

            // Creando la Venta

            $data = Venta::create([

                'fecha' => $this->fecha,
                'factura' => $this->factura,
                'subtotal' => $this->subtotal,
                'subcosto' => $this->subcosto,
                'iva' => $ivaVenta,
                'total' => $this->total,
                'paridad' => $this->paridad,
                'metodo' => $this->metodo,
                'moneda' => $this->moneda,
                'cliente_id' => $this->cliente->id,
                'user_id' => $id,
                'empresa_id' => $idempresa,

            ]);

            $idVenta = $data->id;

            foreach ($this->listaProductos as $value) {


                //para insertar todos los productos de la venta

                DB::table('producto_venta')->insert([

                    'cantidad' => $value['cantidad'],
                    'precio' => $value['precio'],
                    'costo' => $value['costo'],
                    'subtotal' => $value['subtotalitem'],
                    'subcosto' => $value['subtotalItemCosto'],
                    'venta_id' => $idVenta,
                    'producto_id' => $value['id'],

                ]);


                //para sacar del inventario los productos vendidos

                Invproducto::create([

                    'entrada' => 0,
                    'salida' => $value['cantidad'],
                    'idVenta' => $idVenta,
                    'producto_id' => $value['id'],
                    'user_id' => $id,
                    'empresa_id' => $idempresa,

                ]);
            }

            Empresa::where('id', $idempresa)->update([

                'factura' => $this->factura,

            ]);

            redirect()->route('ventas.index')
                ->with('success', 'Venta Creada con Exito.');
        } else {

            session()->flash('message', 'Por favor, colocar cliente o productos validos');
        }
    }




    public function render()
    {

        //bsuqueda de clientes

        if (!empty($this->search) and Str::length($this->search) > 2) {


            $this->clientes = Cliente::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('rif', 'like', '%' . $this->search . '%')->get();
        }

        if (empty($this->search)) {

            $this->clientes = [];
        }

        // busqueda de productos


        if (!empty($this->producto) and Str::length($this->producto) > 2) {

            $this->productos = Producto::where('nombre', 'like', '%' . $this->producto . '%')
                ->orWhere('codigo', 'like', '%' . $this->producto . '%')
                ->get();

            if ($this->productos->count() == 1) {


                foreach ($this->productos as $value) {

                    $this->precio = Producto::where('id', $value->id)->value('precio');
                }
            } else {


                $this->precio = 0;
            }
        }


        if (empty($this->producto)) {

            $this->productos = [];
            $this->precio = 0;
        }



        return view('livewire.cargar-venta');
    }
}
