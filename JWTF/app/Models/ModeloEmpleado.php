<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloEmpleado extends Model
{

    protected $table = 'modelo_empleado';
    use HasFactory;

    protected $fillable = [
        'nombre',
        'is_active'
    ];

}
