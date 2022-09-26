<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
	/**
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */
	// public function __construct() {
	// 	$this->middleware('auth:api', ['except' => ['login','logout']]);
	// }
	/**
	 * Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login() {
		$credentials = request(['username', 'password']);
		if (Usuario::where('username', '=', $credentials['username'])->exists()) {
			$verificarEstado = Usuario::select('estado')->where('username', '=', $credentials['username'])->get()->first();
			if (!$verificarEstado['estado']) {
				return response()->json([
					'success' => false,
					'message' => 'La cuenta esta suspendida',
				], 201);
			} else {
				if (!$token = auth('api')->attempt($credentials)) {
					return response()->json([
						'success' => false,
						'message' => 'Los datos son inccorrectos',
					], 201);
				}
				return $this->respondWithToken($token);
			}
		} else {
			return response()->json([
				'success' => false,
				'message' => 'La cuenta no existe',
			], 201);
		}
	}
	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function userProfile() {
		$id      = auth()->user()->idUsuario;
		$usuario = Usuario::where('idUsuario', '=', $id)->with(
            array('persona' => function ($query) {$query->select('idPersona', DB::raw("CONCAT(IFNULL(nombres,''),' ',IFNULL(paterno,''),' ',IFNULL(materno,'')) AS full_name"));})
        )->first();
		 
		$usaurio_data = [
			'idUsuario' => $usuario['idUsuario'],
			'full_name' => $usuario['persona']['full_name'],
			'cargo'     => $usuario['tipo_usuario'],
			'settings'  => $usuario['settings'],
			'estado'    => $usuario['estado'],
			'permisos'  => getAllPermissions($id),
			'roles'     => getAllRoles($id),
            'fecha_ingreso' =>$usuario['fecha_ingreso']
		];
		return response()->json([
			'success' => true,
			'data'    => $usaurio_data,
		]);
	}
	 
	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout() {
		auth()->logout();
		return response()->json(['success' => true, 'message' => 'Su sesion se ha cerrado']);
	}
	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh() {
		return $this->respondWithToken(auth()->refresh());
	}
	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function checkToken() {
		return response()->json(['valid' => auth()->check()]);
	}

	protected function respondWithToken($token) {

        
        return response()->json([
                'success' => true,
                
                'access_token' => $token,
            ], 201);


		 
	}
}
