<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Impresora;

class ImpresoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Impresora::create([
       
            'numero_serie' => '12345ABC',
            'departamento_id' => 1,
            'IP' => '192.168.1.10',
            'ubicacion' => 'Oficina Principal'
        ]);

        Impresora::create([
     
            'numero_serie' => '67890XYZ',
            'departamento_id' => 2,
            'IP' => '192.168.1.11',
            'ubicacion' => 'Sala de Juntas'
        ]);
    }
}
