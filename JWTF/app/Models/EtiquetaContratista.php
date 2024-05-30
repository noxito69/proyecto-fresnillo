<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaContratista extends Model


{

    protected $table = 'etiquetas_contratistas';

    use HasFactory;

    protected $fillable = ['equipo_id', 'numero_serie', 'usuario', 'empresa_id', 'fecha_vigencia'];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function empresaContratista()
    {
        return $this->belongsTo(EmpresaContratista::class, 'empresa_id');
    }
}

