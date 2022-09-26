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
    Route::post('cambiar-clave', 'UsuarioController@CambiarClave');
    Route::post('verificar-correo', 'UsuarioController@verificarCorreo');
	Route::post('suspender-cuenta', 'UsuarioController@SuspenderCuenta');
	Route::post('reiniciar-clave', 'UsuarioController@ReiniciarClave');
	#Permisos
    Route::apiResource('permisos', PermisoController::class)->middleware(['role:Administrador']);
    #Roles
    Route::apiResource('roles', RolController::class)->middleware(['role:Administrador']);
});
Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	return "Cache is cleared";
});
