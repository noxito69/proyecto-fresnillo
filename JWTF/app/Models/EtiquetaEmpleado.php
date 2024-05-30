<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaEmpleado extends Model


{

    protected $table = 'etiquetas_empleados';
    
    use HasFactory;

    protected $fillable = ['numero_serie', 'usuario_id', 'host', 'equipo_id', 'mac', 'departamento_id', 'anexo_id', 'fecha_vigencia'];

    public function usuarioPenmont()
    {
        return $this->belongsTo(UsuarioPenmont::class, 'usuario_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function anexo()
    {
        return $this->belongsTo(Anexo::class);
    }
}
