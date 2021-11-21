<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpresaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'id',
            'Nombre',
            'Rif',
            'Direccion',
            'Telefono',
            'Email',
            'Creado',
            'Actualizado'
        ];
    }
       
    public function collection()
    {
        return Empresa::all();
    }
}
