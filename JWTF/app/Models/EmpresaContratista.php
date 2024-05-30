<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaContratista extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function etiquetasContratistas()
    {
        return $this->hasMany(EtiquetaContratista::class);
    }
}
