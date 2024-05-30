<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anexo;

class AnexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Anexo::create([
            'nombre' => 'Contrato A',
            'fecha_caducidad' => '2025-12-31',
        ]);

        Anexo::create([
            'nombre' => 'Contrato B',
            'fecha_caducidad' => '2024-06-30',
        ]);

        Anexo::create([
            'nombre' => 'Contrato C',
            'fecha_caducidad' => '2023-11-15',
        ]);
    }
}
