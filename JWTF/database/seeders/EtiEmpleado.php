<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EtiquetaEmpleado;

class EtiEmpleado extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EtiquetaEmpleado::create([
  
         
            'modelo' => 'modelo1', 
            'numero_serie' => 'SN223456',
            'usuario' => 'Usuario1',
            'host' => 'Host1',
            'mac' => '00:14:22:01:23:45',
            'departamento' => 'Departamento1',
            'anexo' => 'Anexo1',
            'fecha_vigencia' => '2024-12-31',
            'fecha_actual' => '2024-11-20'
        ]);

        EtiquetaEmpleado::create([
       
          
            'modelo' => 'modelo2',
            'numero_serie' => 'SN223457',
            'usuario' => '2',
            'host' => 'Host2',
            'mac' => '00:14:22:01:23:46',
            'departamento' => '2',
            'anexo' => '2',
            'fecha_vigencia' => '2024-11-30',
            'fecha_actual' => '2024-11-20'
        ]);

        EtiquetaEmpleado::create([
           
      
            'modelo' => 'modelo3',
            'numero_serie' => 'SN223458',
            'usuario' => '3',
            'host' => 'Host3',
            'mac' => '00:14:22:01:23:47',
            'departamento' => '3',
            'anexo' => '3',
            'fecha_vigencia' => '2024-10-31',
            'fecha_actual' => '2024-11-20'
        ]);
    }
}
