<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tonner;

class TonnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tonner::create([
            'numero_guia' => '123456',
            'cantidad' => 20,
            'codigo' => 'T123',
            'color' => 'Negro'
        ]);

        Tonner::create([
            'numero_guia'=>'12349',
            'cantidad' => 15,
            'codigo' => 'T456',
            'color' => 'Cian'
        ]);
    }
}
