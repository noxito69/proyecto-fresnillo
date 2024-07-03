<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array=[
            ['rol'=>'admin'],
            ['rol'=>'su'],
            ['rol'=>'etiqueta'],
            ['rol'=>'usuario']
        ];

        foreach($array as $key=>$row){

            DB::table('roles')->insert($row);
        }
    }
}
