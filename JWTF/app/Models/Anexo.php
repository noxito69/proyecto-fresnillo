<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'fecha_caducidad'];

    public function etiquetasEmpleados()
    {
        return $this->hasMany(EtiquetaEmpleado::class);
    }
}
