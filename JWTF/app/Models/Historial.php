<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{

    protected $table = 'historial';

    use HasFactory;

    protected $fillable = ['fecha', 'num_empleado', 'usuario', 'articulo_id', 'cantidad', 'departamento_id', 'centro_costos_id'];

    public function usuarioPenmont()
    {
        return $this->belongsTo(UsuarioPenmont::class, 'num_empleado', 'num_empleado');
    }

    public function accesorio()
    {
        return $this->belongsTo(Accesorio::class, 'articulo_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costos_id');
    }
}
