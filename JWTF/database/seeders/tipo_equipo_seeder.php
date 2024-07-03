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

            'nombre'=>'LAPTOP',
        ]);

        TipoEquipo::create([

            'nombre'=>'DISCO DURO',
        ]);

        TipoEquipo::create([

            'nombre'=>'TABLETA',
        ]);

        TipoEquipo::create([

            'nombre'=>'BLASTING',
        ]);

        TipoEquipo::create([

            'nombre'=>'DIGITAL LOG',
        ]);

        TipoEquipo::create([

            'nombre'=>'GPS',
        ]);

        TipoEquipo::create([

            'nombre'=>'DRONE',
        ]);

        TipoEquipo::create([

            'nombre'=>'CAMARA',
        ]);

        TipoEquipo::create([

            'nombre'=>'HAND HELD',
        ]);

        
    }
}
