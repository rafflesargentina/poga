<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\Moneda;

use Illuminate\Database\Seeder;

class MonedasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monedas = [
            [
                'moneda' => 'GUARANI', 
                'abbr' => '?', 
                'enum_estado' => 'ACTIVO'
            ], // 1
           
        ];

        foreach ($monedas as $moneda) Moneda::create($moneda);
    }
}