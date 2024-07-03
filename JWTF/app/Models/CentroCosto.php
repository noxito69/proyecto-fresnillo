<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre',];

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class);
    }
  

 
}
