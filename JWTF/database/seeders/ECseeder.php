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
            'modelo' => 'modelo1', 
            'tipo_equipo' => 'Computadora',
            'marca' => 'Dell',
            'numero_serie' => 'SN123456',
            'usuario' => 'Contratista A',
            'empresa' => '1',
            'fecha_vigencia' => '2024-12-31',
            'fecha_actual' => '2024-11-20'
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo2',
            'tipo_equipo' => 'Computadora',
            'marca' => 'HP',
            'numero_serie' => 'SN123457',
            'usuario' => 'Contratista B',
            'empresa' => '1',
            'fecha_vigencia' => '2024-11-30',
            'fecha_actual' => '2024-11-20'
        ]);

        EtiquetaContratista::create([
          
            'modelo' => 'modelo3',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Lenovo',
            'numero_serie' => 'SN123458',
            'usuario' => 'Contratista C',
            'empresa' => '1',
            'fecha_vigencia' => '2024-10-31',
            'fecha_actual' => '2024-11-20'
        ]);
    }
}
