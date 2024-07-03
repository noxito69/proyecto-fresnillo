<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;


class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Departamento::create([
            'nombre' => 'Mina (M)',
            'centro_costos' => '000000',
        ]);

        Departamento::create([
            'nombre' => 'Planta MC',
            'centro_costos' => '100000',
        ]);

        Departamento::create([
            'nombre' => 'Planta Lixiviación Dinamica',
            'centro_costos' => '110000',
        ]);

        Departamento::create([
            'nombre' => 'Planta Concen. Jales',
            'centro_costos' => '120000',
        ]);

        Departamento::create([
            'nombre' => 'Planeacion',
            'centro_costos' => '201101',
        ]);

        Departamento::create([
            'nombre' => 'Ingenieria',
            'centro_costos' => '201102',
        ]);

        Departamento::create([
            'nombre' => 'Gerencia de Unidad',
            'centro_costos' => '201201',
        ]);

        Departamento::create([
            'nombre' => 'Geologia',
            'centro_costos' => '201301',
        ]);

        Departamento::create([
            'nombre' => 'Geotecnia',
            'centro_costos' => '201301',
        ]);

        Departamento::create([
            'nombre' => 'Explorac. Invest. y Des. (M)',
            'centro_costos' => '730000',
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Relaciones Ind. (M)',
            'centro_costos' => '750000',
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Relaciones Ind. (P)',
            'centro_costos' => '750200',
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Rel. Lab. (P)',
            'centro_costos' => '750300',
        ]);

        Departamento::create([
            'nombre' => 'Seguridad e Higiene',
            'centro_costos' => '750400',
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Calidad (M)',
            'centro_costos' => '760000',
        ]);

        Departamento::create([
            'nombre' => 'Laboratorio (M)',
            'centro_costos' => '770000',
        ]);

        Departamento::create([
            'nombre' => 'Abastecimientos (M)',
            'centro_costos' => '780000',
        ]);

        Departamento::create([
            'nombre' => 'Despacho de Compras (P)',
            'centro_costos' => '781000',
        ]);

        Departamento::create([
            'nombre' => 'Adm. Sist. y Tecnologia (M)',
            'centro_costos' => '800000',
        ]);

        Departamento::create([
            'nombre' => 'Proteccion Ambiental (M)',
            'centro_costos' => '820000',
        ]);

        Departamento::create([
            'nombre' => 'Sistemas de Seguridad (P)',
            'centro_costos' => '850100',
        ]);

        Departamento::create([
            'nombre' => 'Servicio Medico (P)',
            'centro_costos' => '860100',
        ]);

        Departamento::create([
            'nombre' => 'Limpieza y Mtto. de Areas (M)',
            'centro_costos' => '870000',
        ]);

        Departamento::create([
            'nombre' => 'Tratamiento de Aguas (M)',
            'centro_costos' => '880000',
        ]);

        Departamento::create([
            'nombre' => 'Ingenieria y Construccion (M)',
            'centro_costos' => '890000',
        ]);

        Departamento::create([
            'nombre' => 'Contraloria (M)',
            'centro_costos' => '950200',
        ]);

        Departamento::create([
            'nombre' => 'Superintend. Mantto.',
            'centro_costos' => '201501',
        ]);



   



        

    }
}
