<?php

namespace Database\Seeders;

use App\Models\Modelo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modelo::create([
            'nombre' => '',
            
        ]);

        Modelo::create([
            'nombre' => 'Modelo 2',
          
        ]);

        Modelo::create([
            'nombre' => 'Modelo 3',
        ]);
    }
}
