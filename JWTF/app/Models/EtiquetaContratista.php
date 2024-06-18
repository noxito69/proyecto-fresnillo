<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaContratista extends Model


{

    protected $table = 'etiquetas_contratistas';

    use HasFactory;

    protected $fillable = ['tipo_equipo_id','marca_id', 'numero_serie', 'usuario', 'empresa_id', 'fecha_vigencia', 'fecha_actual' , 'modelo'];


    public function empresaContratista()
    {
        return $this->belongsTo(EmpresaContratista::class, 'empresa_id');
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

