<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\TipoCaracteristica;

use Illuminate\Database\Seeder;

class CaracteristicaTipoInmuebleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->comodidades();
        $this->personal();
        $this->funcionesDeSeguridad();
        $this->normasDelInmueble();
    }

    protected function comodidades()
    {
        $tipoCaracteristica = TipoCaracteristica::find(2);

        $caracteristicas = [
            // Edificio
            ['id_caracteristica' => '1', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '2', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '3', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '4', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '5', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '6', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '7', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '8', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '9', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '10', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '11', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '12', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '13', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '14', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '15', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],

            ['id_caracteristica' => '30', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '31', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Casa
            ['id_caracteristica' => '2', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '3', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '4', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '5', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '6', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '7', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '31', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '32', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '34', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '35', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '36', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '37', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '38', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '39', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '40', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '41', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '42', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '43', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '44', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '45', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '46', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '47', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '48', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '49', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '50', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '51', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '52', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '53', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '54', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '55', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Dúplex
            ['id_caracteristica' => '2', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '3', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '4', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '5', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '6', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '7', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '31', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '32', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '34', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '35', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '36', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '37', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '38', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '39', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '40', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '41', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '42', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '43', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '44', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '45', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '46', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '47', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '48', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '49', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '50', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '51', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '52', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '53', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '54', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '55', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Triplex
            ['id_caracteristica' => '2', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '3', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '4', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '5', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '6', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '7', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '31', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '32', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '34', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '35', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '36', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '37', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '38', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '39', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '40', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '41', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '42', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '43', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '44', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '45', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '46', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '47', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '48', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '49', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '50', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '51', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '52', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '53', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '54', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '55', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Departamento
            ['id_caracteristica' => '34', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '35', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '36', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '37', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '38', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '39', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '40', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '41', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '42', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '43', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '44', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '45', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '46', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '47', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '48', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '49', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '50', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '51', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '52', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '53', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '54', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '55', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Flat
            ['id_caracteristica' => '34', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '35', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '36', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '37', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '38', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '39', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '40', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '41', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '42', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '43', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '44', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '45', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '46', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '47', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '48', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '49', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '50', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '51', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '52', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '53', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '54', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '55', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Penthouse
            ['id_caracteristica' => '34', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '35', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '36', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '37', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '38', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '39', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '40', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '41', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '42', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '43', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '44', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '45', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '46', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '47', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '48', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '49', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '50', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '51', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '52', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '53', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '54', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '55', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Loft
            ['id_caracteristica' => '34', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '35', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '36', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '37', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '38', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '39', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '40', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '41', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '42', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '43', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '44', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '45', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '46', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '47', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '48', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '49', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '50', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '51', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '52', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '53', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '54', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'number'],
            ['id_caracteristica' => '55', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '56', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '57', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '58', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
        ];

        foreach ($caracteristicas as $caracteristica) {
            $tipoCaracteristica->tipos_inmueble()->attach($caracteristica['id_tipo_inmueble'], array_except($caracteristica, 'id_tipo_inmueble'));
        }
    }

    protected function personal()
    {
        $tipoCaracteristica = TipoCaracteristica::find(3);

        $caracteristicas = [
            // Edificio
            ['id_caracteristica' => '16', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '17', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '18', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Casa
            ['id_caracteristica' => '16', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Dúplex
            ['id_caracteristica' => '16', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Triplex
            ['id_caracteristica' => '16', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Departamento, Flat, Penthouse y Loft no llevan personal, ya que dependen del edificio.
        ];

        foreach ($caracteristicas as $caracteristica) {
            $tipoCaracteristica->tipos_inmueble()->attach($caracteristica['id_tipo_inmueble'], array_except($caracteristica, 'id_tipo_inmueble'));
        }
    }

    protected function funcionesDeSeguridad()
    {
        $tipoCaracteristica = TipoCaracteristica::find(4);

        $caracteristicas = [
            // Edificio
            ['id_caracteristica' => '19', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '25', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Casa
            ['id_caracteristica' => '19', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '25', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Dúplex
            ['id_caracteristica' => '19', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '25', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Triplex
            ['id_caracteristica' => '19', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '25', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Departamento
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Flat
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Penthouse
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Loft
            ['id_caracteristica' => '20', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '21', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '24', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '33', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
        ];

        foreach ($caracteristicas as $caracteristica) {
            $tipoCaracteristica->tipos_inmueble()->attach($caracteristica['id_tipo_inmueble'], array_except($caracteristica, 'id_tipo_inmueble'));
        }
    }

    protected function normasDelInmueble()
    {
        $tipoCaracteristica = TipoCaracteristica::find(5);

        $caracteristicas = [
            // Edificio
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Casa
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Dúplex
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Triplex
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Departamento
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '5', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Flat
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '6', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Penthouse
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '7', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],

            // Loft
            ['id_caracteristica' => '26', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '27', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '28', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
            ['id_caracteristica' => '29', 'id_tipo_inmueble' => '8', 'enum_estado' => 'ACTIVO', 'enum_tipo_campo' => 'boolean'],
        ];

        foreach ($caracteristicas as $caracteristica) {
            $tipoCaracteristica->tipos_inmueble()->attach($caracteristica['id_tipo_inmueble'], array_except($caracteristica, 'id_tipo_inmueble'));
        }
    }
}
