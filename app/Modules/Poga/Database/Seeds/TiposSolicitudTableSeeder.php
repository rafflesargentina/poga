<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\TipoSolicitud;

use Illuminate\Database\Seeder;

class TiposSolicitudTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposSolicitud = [
            ['nombre' => 'Reclamo'],
            ['nombre' => 'Petición'],
        ];

	foreach ($tiposSolicitud as $tipoSolicitud) {
	    TipoSolicitud::create($tipoSolicitud);
        }
    }
}
