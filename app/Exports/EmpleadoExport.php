<?php

namespace App\Exports;

use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpleadoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'id',
            'Nombre',
            'Apellido',
            'Cedula',
            'Direccion',
            'Telefono',
            'Email',
            'Salario',
            'Foto',
            'Empresa_id',
            'Creado',
            'Actualizado'
        ];
    }


    public function collection()
    {
        return Empleado::all();
    }
}
