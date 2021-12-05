<?php

namespace App\Exports;

use App\Models\Paridad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class ParidadExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'id',
            'Tasa',
            'Creado',
            'Actualizado'            
        ];
    }

    public function collection()
    {
        return Paridad::all();
    }
}
