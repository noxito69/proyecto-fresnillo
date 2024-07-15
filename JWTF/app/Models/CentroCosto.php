<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'is_active'];

    public function centroCosto()
    {   
        return $this->belongsTo(CentroCosto::class);
    }
  

 
}
