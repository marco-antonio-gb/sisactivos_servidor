<?php
use Illuminate\Support\Facades\Route;
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
	#Personas
	Route::apiResource('personas', PersonaController::class)->middleware(['role:Administrador']);
	Route::post('verificar-ci', 'PersonaController@VerificarCi');
	#Usuarios
	Route::apiResource('usuarios', UsuarioController::class);
	Route::post('change-password', 'UsuarioController@ChangePassword');
	Route::post('change-user-picture', 'UsuarioController@ChangeUserPicture');
	Route::delete('delete-image-user/{id}', 'UsuarioController@DeleteImageUser');
	Route::post('verificar-correo', 'UsuarioController@VerificarCorreo');
	Route::post('activate-account', 'UsuarioController@ActivateAccount');
	Route::post('suspend-account', 'UsuarioController@SuspendAccount');
	// Route::post('reiniciar-clave', 'UsuarioController@ReiniciarClave');
	#Permisos
	Route::apiResource('permisos', PermisoController::class)->middleware(['role:Administrador']);
	#Roles
	Route::apiResource('roles', RolController::class)->middleware(['role:Administrador']);
});
Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	return "Cache is cleared";
});
 
Route::post('forgot-password', 'AuthController@ForgotPassword');
Route::post('validate-token', 'AuthController@ValidateTokenReset');
Route::post('set-password-reset', 'AuthController@SetPasswordReset');

