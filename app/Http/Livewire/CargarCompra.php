<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use Livewire\Component;
use App\Models\Empleado;
use App\Models\Invmaterial;
use App\Models\Material;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class CargarCompra extends Component
{

    //mostrar mensajes de errores

    public $mostrar = false;
    public $errorMaterial = false;
    public $errorProveedor = false;


    //busqueda de proveedores

    public $search;
    public $proveedores = [];
    public $proveedor;


    //busqueda de materiales

    public $material;
    public $materiales = [];

    // Campos para realizar la carga de materiales y la compra

    public $cantidad;
    public $costo;
    public $subtotal = 0;
    public $iva = 16;
    public $total = 0;
    public $listaMateriales = [];
    public $factura;
    public $fecha;



    protected $rules = [


        'material' => 'required|min:2',
        'cantidad' => 'required|numeric|min:0.1',
        'costo' => 'required|numeric|min:0.1',

    ];


    public function buscarProveedor()
    {
        if (count($this->proveedores) == 1) {

            $this->proveedor = Proveedor::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('rif', 'like', '%' . $this->search . '%')->first();

            $this->errorProveedor = false;

            $this->proveedores = [];

            $this->mostrar = true;
        } else {

            $this->errorProveedor = true;
        }
    }

    public function cerrarProveedor()
    {
        $this->search = '';
        $this->proveedores = [];
        $this->mostrar = false;
    }

    public function cargarMaterial()
    {
        $this->validate();

        $searchMaterial = Material::where('nombre', 'like', '%' . $this->material . '%')
            ->orWhere('codigo', 'like', '%' . $this->material . '%')->first();


        $materialRepetido = $this->verificarMaterial($searchMaterial->id);

        if ($materialRepetido == false) {

            if (!empty($searchMaterial)) {

                $subtotalitem = $this->cantidad * $this->costo;

                $totalitemiva = $subtotalitem + $subtotalitem * ($this->iva / 100);

                $this->subtotal = $this->subtotal + $subtotalitem;

                $this->total = $this->total + $totalitemiva;

                $this->listaMateriales[] = [

                    'id' => $searchMaterial->id,
                    'nombre' => $searchMaterial->nombre,
                    'cantidad' => $this->cantidad,
                    'costo' => $this->costo,
                    'subtotalitem' => $subtotalitem,
                    'totalitemiva' => $totalitemiva,

                ];

                $this->limpiar();

                $this->materiales = [];
            } else {

                $this->errorMaterial = true;
            }
        }
    }

    public function borrarMaterial($indice)
    {
        //dd(count($this->listaMateriales));

        $this->subtotal = $this->subtotal - $this->listaMateriales[$indice]['subtotalitem'];
        $this->total = $this->total - $this->listaMateriales[$indice]['totalitemiva'];

        unset($this->listaMateriales[$indice]);

        if (count($this->listaMateriales) < 1) {
            $this->subtotal = 0;
            $this->total = 0;
        }
    }

    public function verificarMaterial($id)
    {
        foreach ($this->listaMateriales as $key => $value) {

            if ($value['id'] == $id) {

                $subtotalitem = $this->cantidad * $this->costo;

                $totalitemiva = $subtotalitem + $subtotalitem * ($this->iva / 100);

                $this->subtotal = $this->subtotal + $subtotalitem;

                $this->total = $this->total + $totalitemiva;

                $this->listaMateriales[$key]['subtotalitem'] = $this->listaMateriales[$key]['subtotalitem'] + $subtotalitem;

                $this->listaMateriales[$key]['totalitemiva'] = $this->listaMateriales[$key]['totalitemiva'] + $totalitemiva;

                $this->listaMateriales[$key]['cantidad'] = $this->listaMateriales[$key]['cantidad'] + $this->cantidad;

                $this->listaMateriales[$key]['costo'] = $this->costo;

                $this->limpiar();

                $this->materiales = [];

                return true;
            };
        }

        return false;
    }

    public function limpiar()
    {
        $this->material = '';
        $this->cantidad = 0;
        $this->costo = 0;
    }

    public function cargarCompra()
    {

        if (count($this->listaMateriales) >= 1 and $this->proveedor->id >= 1) {

            $id = auth()->user()->id;

            $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;

            $ivaCompra = $this->total - $this->subtotal;            

            $data = Compra::create([

                'fecha' => $this->fecha,
                'factura' => $this->factura,
                'subtotal' => $this->subtotal,
                'iva' => $ivaCompra,
                'total' => $this->total,
                'proveedor_id' => $this->proveedor->id,
                'user_id' => $id,
                'empresa_id' => $idempresa,

            ]);

            $idCompra=$data->id; 
           

            foreach ($this->listaMateriales as $value) {
               
                //para tener siempre el costo maximo de cada material cargado

                $costoItem = DB::table('materials')
                            ->where('id',$value['id'])
                            ->value('costo');

                if ($value['costo']> $costoItem) {
                   
                    DB::table('materials')
                    ->where('id',$value['id'])
                    ->update(['costo'=>$value['costo']]);
                }

                //para insertar todos los materiales

                DB::table('compra_material')->insert([

                   'cantidad'=>$value['cantidad'], 
                   'costo'=>$value['costo'], 
                   'subtotal'=>$value['subtotalitem'], 
                   'compra_id'=>$idCompra, 
                   'material_id'=>$value['id'],                 

                ]);


                //para insertar los materiales en el inventario

                Invmaterial::create([

                    'entrada' => $value['cantidad'],
                    'salida' => 0,
                    'idCompra'=> $idCompra,
                    'material_id' => $value['id'],
                    'user_id' => $id,
                    'empresa_id' => $idempresa,
                ]);

            }

            //para actualizar los precios de los productos con la carga de las compras de materiales

            $this->actualizarCostoProducto();
            
            redirect()->route('compras.index')
            ->with('success', 'Compra Creada con Exito.');
 

        } else {

            session()->flash('message', 'Por favor, colocar proveedor o materiales validos');
        }
    }

    public function actualizarCostoProducto()
    {

        $reportes = DB::table('costo_material')
            ->join('costos', 'costo_material.costo_id', '=', 'costos.id')
            ->join('materials', 'costo_material.material_id', '=', 'materials.id')
            ->select(
                'costos.producto_id',
                DB::raw('SUM(materials.costo*costo_material.cantidad) as costoProducto')
            )
            ->groupBy('costos.producto_id')
            ->get();

        foreach ($reportes as $value) {

            $ganancia = Producto::where('id', $value->producto_id)->value('ganancia');

            $precio = $value->costoProducto * (1 + ($ganancia / 100));

            Producto::where('id', $value->producto_id)
                ->update(['costo' => $value->costoProducto, 'precio' => $precio]);
        }

        return true;
    }




    public function render()
    {
       
         //bsuqueda de proveedores
        
         if (!empty($this->search) and Str::length($this->search) > 2) {


            $this->proveedores = Proveedor::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('rif', 'like', '%' . $this->search . '%')->get();

        } 


        // busqueda de materiales


        if (!empty($this->material) and Str::length($this->material) > 2) {

            $this->materiales = Material::where('nombre', 'like', '%' . $this->material . '%')
                ->orWhere('codigo', 'like', '%' . $this->material . '%')
                ->get();
                
        } 
       
       
        return view('livewire.cargar-compra');
    }




}
