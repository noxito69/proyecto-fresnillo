<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CentroCosto;
use App\Models\EmpresaContratista;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([



            RoleSeeder::class,
            CentroCostoSeeder::class,
            DepartamentoSeeder::class,
            AccesorioSeeder::class,
            AnexoSeeder::class,
            equipoSeeder::class,
            EmpresaC::class,
            UserPnmntSeeder::class,
            ECseeder::class,
            EtiEmpleado::class,
            Hseeder::class


        ]);

    }
}
