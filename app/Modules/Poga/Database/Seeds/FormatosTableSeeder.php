<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\Formato;

use Illuminate\Database\Seeder;

class FormatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formatos = [
            ['formato' => 'Vivienda', 'enum_estado' => 'ACTIVO'],
            ['formato' => 'Comercio', 'enum_estado' => 'ACTIVO'],
            ['formato' => 'Oficina', 'enum_estado' => 'ACTIVO'],
        ];

        foreach ($formatos as $formato) { Formato::create($formato);
        }
    }
}
