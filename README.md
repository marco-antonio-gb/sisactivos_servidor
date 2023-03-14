<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and
creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in
many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache)
    storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all
modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video
tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging
into our comprehensive video library.

## Instalacion API

1. Clonar el proyecto con el siguiente comando: (debe estar instalado [Git](https://git-scm.com/downloads))

```
 git clone https://github.com/marco-antonio-gb/sisactivos_servidor.git
```

2. Instalar dependencias

```
composer install --ignore-platform-reqs

```

3. Generar el Archivo .ENV del proyecto.

-   Haga una copia del archivo **.env.example** ubicado en la raiz del proyecto
-   Renombre el archivo a: **.env**

4. Configure las credenciales para su base de datos en el archivo **.env**.
5. Generar clave del proyecto Laravel

```
cp .env.example .env


php artisan key:generate
```

6. Publicar el paquete **tymon/jwt-auth** para la autenticacion de usuarios.

```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

7. Generamos la clave para JWT

```
php artisan jwt:secret
```

8. Crear las carpetas para los archivos del sistema

```
public_html/home

-articulos
	* fotos
	* reportes
-asignaciones
	* fotos
	* reportes
-bajas
	* fotos
	* reportes
-usuarios
	* fotos
	* reportes
-logs
	* articulos
	* asignaciones
	* bajas
	* login
	* password_reset
	* responsables
	* transferencias
	* usuarios
```

8. Ejecutar las migraciones para las tablas de Roles, Permisos y Usuarios.

```
php artisan migrate:fresh --seed
```

Usando el comando **--seed** insertamos los datos predefinidos en los seeders (/database/seeders) del proyecto.

9. Las rutas que estan disponibles para la autenticacion son:

```php
Route::group([
	'middleware' => 'api',
	'prefix'     => 'auth',
], function ($router) {
	Route::post('login', 'AuthController@login');
	Route::post('logout', 'AuthController@logout');
	Route::post('refresh', 'AuthController@refresh');
	Route::post('me', 'AuthController@userProfile');
});
```

10. Login, Logout, me

Para hacer login, envie los datos:

```
email="ana@gmail.com"
password="admin"
```

al siguiente EndPoint, con el methodo **POST**:

```
http://clinica_servidor.test/api/auth/login
```

Si todo sale bien recibira la siguiente respuesta:

```json
"access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vY2xpbmljYV9zZXJ2aWRvci50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjI5NDM5NDc1LCJleHAiOjE2MzU0NDY2NzUsIm5iZiI6MTYyOTQzOTQ3NSwianRpIjoiU1lXTDhCNEw4VjE1RHZyYiIsInN1YiI6MSwicHJ2IjoiNTg3MDg2M2Q0YTYyZDc5MTQ0M2ZhZjkzNmZjMzY4MDMxZDExMGM0ZiJ9.SapNYLTM8Ep3ied8caZKOE6GUwEeaoSI2oIFrnVfk9w"
```

11. Para acceder al Usuario logeado en el sistema:

Ingrese al siguiente endPoint con el metodo POST:
enviando el token correspondiente:

```
http://clinica_servidor.test/api/auth/me
```

12. Extras:
    Comandos utiles para limpiar el cache de composer y Laravel:

```
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
```
