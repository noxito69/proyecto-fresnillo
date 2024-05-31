<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialImpresora extends Model
{
    use HasFactory;

    protected $fillable = ['fecha', 'cantidad', 'departamento_id', 'impresora_id', 'centro_costos_id'];

    public function impresora()
    {
        return $this->belongsTo(Impresora::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class);
    }
}
