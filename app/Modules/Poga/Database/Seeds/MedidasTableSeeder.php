<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\Medida;

use Illuminate\Database\Seeder;

class MedidasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medidas = [
            ['tipo' => 'm2', 'descripcion' => 'Metros cuadrados', 'enum_estado' => 'ACTIVO'],
        ];

        foreach ($medidas as $medida) { Medida::create($medida);
        }
    }
}
