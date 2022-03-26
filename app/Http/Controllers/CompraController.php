<?php

namespace App\Http\Controllers;

use App\Exports\CompraExport;
use App\Models\Compra;
use App\Models\Empleado;
use App\Models\Invmaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class CompraController extends Controller
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
            
            
            $compras= Compra::paginate(15);

            
        } else {


            $compras= Compra::where('empresa_id', $idempresa)->paginate(15);
           
        }

       


        //$compras= Compra::paginate(15);

        return view('compras.index',compact('compras'));
    }

    
    public function create()
    {
        return view('compras.create');
    }
    

    
    public function show(Compra $compra)
    {
        
        $materiales= DB::table('compra_material')
        ->join('materials','compra_material.material_id','=','materials.id')
        ->select('compra_material.*','materials.nombre')
        ->where('compra_material.compra_id','=',$compra->id)
        ->get();

        $proveedor= DB::table('compras')
        ->join('proveedors','compras.proveedor_id','=','proveedors.id')
        ->select('proveedors.*')
        ->where('compras.id','=',$compra->id)
        ->first();
        
       
        return view('compras.ver',compact('compra','materiales','proveedor'));

    }

    
    public function destroy(Compra $compra)
    {
        
        Invmaterial::where('idCompra',$compra->id)->delete();
        
        $compra->delete();

        return redirect()->route('compras.index')->with('success','Compra eliminada con exito');
    }


    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $compras=Compra::where(function ($query) {
                $query->select('nombre')
                    ->from('proveedors')
                    ->whereColumn('proveedors.id', 'compras.proveedor_id')                    
                    ->limit(1);
            }, 'like','%' . $busqueda . '%')
            ->orWhere('factura','LIKE','%'.$busqueda.'%')
            ->orWhere('fecha','LIKE','%'.$busqueda.'%')
            ->orWhere('total','LIKE','%'.$busqueda.'%')
            ->paginate(15)->withQueryString();            
            
                            
            return view('compras.index', compact('compras'));  

        } else {

            //return 'sin valor';

            return redirect()->route('compras.index');
        } 

                
    }

    public function export()
    {
        return Excel::download(new CompraExport, 'compras.xlsx');
    }


}
