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
            ['rol'=>'Admin'],
            ['rol'=>'User'],
            ['rol'=>'Guest']
        ];

        foreach($array as $key=>$row){

            DB::table('roles')->insert($row);
        }
    }
}
