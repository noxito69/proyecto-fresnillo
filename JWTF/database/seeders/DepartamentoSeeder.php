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
            'centro_costos_id' => 1,
        ]);

        Departamento::create([
            'nombre' => 'Planta MC',
            'centro_costos_id' => 2,
        ]);

        Departamento::create([
            'nombre' => 'Planta Lixiviación Dinamica',
            'centro_costos_id' => 3,
        ]);

        Departamento::create([
            'nombre' => 'Planta Concen. Jales',
            'centro_costos_id' => 4,
        ]);

        Departamento::create([
            'nombre' => 'Planeacion',
            'centro_costos_id' => 5,
        ]);

        Departamento::create([
            'nombre' => 'Ingenieria',
            'centro_costos_id' => 6,
        ]);

        Departamento::create([
            'nombre' => 'Gerencia de Unidad',
            'centro_costos_id' => 7,
        ]);

        Departamento::create([
            'nombre' => 'Geologia',
            'centro_costos_id' => 8,
        ]);

        Departamento::create([
            'nombre' => 'Geotecnia',
            'centro_costos_id' => 8,
        ]);

        Departamento::create([
            'nombre' => 'Explorac. Invest. y Des. (M)',
            'centro_costos_id' => 9,
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Relaciones Ind. (M)',
            'centro_costos_id' => 10,
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Relaciones Ind. (P)',
            'centro_costos_id' => 11,
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Rel. Lab. (P)',
            'centro_costos_id' => 12,
        ]);

        Departamento::create([
            'nombre' => 'Seguridad e Higiene',
            'centro_costos_id' => 13,
        ]);

        Departamento::create([
            'nombre' => 'Adm. de Calidad (M)',
            'centro_costos_id' => 14,
        ]);

        Departamento::create([
            'nombre' => 'Laboratorio (M)',
            'centro_costos_id' => 15,
        ]);

        Departamento::create([
            'nombre' => 'Abastecimientos (M)',
            'centro_costos_id' => 16,
        ]);

        Departamento::create([
            'nombre' => 'Despacho de Compras (P)',
            'centro_costos_id' => 17,
        ]);

        Departamento::create([
            'nombre' => 'Adm. Sist. y Tecnologia (M)',
            'centro_costos_id' => 18,
        ]);

        Departamento::create([
            'nombre' => 'Proteccion Ambiental (M)',
            'centro_costos_id' => 19,
        ]);

        Departamento::create([
            'nombre' => 'Sistemas de Seguridad (P)',
            'centro_costos_id' => 20,
        ]);

        Departamento::create([
            'nombre' => 'Servicio Medico (P)',
            'centro_costos_id' => 21,
        ]);

        Departamento::create([
            'nombre' => 'Limpieza y Mtto. de Areas (M)',
            'centro_costos_id' => 22,
        ]);

        Departamento::create([
            'nombre' => 'Tratamiento de Aguas (M)',
            'centro_costos_id' => 23,
        ]);

        Departamento::create([
            'nombre' => 'Ingenieria y Construccion (M)',
            'centro_costos_id' => 24,
        ]);

        Departamento::create([
            'nombre' => 'Contraloria (M)',
            'centro_costos_id' => 25,
        ]);

        Departamento::create([
            'nombre' => 'Superintend. Mantto.',
            'centro_costos_id' => 26,
        ]);

       

   



        

    }
}
