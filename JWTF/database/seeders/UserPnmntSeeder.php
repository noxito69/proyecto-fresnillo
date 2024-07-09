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
            'num_empleado' => '13318',
            'email' => 'JOSE_CONTRERAS@FRESNILLOPLC.COM',
            'nombre' => 'JOSE ADOLFO CONTRERAS MACIAS',
            'departamento' => 'Adm. Sist. y Tecnologia (M)',
            'centro_costos' => '800000',
        
        ]);
    }
}
