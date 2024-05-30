<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EtiquetaContratista;

class ECseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        EtiquetaContratista::create([
            'equipo_id' => 1,
            'numero_serie' => 'SN123456',
            'usuario' => 'Contratista A',
            'empresa_id' => 1,
            'fecha_vigencia' => '2024-12-31',
        ]);

        EtiquetaContratista::create([
            'equipo_id' => 1,
            'numero_serie' => 'SN123457',
            'usuario' => 'Contratista B',
            'empresa_id' => 1,
            'fecha_vigencia' => '2024-11-30',
        ]);

        EtiquetaContratista::create([
            'equipo_id' => 2,
            'numero_serie' => 'SN123458',
            'usuario' => 'Contratista C',
            'empresa_id' => 2,
            'fecha_vigencia' => '2024-10-31',
        ]);
    }
}
