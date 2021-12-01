<?php

namespace App\Exports;

use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProveedorExport implements FromCollection, WithHeadings
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
        return Proveedor::all();
    }
}
