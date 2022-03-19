<?php

namespace App\Http\Controllers;

use App\Exports\MaterialExport;
use App\Models\Material;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::paginate(15);

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materials.create');
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

            'codigo' => 'required|max:255',
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',            
            'costo' => 'required|numeric|min:0.1',            
            'stock_min' => 'required|numeric|min:0',
            
        ]);


        Material::create($request->all());

        return redirect()->route('materials.index')
            ->with('success', 'Material Creado con Exito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([

            'codigo' => 'required|max:255',
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',            
            'costo' => 'required|numeric|min:0.1',            
            'stock_min' => 'required|numeric|min:0',
            
        ]);

        $material->update($request->all());

        return redirect()->route('materials.index')->with('success', 'Material Actualizado con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material Borrado con Exito.');
    }


    public function search(Request $request)
    {

        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda = $request->search;

            $materials = Material::where('nombre', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('codigo', 'LIKE', '%' . $busqueda . '%')                           
                ->paginate(15)->withQueryString();

            return view('materials.index', compact('materials'));

        } else {

            //return 'sin valor';

            return redirect()->route('materials.index');
        }
    }

    public function export()
    {
        return Excel::download(new MaterialExport, 'materials.xlsx');
    }
}
