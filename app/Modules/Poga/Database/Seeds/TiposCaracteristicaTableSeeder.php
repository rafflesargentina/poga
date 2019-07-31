<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\TipoCaracteristica;

use Illuminate\Database\Seeder;

class TiposCaracteristicaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposCaracteristicas = [
            ['nombre' => 'El lugar', 'descripcion' => 'El lugar', 'enum_estado' => 'ACTIVO', 'visibilidad_publica' => 'true'],
            ['nombre' => 'Comodidades', 'descripcion' => 'Comodidades', 'enum_estado' => 'ACTIVO', 'visibilidad_publica' => 'true'],
            ['nombre' => 'Personal', 'descripcion' => 'Personal', 'enum_estado' => 'ACTIVO', 'visibilidad_publica' => 'true'],
            ['nombre' => 'Funciones de seguridad', 'descripcion' => 'Funciones de seguridad', 'enum_estado' => 'ACTIVO', 'visibilidad_publica' => 'false'],
            ['nombre' => 'Normas del inmueble', 'descripcion' => 'Normas del inmueble', 'enum_estado' => 'ACTIVO', 'visibilidad_publica' => 'true'],
        ];

        foreach ($tiposCaracteristicas as $tipoCaracteristica) TipoCaracteristica::create($tipoCaracteristica);
    }
}
