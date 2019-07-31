<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\Caracteristica;

use Illuminate\Database\Seeder;

class CaracteristicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $caracteristicas = [
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Lobby', 'descripcion' => 'Lobby', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Sala de Entretenimiento', 'descripcion' => 'Sala de Entretenimiento', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Portero Eléctrico', 'descripcion' => 'Portero Eléctrico', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Quincho', 'descripcion' => 'Quincho', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Piscina', 'descripcion' => 'Piscina', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Jardín', 'descripcion' => 'Jardín', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Patio', 'descripcion' => 'Patio', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Parque Infantil', 'descripcion' => 'Parque Infantil', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Fútbol', 'descripcion' => 'Cancha de Fútbol', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Basquetball', 'descripcion' => 'Cancha de Basquetball', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Tenis', 'descripcion' => 'Cancha de Tenis', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Paddle', 'descripcion' => 'Cancha de Paddle', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Gimnasio', 'descripcion' => 'Gimnasio', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Terraza', 'descripcion' => 'Terraza', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Ascensor', 'descripcion' => 'Ascensor', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '3', 'nombre' => 'Guardia', 'descripcion' => 'Guardia', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '3', 'nombre' => 'Portero', 'descripcion' => 'Portero', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '3', 'nombre' => 'Conserje', 'descripcion' => 'Conserje', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Videovigilancia', 'descripcion' => 'Videovigilancia', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Detector de humo', 'descripcion' => 'Detector de humo', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Detector de CO', 'descripcion' => 'Detector de CO', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Botiquín', 'descripcion' => 'Botiquín', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Ficha instrucciones de seguridad', 'descripcion' => 'Ficha instrucciones de seguridad', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Extintor de incendios', 'descripcion' => 'Extintor de incendios', 'enum_estado' => 'ACTIVO'],
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Manguera para incendios', 'descripcion' => 'Manguera para incendios', 'enum_estado' => 'ACTIVO'],
        ];

        foreach ($caracteristicas as $caracteristica) Caracteristica::create($caracteristica);
    }
}
