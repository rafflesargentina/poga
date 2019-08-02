<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\Servicio;

use Illuminate\Database\Seeder;

class ServiciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicios = [
            ['nombre' => 'Plomería', 'descripcion' => 'Plomería', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Carpintería', 'descripcion' => 'Carpintería', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Vidriería', 'descripcion' => 'Vidriería', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Electricidad', 'descripcion' => 'Electricidad', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Albañilería', 'descripcion' => 'Albañilería', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Técnico Informático', 'descripcion' => 'Técnico Informático', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Otros', 'descripcion' => 'Otros', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Climatización', 'descripcion' => 'Climatización', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Jardinería', 'descripcion' => 'Jardinería', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Pinturería', 'descripcion' => 'Pinturería', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Alarma/Seguridad', 'descripcion' => 'Alarma/Seguridad', 'enum_estado' => 'ACTIVO'],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
