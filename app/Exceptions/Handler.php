<?php
namespace App\Exceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];
	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];
	/**
	 * Register the exception handling callbacks for the application.
	 *
	 * @return void
	 */
	public function register() {
		$this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
			return response()->json([
				'success' => false,
				'message' => 'No posee los permisos necesarios para ver el contenido',
			], 403);
		});
		$this->renderable(function (MethodNotAllowedHttpException $e, $request) {
			return response()->json([
				'success' => false,
				'message' => 'Método no permitido',
			], 405);
		});
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
			    	'message' => 'Contenido no encontrado',
                ], 404);
            }
        });

	}
 
}
