<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departamento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'centro_costos', 'is_active'];


    public function usuariosPenmont()
    {
        return $this->hasMany(UsuarioPenmont::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function etiquetasEmpleados()
    {
        return $this->hasMany(EtiquetaEmpleado::class);
    }

    public function historial()
    {
        return $this->hasMany(Historial::class);
    }

    public function historialPrestamos()
    {
        return $this->hasMany(Historial_prestamos::class);
    }
}
