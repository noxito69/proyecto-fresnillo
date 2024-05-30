<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipo;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Equipo::create([
            'tipo' => 'Laptop',
            'modelo' => 'XPS 13',
            'marca' => 'Dell',
        ]);

        Equipo::create([
            'tipo' => 'Desktop',
            'modelo' => 'OptiPlex 7070',
            'marca' => 'Dell',
        ]);

        Equipo::create([
            'tipo' => 'Tablet',
            'modelo' => 'iPad Pro',
            'marca' => 'Apple',
        ]);
    }
}
