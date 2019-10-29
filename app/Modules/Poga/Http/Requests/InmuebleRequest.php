<?php

namespace Raffles\Modules\Poga\Http\Requests;

use Raffles\Modules\Poga\Repositories\InmueblePadreRepository;

use Illuminate\Validation\Rule;
use RafflesArgentina\ActionBasedFormRequest\ActionBasedFormRequest as FormRequest;

class InmuebleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the update action.
     *
     * @return array
     */
    public static function update()
    {
        $repository = new InmueblePadreRepository;

        $model = $repository->findOrFail(request()->route('inmueble'));
        $data = request()->all();	
	$user = request()->user('api');

        // Los siguientes campos no se deben modificar una vez creado el inmueble.
	if (array_key_exists('idInmueblePadre', $data)) {
	    array_key_exists('divisible_en_unidades', $data['idInmueblePadre'])
	        ?: $data['idInmueblePadre']['divisible_en_unidades'] = $model->divisible_en_unidades;

	    array_key_exists('id_tipo_inmueble', $data['idInmueblePadre'])
	        ?: $data['idInmueblePadre']['id_tipo_inmueble'] = $model->id_tipo_inmueble;

	    array_key_exists('modalidad_propiedad', $data['idInmueblePadre'])
	        ?: $data['idInmueblePadre']['modalidad_propiedad'] = $model->modalidad_propiedad;
	}

	array_key_exists('idAdministradorReferente', $data)
            ?: $data['idAdministradorReferente'] = ($model->idAdministradorReferente ? $model->idAdministradorReferente->id : null);
	
	array_key_exists('idPropietarioReferente', $data)
	    ?: $data['idPropietarioReferente'] = ($model->idPropietarioReferente ? $model->idPropietarioReferente->id : null);

	if (request()->featured_photo) {
            return [
                'featured_photo[]' => 'image',
	    ];
	}

        if (request()->unfeatured_photos) {
            return [
                'unfeatured_photos[]' => 'image',
            ];
        }

        return [
            'caracteristicas' => 'array',
            'dia_cobro_mensual' => Rule::requiredIf(
                function () use ($model, $user) {
                    // Requerido cuando la modalidad del inmueble es EN_CONDOMINIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $model->modalidad_propiedad === 'EN_CONDOMINIO'
                    && ($model->idAdministradorReferente ? $model->idAdministradorReferente->id === $user->id_persona : false);
                }
            ),
            'formatos' => 'required|array|min:1',
            'idDireccion.calle_principal' => 'required',
            'idDireccion.numeracion' => 'required',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idInmueblePadre.cant_pisos' => 'required|numeric',
            'idInmueblePadre.comision_administrador' => Rule::requiredIf(
                function () use ($model) {
                    // Requerido cuando la modalidad del inmueble es UNICO_PROPIETARIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $model->modalidad_propiedad === 'UNICO_PROPIETARIO'
                    && ($model->idAdministradorReferente ? $model->idAdministradorReferente->id === $user->id_persona : false);
                }
            ),
            'idInmueblePadre.nombre' => 'required',
            'salario' => Rule::requiredIf(
               function () use ($model, $user) {
                    // Requerido cuando la modalidad del inmueble es EN_CONDOMINIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $model->modalidad_propiedad === 'EN_CONDOMINIO'
                    && ($model->idAdministradorReferente ? $model->idAdministradorReferente->id === $user->id_persona : false);
                }
            )
        ];
    }
}
