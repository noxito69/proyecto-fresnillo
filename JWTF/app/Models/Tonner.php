<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tonner extends Model
{
    use HasFactory;

    protected $fillable = ['numero_guia','cantidad', 'codigo', 'color'];

    public function historialTonner()
    {
        return $this->hasMany(HistorialTonner::class);
    }
}
