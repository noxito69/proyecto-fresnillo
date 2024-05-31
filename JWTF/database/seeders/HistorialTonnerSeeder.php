<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HistorialTonner;

class HistorialTonnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistorialTonner::create([
            'fecha' => '2024-05-30',
            'cantidad' => 20,
            'tonner_id' => 1
        ]);

        HistorialTonner::create([
            'fecha' => '2024-05-31',
            'cantidad' => 15,
            'tonner_id' => 2
        ]);
    }
}
