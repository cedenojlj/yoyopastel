<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras= Compra::paginate(15);

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
        $compra->delete();

        return redirect()->route('compras.index')->with('success','Compra eliminada con exito');
    }


}
