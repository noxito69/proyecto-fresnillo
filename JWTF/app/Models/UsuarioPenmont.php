<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioPenmont extends Model
{

    protected $table = 'usuarios_penmont';
    use HasFactory;

    protected $fillable = ['num_empleado', 'email', 'nombre', 'departamento_id', 'centro_costos_id'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costos_id');
    }

    public function etiquetasEmpleados()
    {
        return $this->hasMany(EtiquetaEmpleado::class);
    }

    public function historial()
    {
        return $this->hasMany(Historial::class);
    }


}
