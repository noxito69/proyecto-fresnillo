<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    use HasFactory;

    protected $table = 'tipo_equipo'; 

    protected $fillable = ['nombre'];

    public function etiquetasContratistas()
    {
        return $this->hasMany(EtiquetaContratista::class, 'tipo_equipo_id');
    }
}

