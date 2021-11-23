<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable=['nombre','apellido','cedula','direccion','telefono','email','salario','foto','empresa_id'];
}
