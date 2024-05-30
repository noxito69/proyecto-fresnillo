<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accesorio;

class AccesorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Accesorio::create([
            'cantidad' => 10,
            'articulo' => 'Teclado',
            'marca' => 'Logitech',
            'codigo_barras' => '1234567890123',
        ]);

        Accesorio::create([
            'cantidad' => 5,
            'articulo' => 'Ratón',
            'marca' => 'Microsoft',
            'codigo_barras' => '1234567890124',
        ]);

        Accesorio::create([
            'cantidad' => 8,
            'articulo' => 'Monitor',
            'marca' => 'Dell',
            'codigo_barras' => '1234567890125',
        ]);
    }
}
