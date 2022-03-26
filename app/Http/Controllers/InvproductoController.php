<?php

namespace App\Http\Controllers;

use App\Exports\InvproductoExport;
use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Invproducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;



class InvproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;

        $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;


        if (auth()->user()->rol=="superadmin" or auth()->user()->rol=="admin" ) {
            
            
            $invproductos = Invproducto::paginate(15);
            
        } else {

            
            $invproductos = Invproducto::where('empresa_id', $idempresa)->paginate(15);
        }



        //$invproductos = Invproducto::where('empresa_id', $idempresa)->paginate(15);

        //$invproductos = Invproducto::paginate(15);


        return view('invproductos.index', compact('invproductos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::all();
        $empresas = Empresa::all();
        return view('invproductos.create', compact('productos','empresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            
            'entrada' => 'numeric|min:0',
            'salida' => 'numeric|min:0',
            'producto_id' => 'required|numeric|min:1',
            'empresa_id' => 'required|numeric',           
            
        ]);

        

        $id=auth()->user()->id; 

        Invproducto::create([

            'entrada' => $request->entrada,
            'salida' => $request->salida,
            'idVenta'=>0,
            'producto_id' => $request->producto_id,
            'user_id' => $id,
            'empresa_id' => $request->empresa_id,
        ]);

        return redirect()->route('invproductos.index')
            ->with('success', 'Producto Creado con Exito.');
    }


    public function edit(Invproducto $invproducto)
    {
        $productos = Producto::all();
        $empresas = Empresa::all();
        return view('invproductos.edit', compact('invproducto', 'productos','empresas'));
    }


    public function update(Request $request, Invproducto $invproducto)
    {

        $request->validate([
            
            'entrada' => 'numeric|min:0',
            'salida' => 'numeric|min:0',
            'producto_id' => 'required|numeric|min:1',
            'empresa_id' => 'required|numeric',           
            
        ]);


        $id=auth()->user()->id;        

        $invproducto->update([

            'entrada' => $request->entrada,
            'salida' => $request->salida,
            'producto_id' => $request->producto_id,
            'user_id' => $id,
            'empresa_id' => $request->empresa_id,

        ]);

        return redirect()->route('invproductos.index')->with('success', 'Producto Actualizado con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invproducto  $invproducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invproducto $invproducto)
    {
        $invproducto->delete();

        return redirect()->route('invproductos.index')->with('success', 'Producto Borrado con Exito.');
    }

    public function search(Request $request)
    {

        //dd($request);

        if ($request->search) {            

            $busqueda = $request->search;            

            $invproductos=Invproducto::where(function ($query) {
                $query->select('nombre')
                    ->from('productos')
                    ->whereColumn('productos.id', 'invproductos.producto_id')                    
                    ->limit(1);
            }, 'like','%' . $busqueda . '%')->paginate(15)->withQueryString(); 
            

            return view('invproductos.index', compact('invproductos'));

        } else {

            //return 'sin valor';

            return redirect()->route('invproductos.index');
        }
    }

    public function export()
    {
        return Excel::download(new InvproductoExport, 'invproductos.xlsx');
    }


    public function pdfStockProducto()
    {
        $id = auth()->user()->id;

        $idempresa = Empleado::where('user_id', $id)->first()->empresa_id;

        $nombre=Empresa::where('id',$idempresa)->value('nombre');   

        //dd($idempresa);

        $anio= date('Y'); 
        
                
        $productos= DB::table('invproductos') 
        ->join('productos','invproductos.producto_id','=','productos.id')                                
        ->select('invproductos.producto_id','productos.nombre as producto', DB::raw('SUM(entrada) as entradas, SUM(salida) as salidas, (SUM(entrada) - SUM(salida)) as Stock'))
        ->where('invproductos.empresa_id',$idempresa)
        ->whereYear('invproductos.created_at',$anio)
        ->groupBy('invproductos.producto_id','productos.nombre')  
        ->get();          

        //dd($productos); 
             
        $pdf = PDF::loadView('invproductos.stock', compact('productos','nombre'))->setOptions(['defaultFont' => 'sans-serif']);
        //$pdf->loadHTML('<h1>Test</h1>');
        //return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
}
