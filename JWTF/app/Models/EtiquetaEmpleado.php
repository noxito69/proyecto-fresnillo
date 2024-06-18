<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaEmpleado extends Model


{

    protected $table = 'etiquetas_empleados';
    
    use HasFactory;

    protected $fillable = ['numero_serie', 'modelo', 'usuario_id', 'host', 'tipo_equipo_id','marca_id', 'mac', 'departamento_id', 'anexo_id', 'fecha_vigencia','fecha_actual'];

    public function usuarioPenmont()
    {
        return $this->belongsTo(UsuarioPenmont::class, 'usuario_id');
    }


    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function anexo()
    {
        return $this->belongsTo(Anexo::class);
    }

    public function tipoEquipo()
    {
        return $this->belongsTo(TipoEquipo::class, 'tipo_equipo_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }


    
}
