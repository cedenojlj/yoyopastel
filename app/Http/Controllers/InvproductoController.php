<?php

namespace App\Http\Controllers;

use App\Exports\InvproductoExport;
use App\Models\Empleado;
use App\Models\Invproducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class InvproductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invproductos = Invproducto::paginate(15);

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
        return view('invproductos.create', compact('productos'));
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
            
            'entrada' => 'required|numeric|min:1',
            'salida' => 'required|numeric|min:1',
            'producto_id' => 'required|numeric|min:1',           
            
        ]);

        

        $id=auth()->user()->id;        

        $empresauser=Empleado::where('user_id',$id)->first()->empresa_id;

        Invproducto::create([

            'entrada' => $request->entrada,
            'salida' => $request->salida,
            'idVenta'=>0,
            'producto_id' => $request->producto_id,
            'user_id' => $id,
            'empresa_id' => $empresauser,
        ]);

        return redirect()->route('invproductos.index')
            ->with('success', 'Producto Creado con Exito.');
    }


    public function edit(Invproducto $invproducto)
    {
        $productos = Producto::all();
        return view('invproductos.edit', compact('invproducto', 'productos'));
    }


    public function update(Request $request, Invproducto $invproducto)
    {

        $request->validate([
            
            'entrada' => 'required|numeric|min:1',
            'salida' => 'required|numeric|min:1',
            'producto_id' => 'required|numeric|min:1',           
            
        ]);


        $id=auth()->user()->id;
        $empresauser=Empleado::where('user_id',$id)->first()->empresa_id;

        $invproducto->update([

            'entrada' => $request->entrada,
            'salida' => $request->salida,
            'producto_id' => $request->producto_id,
            'user_id' => $id,
            'empresa_id' => $empresauser,

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
}
