<?php
use Illuminate\Support\Facades\Route;
Route::group(['middleware'=> 'api'], function($router){
    Route::post('forgot-password', 'AuthController@ForgotPassword');
    Route::post('validate-token', 'AuthController@ValidateTokenReset');
    Route::post('password-reset', 'AuthController@SetPasswordReset');
	Route::post('set-password-reset', 'AuthController@SetPasswordReset');
});
Route::group([
	'middleware' => 'api',
	'prefix'     => 'auth',
], function ($router) {
	Route::post('login', 'AuthController@login');
	Route::post('logout', 'AuthController@logout');
	Route::post('refresh', 'AuthController@refresh');
	Route::post('me', 'AuthController@userProfile');
});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
    # Api Resource
	Route::apiResource('usuarios', UsuarioController::class)->middleware(['role:Administrador']);
	Route::apiResource('personas', PersonaController::class)->middleware(['role:Administrador']);
	Route::apiResource('permisos', PermisoController::class)->middleware(['role:Administrador']);
	Route::apiResource('roles', RolController::class)->middleware(['role:Administrador']);
	Route::apiResource('servicios', ServicioController::class)->middleware(['role:Administrador']);
	Route::apiResource('responsables', ResponsableController::class)->middleware(['role:Administrador']);
    Route::apiResource('categorias', CategoriaController::class)->middleware(['role:Administrador']);
	Route::apiResource('orgfinanciero', OrgfinancieroController::class)->middleware(['role:Administrador']);
	Route::apiResource('asignaciones', AsignacionController::class)->middleware(['role:Administrador']);
    #Personas
	Route::post('verificar-ci', 'PersonaController@VerificarCi');
	#Usuarios
	Route::post('change-password', 'UsuarioController@ChangePassword');
	Route::post('change-user-picture', 'UsuarioController@ChangeUserPicture');
	Route::delete('delete-image-user/{id}', 'UsuarioController@DeleteImageUser');
	Route::post('verificar-correo', 'UsuarioController@VerificarCorreo');
	Route::post('activate-account', 'UsuarioController@ActivateAccount');
	Route::post('suspend-account', 'UsuarioController@SuspendAccount');
    #Articulos
	Route::apiResource('articulos', ArticuloController::class)->middleware(['role:Administrador']);
    #Responsable
	Route::get('responsable-baja/{id}', 'ResponsableController@bajaResponsable');
});
