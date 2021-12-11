<?php

namespace App\Exports;

use App\Models\Compra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CompraExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [

            'id',
            'fecha',
            'factura',
            'subtotal',
            'iva',
            'total',
            'proveedor_id',
            'user_id',            
            'Empresa_id',
            'Creado',
            'Actualizado'
            
        ];
    }

    public function collection()
    {
        return Compra::all();
    }
}
