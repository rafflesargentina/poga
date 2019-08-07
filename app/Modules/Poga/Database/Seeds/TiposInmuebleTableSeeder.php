<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\TipoInmueble;

use Illuminate\Database\Seeder;

class TiposInmuebleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposInmueble = [
            ['tipo' => 'Edificio', 'descripcion' => 'Edificio', 'enum_aplica_a' => 'INMUEBLES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'true'],
            ['tipo' => 'Casa', 'descripcion' => 'Casa', 'enum_aplica_a' => 'INMUEBLES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'false'],
            ['tipo' => 'Duplex', 'descripcion' => 'Duplex', 'enum_aplica_a' => 'INMUEBLES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'false', 'cant_pisos_fija' => '2'],
            ['tipo' => 'Triplex', 'descripcion' => 'Triplex', 'enum_aplica_a' => 'INMUEBLES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'false', 'cant_pisos_fija' => '3'],
            ['tipo' => 'Departamento', 'descripcion' => 'Departamento', 'enum_aplica_a' => 'UNIDADES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'false'],
            ['tipo' => 'Flat', 'descripcion' => 'Flat', 'enum_aplica_a' => 'UNIDADES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'false'],
            ['tipo' => 'Penthouse', 'descripcion' => 'Penthouse', 'enum_aplica_a' => 'UNIDADES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'false'],
            ['tipo' => 'Loft', 'descripcion' => 'Loft', 'enum_aplica_a' => 'UNIDADES', 'enum_estado' => 'ACTIVO', 'configurable_division_unidades' => 'false']
        ];

        foreach ($tiposInmueble as $tipoInmueble) { TipoInmueble::create($tipoInmueble);
        }
    }
}
