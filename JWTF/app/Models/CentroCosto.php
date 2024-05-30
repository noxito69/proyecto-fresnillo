<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'centro_costos_id'];

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class);
    }

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
}
