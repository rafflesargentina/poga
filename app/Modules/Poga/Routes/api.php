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

// Auth
Route::get('usuario-invitado/{codigo_validacion}', 'Auth\UsuarioInvitadoController');
Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\RegisterController@register');
Route::post('seleccionar-rol', Auth\SeleccionarRolController::class);
Route::put('registro-invitado/{codigo_validacion}', 'Auth\GuestRegisterController@register');
Route::apiResource('ciudades-cobertura', Auth\CiudadCoberturaController::class, ['only' => ['index']]);
Route::apiResource('paises-cobertura', Auth\PaisCoberturaController::class, ['only' => ['index']]);
Route::apiResource('roles', Auth\RolController::class, ['only' => ['index']]);

// Dashboard
Route::get('dashboard', DashboardController::class);

// Espacios
Route::apiResource('espacios', EspacioController::class);

// Eventos
Route::apiResource('reservas', Eventos\ReservaController::class);
Route::apiResource('visitas', Eventos\VisitaController::class);

// Finanzas
Route::post('finanzas/crearPago', Finanzas\CrearPagoController::class);
Route::put('finanzas/actualizarEstadoPagare', Finanzas\ActualizarEstadoPagareController::class);
Route::put('finanzas/cargarFondoReserva', Finanzas\CargarFondoReservaController::class);
Route::put('finanzas/confirmarPago', Finanzas\ConfirmarPagoController::class);
Route::put('finanzas/rechazarPago', Finanzas\RechazarPagoController::class);
Route::put('finanzas/distribuirExpensas', Finanzas\DistribuirExpensasController::class);
Route::apiResource('monedas', Finanzas\MonedaController::class, ['only' => ['index']]);
Route::apiResource('pagares', Finanzas\PagareController::class);

// Inmuebles
Route::put('inmuebles/desvincular', Inmuebles\DesvincularController::class);
Route::apiResource('formatos', Inmuebles\FormatoController::class, ['only' => ['index']]);
Route::apiResource('inmuebles', Inmuebles\InmuebleController::class);
Route::apiResource('medidas', Inmuebles\MedidaController::class, ['only' => ['index']]);
Route::apiResource('inmueble-personas', Inmuebles\PersonaController::class);
Route::apiResource('tipos-caracteristica', Inmuebles\TipoCaracteristicaController::class);
Route::apiResource('tipos-inmueble', Inmuebles\TipoInmuebleController::class, ['only' => ['index']]);
Route::apiResource('unidades', Inmuebles\UnidadController::class);

// Mantenimientos
Route::post('mantenimientos/crearPago', Mantenimientos\CrearPagoController::class);
Route::put('mantenimientos/confirmarPago', Mantenimientos\ConfirmarPagoController::class);
Route::put('mantenimientos/rechazarPago', Mantenimientos\RechazarPagoController::class);
Route::apiResource('mantenimientos', Mantenimientos\MantenimientoController::class);

// Nominaciones
//Route::put('nominaciones/{id}/aceptar', Nominaciones\AceptarController::class);
//Route::put('nominaciones/{id}/rechazar', Nominaciones\RechazarController::class);
Route::apiResource('nominaciones', Nominaciones\NominacionController::class);

// Paises
Route::apiResource('paises', PaisController::class, ['only' => ['index']]);

// Personas
Route::apiResource('personas', PersonaController::class, ['only' => ['index']]);

// Proveedores
Route::apiResource('proveedores', ProveedorController::class);

// Rentas
Route::put('rentas/{id}/finalizarContrato', Rentas\FinalizarContratoController::class);
Route::apiResource('rentas', Rentas\RentaController::class);

// Solicitudes
Route::post('solicitudes/crearPago', Solicitudes\CrearPagoController::class);
Route::put('solicitudes/confirmarPago', Solicitudes\ConfirmarPagoController::class);
Route::put('solicitudes/rechazarPago', Solicitudes\RechazarPagoController::class);
