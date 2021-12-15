<?php

namespace App\Http\Controllers;

use App\Exports\InvmaterialExport;
use App\Models\Empleado;
use App\Models\Invmaterial;
use App\Models\Material;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;




class InvmaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $invmaterials = Invmaterial::paginate(15);

        return view('invmaterials.index', compact('invmaterials'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $materials = Material::all();
        return view('invmaterials.create', compact('materials'));
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
            'material_id' => 'required|numeric|min:1',           
            
        ]);

        

        $id=auth()->user()->id;        

        $empresauser=Empleado::where('user_id',$id)->first()->empresa_id;

        Invmaterial::create([

            'entrada' => $request->entrada,
            'salida' => $request->salida,
            'idCompra'=>0,
            'material_id' => $request->material_id,
            'user_id' => $id,
            'empresa_id' => $empresauser,
        ]);

        return redirect()->route('invmaterials.index')
            ->with('success', 'Material Creado con Exito.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invmaterial  $invmaterial
     * @return \Illuminate\Http\Response
     */
    public function show(Invmaterial $invmaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invmaterial  $invmaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(Invmaterial $invmaterial)
    {
        
        $materials = Material::all();
        return view('invmaterials.edit', compact('invmaterial', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invmaterial  $invmaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invmaterial $invmaterial)
    {
        $request->validate([
            
            'entrada' => 'required|numeric|min:1',
            'salida' => 'required|numeric|min:1',
            'material_id' => 'required|numeric|min:1',           
            
        ]);


        $id=auth()->user()->id;
        $empresauser=Empleado::where('user_id',$id)->first()->empresa_id;

        $invmaterial->update([

            'entrada' => $request->entrada,
            'salida' => $request->salida,
            'material_id' => $request->material_id,
            'user_id' => $id,
            'empresa_id' => $empresauser,

        ]);

        return redirect()->route('invmaterials.index')->with('success', 'Material Actualizado con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invmaterial  $invmaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invmaterial $invmaterial)
    {
      
        $invmaterial->delete();

        return redirect()->route('invmaterials.index')->with('success', 'Material Borrado con Exito.');

    }

    public function search(Request $request)
    {

        //dd($request);

        if ($request->search) {            

            $busqueda = $request->search;            

            $invmaterials=Invmaterial::where(function ($query) {
                $query->select('nombre')
                    ->from('materials')
                    ->whereColumn('materials.id', 'invmaterials.material_id')                    
                    ->limit(1);
            }, 'like','%' . $busqueda . '%')->paginate(15)->withQueryString(); 
            

            return view('invmaterials.index', compact('invmaterials'));

        } else {

            //return 'sin valor';

            return redirect()->route('invmaterials.index');
        }
    }

    public function export()
    {
        return Excel::download(new InvmaterialExport, 'invmaterials.xlsx');
    }
}
