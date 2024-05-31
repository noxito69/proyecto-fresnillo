<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impresora extends Model
{
    use HasFactory;

    protected $fillable = ['numero_serie', 'departamento_id', 'IP', 'ubicacion'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function historialImpresoras()
    {
        return $this->hasMany(HistorialImpresora::class);
    }
}
