<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EtiquetaEmpleado;

class EtiEmpleado extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EtiquetaEmpleado::create([
            'numero_serie' => 'SN223456',
            'usuario_id' => 1,
            'host' => 'Host1',
            'equipo_id' => 1,
            'mac' => '00:14:22:01:23:45',
            'departamento_id' => 1,
            'anexo_id' => 1,
            'fecha_vigencia' => '2024-12-31',
        ]);

        EtiquetaEmpleado::create([
            'numero_serie' => 'SN223457',
            'usuario_id' => 2,
            'host' => 'Host2',
            'equipo_id' => 2,
            'mac' => '00:14:22:01:23:46',
            'departamento_id' => 2,
            'anexo_id' => 2,
            'fecha_vigencia' => '2024-11-30',
        ]);

        EtiquetaEmpleado::create([
            'numero_serie' => 'SN223458',
            'usuario_id' => 3,
            'host' => 'Host3',
            'equipo_id' => 3,
            'mac' => '00:14:22:01:23:47',
            'departamento_id' => 3,
            'anexo_id' => 3,
            'fecha_vigencia' => '2024-10-31',
        ]);
    }
}
