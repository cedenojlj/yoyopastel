<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{
    use HasFactory;

    protected $fillable=['nombre','apellido','cedula','direccion',
    'telefono','email','salario','foto','empresa_id','user_id'];


    public function empresa()
    {
       return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
