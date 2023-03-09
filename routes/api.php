<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function ($router) {
	Route::post('forgot-password', 'Auth\AuthController@ForgotPassword');
	Route::post('validate-token', 'Auth\AuthController@ValidateTokenReset');
	Route::post('password-reset', 'Auth\AuthController@SetPasswordReset');
	Route::post('set-password-reset', 'Auth\AuthController@SetPasswordReset');
});
Route::group([
	'middleware' => 'api',
	'prefix'     => 'auth',
], function ($router) {
	Route::post('login', 'Auth\AuthController@login');
	Route::post('logout', 'Auth\AuthController@logout');
	Route::post('refresh', 'Auth\AuthController@refresh');
	Route::post('me', 'Auth\AuthController@userProfile');
});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
	Route::apiResource('usuarios', UsuarioController::class)->middleware(['role:Administrador']);
	Route::apiResource('personas', PersonaController::class)->middleware(['role:Administrador']);
	Route::apiResource('permisos', PermisoController::class)->middleware(['role:Administrador']);
	Route::apiResource('roles', RolController::class)->middleware(['role:Administrador']);
	Route::apiResource('servicios', ServicioController::class)->middleware(['role:Administrador']);
	Route::apiResource('responsables', ResponsableController::class)->middleware(['role:Administrador']);
	Route::apiResource('categorias', CategoriaController::class)->middleware(['role:Administrador']);
	Route::apiResource('orgfinanciero', OrgfinancieroController::class)->middleware(['role:Administrador']);
	Route::apiResource('asignaciones', AsignacionController::class)->middleware(['role:Administrador']);
	Route::apiResource('detalle-asignacion', DetalleAsignacionController::class)->middleware(['role:Administrador']);
	Route::apiResource('transferencias', TransferenciaController::class)->middleware(['role:Administrador']);
	Route::apiResource('detalle-transferencias', DetalleTransferenciaController::class)->middleware(['role:Administrador']);
	Route::apiResource('articulos', ArticuloController::class)->middleware(['role:Administrador']);
	Route::apiResource('archivos', ArchivoController::class)->middleware(['role:Administrador']);
	Route::apiResource('funcionarios', FuncionarioController::class)->middleware(['role:Administrador']);
	Route::apiResource('bajas', BajaController::class)->middleware(['role:Administrador']);
	Route::apiResource('detalle-bajas', DetalleBajaController::class)->middleware(['role:Administrador']);
	Route::post('set-theme', 'UsuarioController@SetTheme');
	#Personas
	Route::post('verificar-ci', 'PersonaController@VerificarCi');
	#Usuarios
	Route::post('change-password', 'UsuarioController@ChangePassword');
	Route::post('change-user-picture', 'UsuarioController@ChangeUserPicture');
	Route::delete('delete-image-user/{id}', 'UsuarioController@DeleteImageUser');
	Route::post('verificar-correo', 'UsuarioController@VerificarCorreo');
	Route::post('activate-account', 'UsuarioController@ActivateAccount');
	Route::post('suspend-account', 'UsuarioController@SuspendAccount');
	Route::get('info-usuarios', 'UsuarioController@InfoUsuarios');
	#Asignaciones
	Route::get('responsables-options', 'ResponsableController@ResponsablesOptions');
	Route::get('asignaciones-responsables', 'AsignacionController@AsignacionesResponsables');
	Route::get('asignaciones-responsable/{idResponsable}', 'AsignacionController@AsignacionesResponsable');
	Route::get('reporte-asignacion/{idAsignacion}', 'AsignacionController@AsignacionReporte');
	Route::get('historial-asignaciones/{idResponsable}', 'AsignacionController@HistorialAsignaciones');
	Route::get('info-asignaciones', 'AsignacionController@InfoAsignaciones');
	#Articulos
	Route::get('articulos-options', 'ArticuloController@articulosOptions');
	Route::post('reporte-articulos', 'ArticuloController@ArticulosReporte');
	Route::get('info-articulos', 'ArticuloController@InfoArticulos');
	#Responsable
	Route::get('responsable-baja/{id}', 'ResponsableController@bajaResponsable');
	Route::get('responsable-usuarios', 'ResponsableController@Usuarios');
	Route::get('responsable-servicios', 'ResponsableController@Servicios');
	Route::post('cambiar-servicios', 'ResponsableController@CambiarServicios');
	Route::get('info-responsables', 'ResponsableController@InfoResponsables');
	#Funcionarios
	Route::post('status-funcionario', 'FuncionarioController@StatusFuncionario');
	#Bajas
	Route::post('articulo-responsable', 'BajaController@getArticuloResponsable');
	Route::get('articulos-baja', 'BajaController@ArticulosBaja');
	Route::get('reporte-baja/{idBaja}', 'BajaController@BajaReporte');
	Route::get('info-bajas', 'BajaController@InfoBajas');
	#Inicio
	Route::get('inicio-info', 'InfoInicioController@InfoInicio');
	#LOG FILES
	Route::get('get-log-files', 'LogController@getLogFile');
});
