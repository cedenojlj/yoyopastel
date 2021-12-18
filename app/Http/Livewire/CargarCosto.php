<?php

namespace App\Http\Livewire;

use App\Models\Costo;
use Livewire\Component;

use App\Models\Empleado;
use App\Models\Material;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class CargarCosto extends Component
{

    //mostrar mensajes de errores

    public $mostrar = false;
    public $errorMaterial = false;
    public $errorProducto = false;
    public $mostrarBotones = false;

    //busqueda de productos

    public $search;
    public $productos = [];
    public $producto;


    //busqueda de materiales

    public $material;
    public $materiales = [];

    // Campos para realizar la carga de materiales y la compra

    public $cantidad;
    public $listaMateriales = [];


    protected $rules = [

        'material' => 'required|min:2',
        'cantidad' => 'required|numeric|min:0.1',
    ];



    public function buscarProducto()
    {
        if (count($this->productos) == 1) {

            $this->producto = Producto::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('codigo', 'like', '%' . $this->search . '%')->first();

            $idProductoCosto = $this->producto->id;

            $verificarProductoCosto= Costo::where('producto_id', $idProductoCosto)->count();            

            if($verificarProductoCosto<1){

                $this->errorProducto = false;

            $this->productos = [];

            $this->mostrar = true;

            $this->mostrarBotones = true;

            } else{

                $this->mostrarBotones = false;

                session()->flash('message','Producto con costos cargados, favor eliminar y crear de nuevo');

            }

        } else {

            $this->errorProducto = true;
        }
    }

    public function cerrarProducto()
    {
        $this->search = '';
        $this->productos = [];
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

                $this->listaMateriales[] = [

                    'id' => $searchMaterial->id,
                    'nombre' => $searchMaterial->nombre,
                    'cantidad' => $this->cantidad,
                    'codigo' => $searchMaterial->codigo

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

        unset($this->listaMateriales[$indice]);
    }

    public function verificarMaterial($id)
    {
        foreach ($this->listaMateriales as $key => $value) {

            if ($value['id'] == $id) {

                $this->listaMateriales[$key]['cantidad'] = $this->listaMateriales[$key]['cantidad'] + $this->cantidad;

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
    }

    public function cargarCosto()
    {

        if (count($this->listaMateriales) >= 1 and $this->producto->id >= 1) {

            $id = auth()->user()->id;

            $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;

            $data = Costo::create([

                'producto_id' => $this->producto->id,
                'user_id' => $id,
                'empresa_id' => $idempresa,
            ]);

            $idCosto = $data->id;


            foreach ($this->listaMateriales as $value) {


                //para insertar todos los materiales

                DB::table('costo_material')->insert([

                    'cantidad' => $value['cantidad'],
                    'costo_id' => $idCosto,
                    'material_id' => $value['id'],

                ]);
            }

            $this->actualizarCostoProducto();

            redirect()->route('costos.index')
                ->with('success', 'Costos Creado con Exito.');
        } else {

            session()->flash('message', 'Por favor, colocar producto o materiales validos');
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

        //bsuqueda de productos

        if (!empty($this->search) and Str::length($this->search) > 2) {


            $this->productos = Producto::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('codigo', 'like', '%' . $this->search . '%')->get();
        }


        // busqueda de materiales


        if (!empty($this->material) and Str::length($this->material) > 2) {

            $this->materiales = Material::where('nombre', 'like', '%' . $this->material . '%')
                ->orWhere('codigo', 'like', '%' . $this->material . '%')
                ->get();
        }




        return view('livewire.cargar-costo');
    }
}
