<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{

    protected $table = 'historial';

    use HasFactory;

    protected $fillable = ['fecha', 'num_empleado', 'usuario', 'articulo_id', 'cantidad', 'departamento', 'centro_costos'];

    public function usuarioPenmont()
    {
        return $this->belongsTo(UsuarioPenmont::class, 'num_empleado', 'num_empleado');
    }

    public function accesorio()
    {
        return $this->belongsTo(Accesorio::class, 'articulo_id');
    }

  
}
