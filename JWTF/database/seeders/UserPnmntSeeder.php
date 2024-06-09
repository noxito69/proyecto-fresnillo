<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UsuarioPenmont;

class UserPnmntSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UsuarioPenmont::create([
            'num_empleado' => '1001',
            'email' => 'empleado1@empresa.com',
            'nombre' => 'Juan Perez',
            'departamento_id' => 1,
            'centro_costos_id' => 1
        ]);

        UsuarioPenmont::create([
            'num_empleado' => '1002',
            'email' => 'empleado2@empresa.com',
            'nombre' => 'Maria Garcia',
            'departamento_id' => 2,
            'centro_costos_id' => 2
        ]);

        UsuarioPenmont::create([
            'num_empleado' => '1003',
            'email' => 'empleado3@empresa.com',
            'nombre' => 'Luis Fernandez',
            'departamento_id' => 3,
            'centro_costos_id' => 3
        ]);
    }
}
