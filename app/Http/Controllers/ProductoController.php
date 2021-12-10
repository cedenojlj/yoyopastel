<?php

namespace App\Http\Controllers;

use App\Exports\ProductoExport;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::paginate(15);

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
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
            'precio' => 'required|numeric|min:1',
            'costo' => 'required|numeric|min:1',
            'ganancia' => 'required|numeric|min:1',            
            'stock_min' => 'required|numeric|min:0',
            'categoria_id' => 'required',
        ]);


        Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto Creado con Exito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {

        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([

            'codigo' => 'required|max:255',
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'precio' => 'required|numeric|min:1',
            'costo' => 'required|numeric|min:1',
            'ganancia' => 'required|numeric|min:1',            
            'stock_min' => 'required|numeric|min:0',
            'categoria_id' => 'required',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto Actualizado con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto Borrado con Exito.');
    }


    public function search(Request $request)
    {

        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda = $request->search;

            $productos = Producto::where('codigo', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('nombre', 'LIKE', '%' . $busqueda . '%')                
                ->paginate(15)->withQueryString();

            return view('productos.index', compact('productos'));
        } else {

            //return 'sin valor';

            return redirect()->route('productos.index');
        }
    }

    public function export()
    {
        return Excel::download(new ProductoExport, 'productos.xlsx');
    }
}
