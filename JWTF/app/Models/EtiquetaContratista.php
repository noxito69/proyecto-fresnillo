<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaContratista extends Model


{

    protected $table = 'etiquetas_contratistas';

    use HasFactory;

    protected $fillable = ['tipo_equipo', 'marca', 'numero_serie', 'usuario', 'empresa', 'fecha_vigencia' , 'modelo', 'numero_etiqueta'];



}

