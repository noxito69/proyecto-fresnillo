<?php

namespace Database\Seeders;

use App\Models\Historial_prestamos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Historial_prestamos::create([
           
            'num_empleado' => '13318',
            'usuario' => 'ADOLFO CONTRERAS MACIAS',
            'articulo_id' => 1,
            'cantidad' => 2,
            'departamento' => 'Planta de Lixiviación Dinamica', 
            'centro_costos' => '800600',
            'fecha_devolucion' => '2024-08-10'
        ]);
    }
}
