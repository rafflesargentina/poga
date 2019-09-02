<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/
Route::get('proveedores', ProveedorController::class);
Route::get('dashboard', DashboardController::class);
Route::get('inmuebles/personaReferenteDadoRol', Inmuebles\PersonaReferenteDadoRolController::class);
//Route::get('inmuebles/monedas', MonedaController::class);
Route::get('inmuebles/tiposUnidades', Inmuebles\TipoUnidadController::class);
Route::get('reservas/espaciosComunes', Reservas\EspacioComunController::class);
Route::get('finanzas/posiblesAcreedores', Finanzas\PosibleAcreedorController::class);
Route::get('finanzas/posiblesDeudores', Finanzas\PosibleDeudorController::class);
Route::get('finanzas/tiposPagares', Finanzas\TipoPagareController::class);
Route::get('proveedores', ProveedorController::class);

Route::get('solicitudes/confirmarPago', Solicitudes\ConfirmarPagoController::class);
Route::get('solicitudes/rechazarPago', Solicitudes\RechazarPagoController::class);
Route::get('solicitudes/crearPago', Solicitudes\CrearPagoController::class);

Route::get('mantenimientos/confirmarPago', Mantenimientos\ConfirmarPagoController::class);
Route::get('mantenimientos/rechazarPago', Mantenimientos\RechazarPagoController::class);
Route::get('mantenimientos/crearPago', Mantenimientos\CrearPagoController::class);

Route::post('login', 'Auth\LoginController@login');
Route::post('seleccionar-rol', Roles\SeleccionarRolController::class);

Route::put('inmuebles/desvincular', Inmuebles\DesvincularController::class);

Route::apiResource('ciudades-cobertura', CiudadCoberturaController::class);
Route::apiResource('inmuebles', Inmuebles\InmuebleController::class);
Route::apiResource('mantenimientos', Mantenimientos\MantenimientoController::class);
Route::apiResource('nacionalidades', NacionalidadController::class);
Route::apiResource('nominaciones', Nominaciones\NominacionController::class);
Route::apiResource('paises-cobertura', PaisCoberturaController::class);
Route::apiResource('reservas', Reservas\ReservaController::class);
Route::apiResource('rentas', Finanzas\RentaController::class);
Route::apiResource('tipos-caracteristica', Inmuebles\TipoCaracteristicaController::class);
Route::apiResource('visitas', Visitas\VisitaController::class);
Route::apiResource('rentas', RentaController::class);

/**
 * Revisados
 */
Route::apiResource('formatos', FormatoController::class);
Route::apiResource('medidas', Inmuebles\MedidaController::class, ['only' => 'index']);
Route::apiResource('personas', PersonaController::class);
Route::apiResource('tipos-inmueble', TipoInmuebleController::class);
Route::apiResource('roles', Roles\RolController::class);
Route::apiResource('solicitudes/proveedor', Solicitudes\ProveedorController::class);
Route::apiResource('unidades', Inmuebles\UnidadController::class);
