<?php

namespace App\Http\Controllers;

use App\Exports\EmpleadoExport;
use App\Models\Empleado;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;




class EmpleadoController extends Controller
{


    public function index()
    {

        $empleados = Empleado::paginate(15);

        return view('empleados.index', compact('empleados'));

        //return 'hola empleados';
    }



    public function create()
    {
        $empresas = Empresa::all();
        return view('empleados.create', compact('empresas'));
    }



    public function store(Request $request)
    {
        $request->validate([

            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'cedula' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required|email',
            'salario' => 'required|numeric',
            'foto' => 'required|image|max:1024',
            'empresa_id' => 'required|numeric',
        ]);


        $path = $request->foto->store('public/img');
        $archivo = $request->foto->hashName();


        Empleado::create([

            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cedula' => $request->cedula,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'salario' => $request->salario,
            'foto' => $archivo,
            'empresa_id' => $request->empresa_id,
        ]);

        //Empleado::create($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado Creado con Exito.');

        //return $request;

    }



    public function edit(Empleado $empleado)
    {
        $empresas = Empresa::all();
        return view('empleados.edit', compact('empleado', 'empresas'));
    }


    public function update(Request $request, Empleado $empleado)
    {
        //
        $request->validate([

            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'cedula' => 'required|max:255',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required|email',
            'salario' => 'required|numeric',
            'foto' => 'file|image|max:1024',
            'empresa_id' => 'required|numeric',
        ]);


        if ($request->hasFile('foto')) {


            $archivoAnterior = 'public/img/' . $empleado->foto;

            if (Storage::exists($archivoAnterior)) {

                Storage::delete($archivoAnterior);
            }

            $path = $request->foto->store('public/img');
            $archivo = $request->foto->hashName();

            $empleado->update([

                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'salario' => $request->salario,
                'foto' => $archivo,
                'empresa_id' => $request->empresa_id,
            ]);
        } else {

            $empleado->update([

                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'salario' => $request->salario,
                'empresa_id' => $request->empresa_id,
            ]);
        }


        //$empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado Actualizado con Exito.');
    }


    public function destroy(Empleado $empleado)
    {

        $archivoAnterior = 'public/img/' . $empleado->foto;

        if (Storage::exists($archivoAnterior)) {

            Storage::delete($archivoAnterior);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado Borrado con Exito.');
    }


    public function search(Request $request)
    {

        //dd($request);

        if ($request->search) {

            //return 'con valor';

            $busqueda = $request->search;

            $empleados = Empleado::where('nombre', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('cedula', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('email', 'LIKE', '%' . $busqueda . '%')
                ->paginate(15)->withQueryString();

            return view('empleados.index', compact('empleados'));
        } else {

            //return 'sin valor';

            return redirect()->route('empleados.index');
        }
    }

    public function export()
    {
        return Excel::download(new EmpleadoExport, 'empleado.xlsx');
    }
}
