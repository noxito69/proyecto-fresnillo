<?php

namespace Database\Seeders;

use App\Models\TipoEquipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tipo_equipo_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEquipo::create([

            'nombre'=>'Laptop',
        ]);

        TipoEquipo::create([

            'nombre'=>'Ipad',
        ]);

        TipoEquipo::create([

            'nombre'=>'Celular',
        ]);

        
    }
}
