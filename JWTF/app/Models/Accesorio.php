<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesorio extends Model
{
    use HasFactory;

    protected $fillable = ['cantidad', 'articulo', 'marca', 'codigo_barras'];

    public function historial()
    {
        return $this->hasMany(Historial::class);
    }
}
