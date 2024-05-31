<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HistorialImpresora;


class HistorialImpresoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistorialImpresora::create([
            'fecha' => '2024-05-30',
            'cantidad' => 10,
            'departamento_id' => 1,
            'impresora_id' => 1,
            'centro_costos_id' => 1
        ]);

        HistorialImpresora::create([
            'fecha' => '2024-05-31',
            'cantidad' => 5,
            'departamento_id' => 2,
            'impresora_id' => 2,
            'centro_costos_id' => 2
        ]);
    }
}
