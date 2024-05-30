<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CentroCosto;

class CentroCostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CentroCosto::create([

            //1
            //mina
            'nombre' => '000000'
            
        ]);

        CentroCosto::create([

            //2
            //Planta MC
            'nombre' => '100000'
        
        ]);

        CentroCosto::create([

            //3

            //Planta Lixiviación Dinamica
            'nombre' => '110000'
            
        ]);

        CentroCosto::create([
            //4

            //Planta Concen. Jales
            'nombre' => '120000'
            
        ]);

        CentroCosto::create([
            //5
            
            //Planeacion
            'nombre' => '201101'
            
        ]);

        CentroCosto::create([
            //6

            //Ingenieria
            'nombre' => '201102'
            
        ]);

        CentroCosto::create([
            //7
            //Gerencia de Unidad
            'nombre' => '201201'
            
        ]);

        CentroCosto::create([
            //8
            //Geologia
            'nombre' => '201301'
            
        ]);

        CentroCosto::create([
            //9
            //Explorac. Invest. y Des. (M)
            'nombre' => '730000'
            
        ]);

        CentroCosto::create([
            //10
            //Adm. de Relaciones Ind. (M)
            'nombre' => '750000'
            
        ]);

        CentroCosto::create([
            //11
            //Adm. de Relaciones Ind. (P)
            'nombre' => '750200'
           
        ]);

        CentroCosto::create([
            //12
            //Adm. de Relaciones Lab. (P)
            'nombre' => '750300'
        
        ]);

        CentroCosto::create([
            //13
            //Seguridad e Higiene
            'nombre' => '750400'
         
        ]);



        CentroCosto::create([
            //14
            //Adm. de Calidad (M)
            'nombre' => '760000'
         
        ]);

        CentroCosto::create([
            //15
            //Laboratorio (M)
            'nombre' => '770000'
          
        ]);

        CentroCosto::create([
            //16
            //Abastecimientos (M)
            'nombre' => '780000'
            
        ]);

        CentroCosto::create([
            //17
            //Despacho de Compras (P)
            'nombre' => '781000'
            
        ]);

        CentroCosto::create([
            //18
            //Adm. Sist. y Tecnologia (M)
            'nombre' => '800000'
            
        ]);

        CentroCosto::create([
            //19    
            //Proteccion Ambiental (M)
            'nombre' => '820000'
            
        ]);

        CentroCosto::create([
            //20
            //Sistemas de seguridad (P)
            'nombre' => '850100'
           
        ]);

        CentroCosto::create([
            //21
            //Servicio Medico (P)
            'nombre' => '860100'
            
        ]);

        CentroCosto::create([
            //22
            //Limpieza y Mtto. de Areas (M)
            'nombre' => '870000'
           
        ]);

        CentroCosto::create([
            //23
            //Tratamiento de Aguas (M)
            'nombre' => '880000'
            
        ]);

        CentroCosto::create([
            //24
            //Ingenieria y Construccion (M)
            'nombre' => '890000'
            
        ]);


        CentroCosto::create([
            //25
            //Contraloria (P)
            'nombre' => '950200'
           
        ]);

        CentroCosto::create([
            //26e
            //Superintend. Mantto.
            'nombre' => '201501'
           
        ]);
    }
}
