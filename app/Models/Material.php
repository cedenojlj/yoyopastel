<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable=[        
       
        'codigo',
        'nombre',
        'descripcion',        
        'costo',        
        'stock_min'
    ];

    public function compras()
    {
        return $this->belongsToMany(Compra::class,'compra_material');
    }

}
