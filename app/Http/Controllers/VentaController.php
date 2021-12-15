<?php

namespace App\Http\Controllers;

use App\Exports\VentaExport;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas= Venta::paginate(15);

        return view('ventas.index',compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ventas.create');
    }

    
    public function show(Venta $venta)
    {
        
       
        $productos= DB::table('producto_venta')
        ->join('productos','producto_venta.producto_id','=','productos.id')
        ->select('producto_venta.*','productos.nombre')
        ->where('producto_venta.venta_id','=',$venta->id)
        ->get();

        $cliente= DB::table('ventas')
        ->join('clientes','ventas.cliente_id','=','clientes.id')
        ->select('clientes.*')
        ->where('ventas.id','=',$venta->id)
        ->first();        
       
       
        return view('ventas.ver',compact('venta','productos','cliente'));
    }    

    public function destroy(Venta $venta)
    {
                
        $venta->delete();

        return redirect()->route('ventas.index')->with('success','Venta borrada con exito');
    }

    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $ventas=Venta::where(function ($query) {
                $query->select('nombre')
                    ->from('clientes')
                    ->whereColumn('clientes.id', 'ventas.cliente_id')                    
                    ->limit(1);
            }, 'like','%' . $busqueda . '%')
            ->orWhere('factura','LIKE','%'.$busqueda.'%')
            ->orWhere('fecha','LIKE','%'.$busqueda.'%')
            ->paginate(15)->withQueryString();            
            
                            
            return view('ventas.index', compact('ventas'));  

        } else {

            //return 'sin valor';

            return redirect()->route('ventas.index');
        } 

                
    }

    public function export()
    {
        return Excel::download(new VentaExport, 'ventas.xlsx');
    }
}
