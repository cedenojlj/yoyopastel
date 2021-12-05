<?php

namespace App\Http\Controllers;

use App\Exports\ParidadExport;
use App\Models\Paridad;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class ParidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paridads = Paridad::paginate(15);

        return view('paridads.index', compact('paridads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paridads.create');
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

            'paridad' => 'required|numeric|min:0.1'

        ]);

        Paridad::create($request->all());

        return redirect()->route('paridads.index')->with('success', 'Tasa Creada con Exito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paridad  $paridad
     * @return \Illuminate\Http\Response
     */
    public function show(Paridad $paridad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paridad  $paridad
     * @return \Illuminate\Http\Response
     */
    public function edit(Paridad $paridad)
    {
        return view('paridads.edit', compact('paridad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paridad  $paridad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paridad $paridad)
    {
        
        $request->validate([

            'paridad' => 'required|numeric|min:0.1'

        ]);
        
        $paridad->update($request->all());

        return redirect()->route('paridads.index')->with('success', 'Paridad Actualizada con Exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paridad  $paridad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paridad $paridad)
    {
        $paridad->delete();

        return redirect()->route('paridads.index')->with('success', 'Paridad Borrada con Exito.');
    }

    public function search(Request $request)
    {

        //dd($request);

        if ($request->inicio and $request->fin ) {

            //return 'con valor';
            

            $paridads = Paridad::where('created_at','>=',$request->inicio)
                ->where('created_at','<=',$request->fin)
                ->paginate(15)->withQueryString();

            return view('paridads.index', compact('paridads'));

        } else {

            //return 'sin valor';

            return redirect()->route('paridads.index');
        }
    }

    public function export()
    {
        return Excel::download(new ParidadExport, 'paridads.xlsx');
    }
}
