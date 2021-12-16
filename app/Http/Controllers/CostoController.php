<?php

namespace App\Http\Controllers;

use App\Exports\CostoExport;
use App\Models\Costo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class CostoController extends Controller
{
    
    public function index()
    {
        $costos=Costo::paginate(15);

        return view('costos.index',compact('costos'));
    }

    
    public function create()
    {
        return view('costos.create');
    }         

    public function edit(Costo $costo)
    {
        //
    }

   
    public function update(Request $request, Costo $costo)
    {
        //
    }

   
    public function destroy(Costo $costo)
    {
        $costo->delete();

        return redirect()->route('costos.index')->with('success','Costos Borrado con exito');
    }

    public function search(Request $request)
    {
        
        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda= $request->search;
            
            $costos=Costo::where(function ($query) {
                $query->select('nombre')
                    ->from('productos')
                    ->whereColumn('productos.id', 'costos.producto_id')                    
                    ->limit(1);
            }, 'like','%' . $busqueda . '%')
            ->orWhere('created_at','LIKE','%'.$busqueda.'%')            
            ->paginate(15)->withQueryString();            
            
                            
            return view('costos.index', compact('costos'));  

        } else {

            //return 'sin valor';

            return redirect()->route('costos.index');
        } 

                
    }

    public function export()
    {
        return Excel::download(new CostoExport, 'costos.xlsx');
    }

    //fin de la clase
}
