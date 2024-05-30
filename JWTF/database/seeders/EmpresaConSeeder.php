<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmpresaContratista;

class EmpresaConSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmpresaContratista::create([
            'nombre' => 'Empresa A',
        ]);

        EmpresaContratista::create([
            'nombre' => 'Empresa B',
        ]);

        EmpresaContratista::create([
            'nombre' => 'Empresa C',
        ]);
    }
}
