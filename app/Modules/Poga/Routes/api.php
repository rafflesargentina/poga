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
Route::get('finanzas/tiposPagares', Finanzas\TipoPagareController::class);

//Route::put('finanzas/actualizarEstadoPagare', Finanzas\ActualizarEstadoPagareController::class);
Route::put('finanzas/cambiarEstadoPagare', Finanzas\CambiarEstadoPagareController::class);
Route::put('finanzas/cargarFondoReserva', Finanzas\CargarFondoReservaController::class);
Route::put('finanzas/confirmarPagoFinanzas', Finanzas\ConfirmarPagoController::class);
//Route::post('finanzas/crearPago', Finanzas\CrearPagoController::class);

Route::apiResource('monedas', Finanzas\MonedaController::class, ['only' => ['index']]);
Route::apiResource('rentas', Finanzas\RentaController::class);

// Inmuebles
Route::put('inmuebles/desvincular', Inmuebles\DesvincularController::class);

Route::apiResource('formatos', Inmuebles\FormatoController::class, ['only' => ['index']]);
Route::apiResource('inmuebles', Inmuebles\InmuebleController::class);
Route::apiResource('medidas', Inmuebles\MedidaController::class, ['only' => ['index']]);
Route::apiResource('inmueble-personas', Inmuebles\PersonaController::class);
Route::apiResource('tipos-caracteristica', Inmuebles\TipoCaracteristicaController::class);
Route::apiResource('tipos-inmueble', Inmuebles\TipoInmuebleController::class);
Route::apiResource('unidades', Inmuebles\UnidadController::class);

// Mantenimientos
Route::apiResource('mantenimientos', Mantenimientos\MantenimientoController::class);

// Nominaciones
Route::apiResource('nominaciones', Nominaciones\NominacionController::class);

// Paises
Route::apiResource('paises', PaisController::class, ['only' => ['index']]);

// Personas
Route::apiResource('personas', PersonaController::class);

// Proveedores
Route::apiResource('proveedores', ProveedorController::class);
