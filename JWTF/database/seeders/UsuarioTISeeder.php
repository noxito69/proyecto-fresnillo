<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioTISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'name' => 'JOSE ADOLFO CONTRERAS MACIAS',
            'email' => 'JOSE_CONTRERAS@FRESNILLOPLC.COM',
            'password' => Hash::make('Ad0lf0c0ntr3r45$'), 
            'rol_id' => 1, 
            'num_empleado' => '13318', 
            'is_active' => true,
        ]);


    }
}
