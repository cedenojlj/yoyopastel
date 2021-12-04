<?php

namespace App\Exports;

use App\Models\Invproducto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvproductoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [

            'id',
            'Entrada',
            'Salida',
            'Producto',            
            'Creado',
            'Actualizado'
            
        ];
    }

    public function collection()
    {
        return Invproducto::all();
    }
}
