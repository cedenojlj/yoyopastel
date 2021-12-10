<?php

namespace App\Http\Livewire;

use App\Models\Empleado;
use App\Models\Material;
use App\Models\Proveedor;
use Illuminate\Support\Str;


use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Subtotal;

class Compra extends Component
{
    
    public $search; 
    public $proveedores;
    public $proveedor;    
    public $mostrar= false;
    public $errorMaterial= false;
    public $errorProveedor= false;
    public $material;
    public $materiales;
    public $cantidad;
    public $costo;
    public $subtotal=0;
    public $iva=12;
    public $total=0;
    public $listaMateriales=[];


   

    // protected $queryString=['search'];  


    protected $rules=[

        
        'material'=>'required|min:2',
        'cantidad'=>'required|numeric|min:1',
        'costo'=>'required|numeric|min:0.1',
        
    ];

    
    public function buscarProveedor()
    {
        if (count($this->proveedores)==1) {

            $this->proveedor = Proveedor::where('nombre','like','%'. $this->search .'%')
        ->orWhere('rif','like','%'. $this->search .'%')->first();  
       
        $this->errorProveedor=false;

        $this->mostrar=true; 

        }else {
            
            $this->errorProveedor=true;
        }

        

       
    }
    public function cerrarProveedor()
    {
        $this->search='';
        $this->mostrar=false;
        
    }

    public function cargarMaterial()
    {
        $this->validate();

        $searchMaterial = Material::where('nombre','like','%'. $this->material .'%')
        ->orWhere('codigo','like','%'. $this->material .'%')->first();
        

        $this->verificarMaterial($searchMaterial->id);

        
        if (!empty($searchMaterial)) {
            
            $subtotalitem=$this->cantidad*$this->costo;

            $totalitemiva = $subtotalitem + $subtotalitem*($this->iva/100);

            $this->subtotal= $this->subtotal + $subtotalitem;

            $this->total= $this->total + $totalitemiva;

            $this->listaMateriales[]=[

                'id'=>$searchMaterial->id,
                'nombre'=>$searchMaterial->nombre,
                'cantidad'=>$this->cantidad,
                'costo'=>$this->costo,
                'subtotalitem'=>$subtotalitem,
                'totalitemiva'=>$totalitemiva,         

            ];

            $this->limpiar();

        } else {
            
            $this->errorMaterial=true;
        }
        
    }

    public function borrarMaterial($indice)
    {
       //dd(count($this->listaMateriales));

        $this->subtotal=$this->subtotal-$this->listaMateriales[$indice]['subtotalitem'];
        $this->total=$this->total-$this->listaMateriales[$indice]['totalitemiva'];

        unset($this->listaMateriales[$indice]); 

        if (count($this->listaMateriales)<1) {
            $this->subtotal=0;
            $this->total=0;
        }
    }
    
    public function verificarMaterial($id)
    {
         foreach ($this->listaMateriales as $key => $value) {
            
            if($value['id']==$id){

                $this->borrarMaterial($key);
            };
        } 
        
    }

    public function limpiar()
    {
        $this->material='';
        $this->cantidad=0;
        $this->costo=0;
    }
    
    public function cargarCompra()
    {
        $id=auth()->user()->id;        

        $empresauser=Empleado::where('user_id',$id)->first()->empresa_id;

        
    }

    public function render()
    {
        if (!empty($this->search) and Str::length($this->search)>2) {

            $this->proveedores = Proveedor::where('nombre','like','%'. $this->search .'%')
            ->orWhere('rif','like','%'. $this->search .'%')->get();

           
        } else {
            
            $this->proveedores = [];
        }

        if (!empty($this->material) and Str::length($this->material)>2) {

           $this->materiales = Material::where('nombre','like','%'. $this->material .'%')
           ->orWhere('codigo','like','%'. $this->material .'%')
           ->get();

        } else {
            
            $this->materiales = [];
        }
                              
       
        return view('livewire.compra');
    }
}
