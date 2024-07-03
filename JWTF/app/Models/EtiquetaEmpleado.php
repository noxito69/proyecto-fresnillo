<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaEmpleado extends Model


{

    protected $table = 'etiquetas_empleados';
    
    use HasFactory;

    protected $fillable = ['numero_serie', 'numero_etiqueta', 'modelo', 'ip','usuario', 'host','marca', 'mac', 'departamento', 'anexo', 'fecha_vigencia','fecha_actual'];


}
