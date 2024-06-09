<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Historial;

class Hseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Historial::create([
            'fecha' => '2024-01-01',
            'num_empleado' => '1001',
            'usuario' => 'Juan Perez',
            'articulo_id' => 1,
            'cantidad' => 2,
            'departamento' => 'a',
            'centro_costos' => 'aa',
        ]);

        Historial::create([
            'fecha' => '2024-01-02',
            'num_empleado' => '1002',
            'usuario' => 'Maria Garcia',
            'articulo_id' => 2,
            'cantidad' => 1,
            'departamento' => 'aaaa',
            'centro_costos' => 'aaaaa',
        ]);

        Historial::create([
            'fecha' => '2024-01-03',
            'num_empleado' => '1003',
            'usuario' => 'Luis Fernandez',
            'articulo_id' => 3,
            'cantidad' => 3,
            'departamento' => 'aaaaa',
            'centro_costos' => 'aaaaaa',
        ]);
    }
}
