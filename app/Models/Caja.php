<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;


    protected $fillable=[

        'fecha',
        'factura',        
        'total',
        'paridad',
        'moneda',
        'metodo',        
        'user_id',
        'empresa_id',
        'venta_id'
    ];

}
