<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\GrupoCaracteristica;

use Illuminate\Database\Seeder;

class GruposCaracteristicaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grupos = [
            ['nombre' => 'Electrodomésticos', 'enum_estado' => 'ACTIVO'],
            ['nombre' => 'Amoblado', 'enum_estado' => 'ACTIVO'],
        ];

        foreach ($grupos as $grupo) {
            GrupoCaracteristica::create($grupo);
        }
    }
}
