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
Route::group(['middleware' => ['jwt.verify','cors']], function () {
    #Personas
    Route::apiResource('personas',PersonaController::class)->middleware(['role:Administrador']);
    Route::post('verificar-ci', 'PersonaController@VerificarCi');

    #Usuarios
	Route::apiResource('usuarios', UsuarioController::class);
    Route::post('update-password', 'UsuarioController@updatePassUsuario');
	Route::post('suspend-account', 'UsuarioController@BloquearUsuario');
	Route::post('reset-password', 'UsuarioController@ResetPassword');
	Route::get('get-active-users/{idUsuario}', 'UsuarioController@getActiveUsers');
	Route::post('set-theme', 'UsuarioController@SetTheme');
    Route::post('update-password', 'UsuarioController@updatePassUsuario');
	Route::post('suspend-account', 'UsuarioController@BloquearUsuario');
	Route::post('reset-password', 'UsuarioController@ResetPassword');
    Route::post('verify-email', 'UsuarioController@verifyEmailExist');
    #Roles
    Route::apiResource('roles', RolController::class)->middleware(['role:Administrador']);
	#Permisos
    Route::apiResource('permisos', PermisoController::class)->middleware(['role:Administrador']);
    // Route::get('user', 'UsuarioController@getAuthenticatedUser');
});
Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	return "Cache is cleared";
});
