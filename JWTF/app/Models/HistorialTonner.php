<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTonner extends Model
{
    use HasFactory;

    protected $fillable = ['fecha', 'cantidad', 'tonner_id'];

    public function tonner()
    {
        return $this->belongsTo(Tonner::class);
    }
}
