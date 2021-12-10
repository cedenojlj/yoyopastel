<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaterialExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [

            'id',
            'codigo',            
            'nombre',
            'descripcion',            
            'costo',            
            'stock_min',                   
            'Creado',
            'Actualizado'

        ];
    }



    public function collection()
    {
        return Material::all();
    }
}
