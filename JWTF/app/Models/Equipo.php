<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'modelo', 'marca'];

    public function etiquetasContratistas()
    {
        return $this->hasMany(EtiquetaContratista::class);
    }

    public function etiquetasEmpleados()
    {
        return $this->hasMany(EtiquetaEmpleado::class);
    }
}