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
            'nombre' => 'A-1330',
            'fecha_caducidad' => '2025-12-31',
        ]);

        Anexo::create([
            'nombre' => 'A-1103',
            'fecha_caducidad' => '2024-06-30',
        ]);

        Anexo::create([
            'nombre' => '1001A',
            'fecha_caducidad' => '2023-11-15',
        ]);

        Anexo::create([
            'nombre' => '1331-0',
            'fecha_caducidad' => '2022-09-30',
        ]);
    }
}
