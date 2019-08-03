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
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Lobby', 'descripcion' => 'Lobby', 'enum_estado' => 'ACTIVO'], // 1
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Sala de Entretenimiento', 'descripcion' => 'Sala de Entretenimiento', 'enum_estado' => 'ACTIVO'], // 2
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Portero Eléctrico', 'descripcion' => 'Portero Eléctrico', 'enum_estado' => 'ACTIVO'], // 3
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Quincho', 'descripcion' => 'Quincho', 'enum_estado' => 'ACTIVO'], // 4
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Piscina', 'descripcion' => 'Piscina', 'enum_estado' => 'ACTIVO'], // 5
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Jardín', 'descripcion' => 'Jardín', 'enum_estado' => 'ACTIVO'], // 6
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Patio', 'descripcion' => 'Patio', 'enum_estado' => 'ACTIVO'], // 7
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Parque Infantil', 'descripcion' => 'Parque Infantil', 'enum_estado' => 'ACTIVO'], // 8
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Fútbol', 'descripcion' => 'Cancha de Fútbol', 'enum_estado' => 'ACTIVO'], // 9
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Basquetball', 'descripcion' => 'Cancha de Basquetball', 'enum_estado' => 'ACTIVO'], // 10
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Tenis', 'descripcion' => 'Cancha de Tenis', 'enum_estado' => 'ACTIVO'], // 11
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cancha de Paddle', 'descripcion' => 'Cancha de Paddle', 'enum_estado' => 'ACTIVO'], // 12
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Gimnasio', 'descripcion' => 'Gimnasio', 'enum_estado' => 'ACTIVO'], // 13
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Terraza', 'descripcion' => 'Terraza', 'enum_estado' => 'ACTIVO'], // 14
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Ascensor', 'descripcion' => 'Ascensor', 'enum_estado' => 'ACTIVO'], // 15
            ['id_tipo_caracteristica' => '3', 'nombre' => 'Guardia', 'descripcion' => 'Guardia', 'enum_estado' => 'ACTIVO'], // 16
            ['id_tipo_caracteristica' => '3', 'nombre' => 'Portero', 'descripcion' => 'Portero', 'enum_estado' => 'ACTIVO'], // 17
            ['id_tipo_caracteristica' => '3', 'nombre' => 'Conserje', 'descripcion' => 'Conserje', 'enum_estado' => 'ACTIVO'], // 18
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Videovigilancia', 'descripcion' => 'Videovigilancia', 'enum_estado' => 'ACTIVO'], // 19
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Detector de humo', 'descripcion' => 'Detector de humo', 'enum_estado' => 'ACTIVO'], // 20
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Detector de CO', 'descripcion' => 'Detector de CO', 'enum_estado' => 'ACTIVO'], // 21
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Botiquín', 'descripcion' => 'Botiquín', 'enum_estado' => 'ACTIVO'], // 22
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Ficha instrucciones de seguridad', 'descripcion' => 'Ficha instrucciones de seguridad', 'enum_estado' => 'ACTIVO'], //23
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Extintor de incendios', 'descripcion' => 'Extintor de incendios', 'enum_estado' => 'ACTIVO'], // 24
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Manguera para incendios', 'descripcion' => 'Manguera para incendios', 'enum_estado' => 'ACTIVO'], // 25
            ['id_tipo_caracteristica' => '5', 'nombre' => 'Prohibido Fumar', 'descripcion' => 'Prohibido Fumar', 'enum_estado' => 'ACTIVO'], // 26
            ['id_tipo_caracteristica' => '5', 'nombre' => 'No se admiten mascotas', 'descripcion' => 'No se admiten mascotas', 'enum_estado' => 'ACTIVO'], // 27
            ['id_tipo_caracteristica' => '5', 'nombre' => 'No se admiten fiestas o eventos', 'descripcion' => 'No se admiten fiestas o eventos', 'enum_estado' => 'ACTIVO'], // 28
            ['id_tipo_caracteristica' => '5', 'nombre' => 'No adecuado para bebés', 'descripcion' => 'No adecuado para bebés', 'enum_estado' => 'ACTIVO'], // 29
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Biblioteca', 'descripcion' => 'Biblioteca', 'enum_estado' => 'ACTIVO'], // 30
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Acceso para discapacitados', 'descripcion' => 'Acceso para discapacitados', 'enum_estado' => 'ACTIVO'], // 31
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Garage', 'descripcion' => 'Garage', 'enum_estado' => 'ACTIVO'], // 32
            ['id_tipo_caracteristica' => '4', 'nombre' => 'Alarma antirrobo', 'descripcion' => 'Alarma antirrobo', 'enum_estado' => 'ACTIVO'], // 33
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Juego de living', 'descripcion' => 'Juevo de living', 'enum_estado' => 'ACTIVO'], // 34
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Mesa comedor y sillas', 'descripcion' => 'Mesa comedor y sillas', 'enum_estado' => 'ACTIVO'], // 35
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cocina amoblada', 'descripcion' => 'Cocina amoblada', 'enum_estado' => 'ACTIVO'], // 36
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cocina', 'descripcion' => 'Cocina','enum_estado' => 'ACTIVO'], // 37
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Lavarropas', 'descripcion' => 'Lavarropas','enum_estado' => 'ACTIVO'], // 37
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Lavaplatos', 'descripcion' => 'Lavaplatos','enum_estado' => 'ACTIVO'], // 38
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Heladera', 'descripcion' => 'Heladera','enum_estado' => 'ACTIVO'], // 39
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Microondas', 'descripcion' => 'Microondas','enum_estado' => 'ACTIVO'], // 40
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cafetera', 'descripcion' => 'Cafetera','enum_estado' => 'ACTIVO'], // 41
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Internet', 'descripcion' => 'Internet','enum_estado' => 'ACTIVO'], // 42
            ['id_tipo_caracteristica' => '2', 'nombre' => 'TV por cable', 'descripcion' => 'TV por cable','enum_estado' => 'ACTIVO'], // 43
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Aire acondicionado', 'descripcion' => 'Aire acodicionado','enum_estado' => 'ACTIVO'], // 44
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Estudio', 'descripcion' => 'Estudio','enum_estado' => 'ACTIVO'], // 45
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Área de servicio', 'descripcion' => 'Área de servicio','enum_estado' => 'ACTIVO'], // 46
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Jacuzzi', 'descripcion' => 'Jacuzzi','enum_estado' => 'ACTIVO'], // 47
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Balcón', 'descripcion' => 'Balcón','enum_estado' => 'ACTIVO'], // 48
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Luminarias', 'descripcion' => 'Luminarias','enum_estado' => 'ACTIVO'], // 49
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cielo raso', 'descripcion' => 'Cielo raso','enum_estado' => 'ACTIVO'], // 50
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Cama', 'descripcion' => 'Cama','enum_estado' => 'ACTIVO'], // 51
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Estacionamiento propio', 'descripcion' => 'Estacionamiento propio','enum_estado' => 'ACTIVO'], // 52
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Habitaciones', 'descripcion' => 'Habitaciones','enum_estado' => 'ACTIVO'], // 53
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Parrilla', 'descripcion' => 'Parrilla','enum_estado' => 'ACTIVO'], // 54
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Estacionamiento', 'descripcion' => 'Estacionamiento','enum_estado' => 'ACTIVO'], // 55
            ['id_tipo_caracteristica' => '2', 'nombre' => 'WIFI', 'descripcion' => 'WIFI','enum_estado' => 'ACTIVO'], // 56
            ['id_tipo_caracteristica' => '2', 'nombre' => 'Sala de reunión', 'descripcion' => 'Sala de reunión', 'enum_estado' => 'ACTIVO'], // 57
        ];

        foreach ($caracteristicas as $caracteristica) Caracteristica::create($caracteristica);
    }
}
