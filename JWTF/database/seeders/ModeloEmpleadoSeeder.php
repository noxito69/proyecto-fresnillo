<?php

namespace Database\Seeders;

use App\Models\ModeloEmpleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModeloEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModeloEmpleado::create([
            'nombre' => 'ZBOOK FIREFLY G10'
        
        ]);

        ModeloEmpleado::create([
            'nombre' => 'ZBOOK FIREFLY 14 G7'
        
        ]);

        ModeloEmpleado::create([
            'nombre' => 'ZBOOK 14U G6'
        
        ]);

        ModeloEmpleado::create([
            'nombre' => 'DELL LATITUDE 5420'
        
        ]);




    }
}
