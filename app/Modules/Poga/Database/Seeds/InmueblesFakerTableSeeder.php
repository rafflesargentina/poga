<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\{ Direccion, Inmueble, InmueblePadre, InmueblePersona, Unidad, User };

use Illuminate\Database\Seeder;

class InmueblesFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_edificioConUnidadesSinAdministrador();
        $this->_edificioConUnidadesAdministradoPorMario();
        $this->_edificioConUnidadesAdministradoPorJosue();
        $this->_casaSinAdministrador();
        $this->_duplexSinAdministrador();
        $this->_triplexSinAdministrador();

    }

    

    private function _edificioConUnidadesSinAdministrador()
    {
        /* Mario */
        $user = User::find(1);

        $direccion = Direccion::create(['calle_principal' => 'Libertad', 'calle_secundaria' => 'Concordia', 'numeracion' => '1000', 'latitud' => '-25.2931888426435', 'longitud' => '-57.6444401299804']);
        $inmueble = $user->inmuebles()->create(['id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'INMUEBLES_PADRE']);
        $inmueblePadre = InmueblePadre::create(['divisible_en_unidades' => '1', 'id_inmueble' => $inmueble->id, 'nombre' => 'Edificio con Unidades sin Administrador', 'id_direccion' => $direccion->id, 'cant_pisos' => '3', 'modalidad_propiedad' => 'EN_CONDOMINIO', 'comision_administrador' => '5']);
        $inmueble->idInmueblePadre()->associate($inmueblePadre->id);
        $inmueble->save();

        $inmueble->formatos()->attach(['1','2']);

        $unidades = [
            ['piso' => '1', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '1', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '6', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '1', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '7', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '8', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '6', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '7', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '8', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
        ];

        foreach ($unidades as $unidad) {
            $u = Unidad::create($unidad);
            $u->idInmueble->id_tabla_hija = $u->id;
            $u->idInmueble->save();
        }
    }

    private function _edificioConUnidadesAdministradoPorMario()
    {
        /* Mario */
	$user = User::find(1);

        $direccion = Direccion::create(['calle_principal' => 'Artigas', 'calle_secundaria' => 'Choferes', 'numeracion' => '611', 'latitud' => '-25.2916367849582', 'longitud' => '-57.6425518548339']);
        $inmueble = $user->inmuebles()->create(['id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'INMUEBLES_PADRE']);
        $inmueblePadre = InmueblePadre::create(['divisible_en_unidades' => '1', 'id_inmueble' => $inmueble->id, 'nombre' => 'Edificio con Unidades Administrado por Mario', 'id_direccion' => $direccion->id, 'cant_pisos' => '3', 'modalidad_propiedad' => 'EN_CONDOMINIO', 'comision_administrador' => '5']);
        $inmueble->idInmueblePadre()->associate($inmueblePadre->id);
        $inmueble->save();

	$inmueble->personas()->attach($user, ['referente' => true, 'enum_estado' => 'ACTIVO', 'enum_rol' => 'ADMINISTRADOR']);

	/* Lorena */
	$user = User::find(3);
	$inmueble->personas()->attach($user, ['referente' => true, 'enum_estado' => 'ACTIVO', 'enum_rol' => 'PROPIETARIO']);


        /* Pol */
        $user = User::find(4);
        $inmueble->personas()->attach($user, ['referente' => true, 'enum_estado' => 'ACTIVO', 'enum_rol' => 'INQUILINO']);

        $unidades = [
            ['piso' => '1', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '1', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '6', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '1', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '7', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '8', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '6', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '7', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '8', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
        ];

        foreach ($unidades as $unidad) {
            $u = Unidad::create($unidad);
            $u->idInmueble->id_tabla_hija = $u->id;
	    $u->idInmueble->save();

	    InmueblePersona::create(['id_inmueble' => $u->id_inmueble, 'id_persona' => '1', 'enum_rol' => 'ADMINISTRADOR', 'referente' => '1']);
	    InmueblePersona::create(['id_inmueble' => $u->id_inmueble, 'id_persona' => '2', 'enum_rol' => 'PROPIETARIO', 'referente' => '1']);
            //$u->idInmueble->personas()->attach(['id_persona' => '1', 'enum_rol' => 'ADMINISTRADOR', 'referente' => '1']);
            //$u->idInmueble->personas()->attach(['id_persona' => '2', 'enum_rol' => 'PROPIETARIO', 'referente' => '1']);
        }
    }

    private function _edificioConUnidadesAdministradoPorJosue()
    {
        /* Mario */
        $user = User::find(2);

        $direccion = Direccion::create(['calle_principal' => 'Santisima Trinidad', 'calle_secundaria' => 'Julio Correa', 'numeracion' => '2111', 'latitud' => '25.2876789479427', 'longitud' => '-57.653194860205']);
        $inmueble = $user->inmuebles()->create(['id_tipo_inmueble' => '1', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'INMUEBLES_PADRE']);
        $inmueblePadre = InmueblePadre::create(['divisible_en_unidades' => '1', 'id_inmueble' => $inmueble->id, 'nombre' => 'Edificio con Unidades Administrado por Josue', 'id_direccion' => $direccion->id, 'cant_pisos' => '3', 'modalidad_propiedad' => 'EN_CONDOMINIO', 'comision_administrador' => '5']);
        $inmueble->idInmueblePadre()->associate($inmueblePadre->id);
        $inmueble->save();

        $inmueble->personas()->attach($user, ['referente' => true, 'enum_estado' => 'ACTIVO', 'enum_rol' => 'ADMINISTRADOR']);

        $inmueble->formatos()->attach(['1','2']);

        $unidades = [
            ['piso' => '1', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '1', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '6', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '1', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '7', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '8', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '2', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '6', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '101', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '7', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '102', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '8', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
            ['piso' => '3', 'numero' => '103', 'id_inmueble_padre' => $inmueblePadre->id, 'id_inmueble' => Inmueble::create(['id_tipo_inmueble' => '5', 'solicitud_directa_inquilinos' => 'true', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'UNIDADES', 'id_usuario_creador' => $user->id])->id, 'id_medida' => '1', 'area' => '50', 'id_formato_inmueble' => '1', 'area_estacionamiento' => '15'],
        ];

        foreach ($unidades as $unidad) {
            $u = Unidad::create($unidad);
	    $u->idInmueble->id_tabla_hija = $u->id;
	    $u->idInmueble->save();

            InmueblePersona::create(['id_inmueble' => $u->id_inmueble, 'id_persona' => '2', 'enum_rol' => 'ADMINISTRADOR', 'referente' => '1']);
            InmueblePersona::create(['id_inmueble' => $u->id_inmueble, 'id_persona' => '1', 'enum_rol' => 'PROPIETARIO', 'referente' => '1']);
        }
    }

    private function _CasaSinAdministrador()
    {
        /* Mario */
        $user = User::find(1);

        $direccion = Direccion::create(['calle_principal' => 'Jose Marti', 'calle_secundaria' => 'Cruz del Chaco', 'numeracion' => '5250', 'latitud' => '-25.3085326329494', 'longitud' => '-57.587102651596']);
        $inmueble = $user->inmuebles()->create(['id_tipo_inmueble' => '2', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'INMUEBLES_PADRE']);
        $inmueblePadre = InmueblePadre::create(['id_inmueble' => $inmueble->id, 'nombre' => 'Casa sin Administrador', 'id_direccion' => $direccion->id, 'cant_pisos' => '3', 'modalidad_propiedad' => 'EN_CONDOMINIO', 'comision_administrador' => '5']);
        $inmueble->idInmueblePadre()->associate($inmueblePadre->id);
        $inmueble->save();

        $inmueble->formatos()->attach(['1']);
    }

    private function _duplexSinAdministrador()
    {
        /* Josue  */
        $user = User::find(2);

        $direccion = Direccion::create(['calle_principal' => 'Avda. Artigas', 'calle_secundaria' => 'Lombardo', 'numeracion' => '200', 'latitud' => '-25.2889389267439', 'longitud' => '57.6620864868164']);
        $inmueble = $user->inmuebles()->create(['id_tipo_inmueble' => '3', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'INMUEBLES_PADRE']);
        $inmueblePadre = InmueblePadre::create(['id_inmueble' => $inmueble->id, 'nombre' => 'Duplex sin Administrador', 'id_direccion' => $direccion->id, 'cant_pisos' => '3', 'modalidad_propiedad' => 'EN_CONDOMINIO', 'comision_administrador' => '5']);
        $inmueble->idInmueblePadre()->associate($inmueblePadre->id);
        $inmueble->save();

        $inmueble->formatos()->attach(['1']);
    }

    private function _triplexSinAdministrador()
    {
        /* Josue  */
        $user = User::find(2);

        $direccion = Direccion::create(['calle_principal' => 'Mariscal Lopez', 'calle_secundaria' => 'Republica Argentina', 'numeracion' => '200', 'latitud' => '-25.2889389267439', 'longitud' => '-57.6620864868164']);
        $inmueble = $user->inmuebles()->create(['id_tipo_inmueble' => '4', 'enum_estado' => 'ACTIVO', 'enum_tabla_hija' => 'INMUEBLES_PADRE']);
        $inmueblePadre = InmueblePadre::create(['id_inmueble' => $inmueble->id, 'nombre' => 'Triplex sin Administrador', 'id_direccion' => $direccion->id, 'cant_pisos' => '3', 'modalidad_propiedad' => 'EN_CONDOMINIO', 'comision_administrador' => '5']);
        $inmueble->idInmueblePadre()->associate($inmueblePadre->id);
        $inmueble->save();

        $inmueble->formatos()->attach(['1']);
    }
}
