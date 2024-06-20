<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EtiquetaContratista;

class ECseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        EtiquetaContratista::create([
            'modelo' => 'modelo1', 
            'tipo_equipo' => 'Computadora',
            'marca' => 'Dell',
            'numero_serie' => 'SN123456',
            'usuario' => 'Contratista A',
            'empresa' => 'MOR',
            'fecha_vigencia' => '2024-12-31',
          
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo2',
            'tipo_equipo' => 'Computadora',
            'marca' => 'HP',
            'numero_serie' => 'SN123457',
            'usuario' => 'Contratista B',
            'empresa' => 'MOR',
            'fecha_vigencia' => '2024-11-30',
          
        ]);

        EtiquetaContratista::create([
          
            'modelo' => 'modelo3',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Lenovo',
            'numero_serie' => 'SN123458',
            'usuario' => 'Contratista C',
            'empresa' => 'MOR',
            'fecha_vigencia' => '2024-10-31',
           
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo4',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Asus',
            'numero_serie' => 'SN123459',
            'usuario' => 'Contratista D',
            'empresa' => 'CONSTRUPLAN',
            'fecha_vigencia' => '2024-09-30',
            
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo5',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Acer',
            'numero_serie' => 'SN123460',
            'usuario' => 'Contratista E',
            'empresa' => 'CONSTRUPLAN',
            'fecha_vigencia' => '2024-08-31',
            
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo6',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Apple',
            'numero_serie' => 'SN123461',
            'usuario' => 'Contratista F',
            'empresa' => 'CONSTRUPLAN',
            'fecha_vigencia' => '2024-07-31',
           
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo7',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Samsung',
            'numero_serie' => 'SN123462',
            'usuario' => 'Contratista G',
            'empresa' => 'HANKA',
            'fecha_vigencia' => '2024-06-30',
           
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo8',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Sony',
            'numero_serie' => 'SN123463',
            'usuario' => 'Contratista H',
            'empresa' => 'HANKA',
            'fecha_vigencia' => '2024-05-31',
            
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo9',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Toshiba',
            'numero_serie' => 'SN123464',
            'usuario' => 'Contratista I',
            'empresa' => 'HANKA',
            'fecha_vigencia' => '2024-04-30',
           
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo10',
            'tipo_equipo' => 'Computadora',
            'marca' => 'LG',
            'numero_serie' => 'SN123465',
            'usuario' => 'Contratista J',
            'empresa' => 'MATCO',
            'fecha_vigencia' => '2024-03-31',
           
        ]);

        EtiquetaContratista::create([
            'modelo' => 'modelo11',
            'tipo_equipo' => 'Computadora',
            'marca' => 'Xiaomi',
            'numero_serie' => 'SN123466',
            'usuario' => 'Contratista K',
            'empresa' => 'MATCO',
            'fecha_vigencia' => '2024-02-28',
            
        ]);
    }
}
