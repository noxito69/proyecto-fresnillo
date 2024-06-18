<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class marca_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marca::create(['nombre' => 'Marca 1']);
        Marca::create(['nombre' => 'Marca 2']);
        Marca::create(['nombre' => 'Marca 3']);
        Marca::create(['nombre' => 'Marca 4']);
        Marca::create(['nombre' => 'Marca 5']);
    }
}
