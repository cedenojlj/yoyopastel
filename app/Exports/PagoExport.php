<?php

namespace App\Exports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'id',
            'Pago',
            'Referencia',
            'Concepto',
            'Creado',
            'Actualizado'            
        ];
    }

    public function collection()
    {
        return Pago::all();
    }
}
