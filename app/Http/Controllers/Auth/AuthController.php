<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Mail\ResetPassword;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

	public function login(LoginRequest $request)
	{
		try {
			$usuarioExist = Usuario::query()->where('correo', '=', $request['correo'])->exists();
			if ($usuarioExist) {
				$verificarEstado = Usuario::select('estado')->where('correo', '=', $request['correo'])->first();
				if (!$verificarEstado['estado']) {
					Log::channel('login_usuarios')->info('data => ', ['AccountSuspended' => $request->all(), 'IP' => \Request::getClientIp(true)]);
					return response()->json([
						'success' => false,
						'message' => 'Esta cuenta ha sido suspendida.',
					], 201);
				} else {
					if (!$token = auth('api')->attempt($request->all())) {
						Log::channel('login_usuarios')->info('data => ', ['ErrorLogin' => $request->all(), 'IP' => \Request::getClientIp(true)]);
						return response()->json([
							'success' => false,
							'message' => 'Los datos son inccorrectos',
						], 201);
					}
					Log::channel('login_usuarios')->info('data => ', ['SuccessLogin' => $request->all(), 'IP' => \Request::getClientIp(true)]);
					return $this->respondWithToken($token);
				}
			} else {
				Log::channel('login_usuarios')->info('data => ', ['AccountNotExist' => $request->all(), 'IP' => \Request::getClientIp(true)]);
				return response()->json([
					'success' => false,
					'message' => 'La cuenta no existe',
				], 201);
			}
		} catch (\Exception $ex) {
			Log::channel('login_usuarios')->info('data => ', ['ErrorException' => $request->all(), 'ExceptionMessage' => $ex->getMessage(),  'IP' => \Request::getClientIp(true)]);
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function userProfile()
	{
		$authenticated = auth()->check();
		if ($authenticated) {
			$id           = auth()->user()->idUsuario;
			$usuario      = Usuario::select('idUsuario', 'settings', 'paterno', 'materno', 'nombres', 'cargo', 'estado', 'foto')->where('idUsuario', '=', $id)->first();
			$usaurio_data = [
				'usuario_id'      => $usuario['idUsuario'],
				'nombre_completo' => $usuario['nombres'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno'],
				'cargo'           => $usuario['cargo'],
				'estado'          => $usuario['estado'] ? 'Activado' : 'Desactivado',
				'settings'      => $usuario['settings'],

				'roles'           => getAllRoles($id),
				'permisos'        => getAllPermissions($id),
				'foto'            => $usuario['foto'],
				'user_name'       => $usuario['nombres'],
				'avatar_letter'   => SKU_gen($usuario['nombres']),
				'avatar_color'    => getcolorAvatar($usuario['nombres']),
			];
			return response()->json([
				'success' => true,
				'data'    => $usaurio_data,
			]);
		}
		return response()->json([
			'success' => false,
			'message'    => 'Su token ha expirado',
		], 401);
	}
	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
		auth()->logout();
		Log::channel('login_usuarios')->info('data => ', ['LogOut' => auth()->user(), 'IP' => \Request::getClientIp(true)]);
		return response()->json(['success' => true, 'message' => 'Su sesion se ha cerrado']);
	}
	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
		Log::channel('login_usuarios')->info('data => ', ['RefreshToken' => auth()->user(), 'IP' => \Request::getClientIp(true)]);
		return $this->respondWithToken(auth()->refresh());
	}
	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function checkToken()
	{
		return response()->json(['valid' => auth()->check()]);
	}
	protected function respondWithToken($token)
	{
		return response()->json([
			'success'      => true,
			'access_token' => $token,
		], 201);
	}
	/**
	 * Reset password
	 */
	public function ForgotPassword(Request $request)
	{
		try {
			$email = Usuario::query()->where('correo', '=', $request->email)->first();
			if ($email) {
				$reset_token = strtolower(Str::random(64));
				$url         = "http://localhost:8080/reset-password?token=" . $reset_token;
				$data        = array('email' => $request->email, 'token' => $url);
				$send        = Mail::to($request->email)->queue(new ResetPassword($data));
				DB::table('password_resets')->insert([
					'email'      => $request->email,
					'token'      => $reset_token,
					'created_at' => Carbon::now()->addMinutes(10),
				]);
				Log::channel('password_reset')->info('data => ', ['SuccessSendEmail' => $request->all(), 'IP' => \Request::getClientIp(true)]);
				return response()->json([
					'success' => true,
					'message' => "El correo ha sido enviado correctamente.",
				], 200);
			} else {
				Log::channel('password_reset')->info('data => ', ['EmailNotExist' => $request->all(), 'IP' => \Request::getClientIp(true)]);
				return response()->json([
					'success' => false,
					'message' => "El correo no existe en el sistema.",
				], 201);
			}
		} catch (\Exception $ex) {

			Log::channel('password_reset')->info('data => ', ['Exception' => $ex->getMessage(), 'IP' => \Request::getClientIp(true)]);
			return response()->json([
				'success' => true,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function ValidateTokenReset(Request $request)
	{
		$expired = $this->ExpiredToken($request->token);
		Log::channel('password_reset')->info('data => ', ['ValidateTokenReset' => $request->all(), 'IP' => \Request::getClientIp(true)]);

		return response()->json([
			'expired' => $expired,
		], 201);
	}
	public function ExpiredToken($token)
	{
		$result    = false;
		$token_res = DB::table('password_resets')
			->where('token', '=', $token)
			->first();
		if ($token_res) {
			$created = new Carbon($token_res->created_at);
			$isPast  = $created->isPast();
			if ($isPast) {
				$result = true;
			}
		}
		return $result;
	}
	public function ExistToken($token)
	{
		$res = DB::table('password_resets')->where('token', '=', $token)->exists();
		return $res;
	}
	public function SetPasswordReset(Request $request)
	{
		try {
			$validator = Validator::make($request->all(), [
				'password'         => 'required',
				'confirm_password' => 'required|same:password',
				'token'            => 'required',
			]);
			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'message' => $validator->errors()->all(),
				], 400);
			} else {
				$existToken = $this->ExistToken($request->token);
				if ($existToken) {
					$new_password = bcrypt($request->password);
					$token        = DB::table('password_resets')
						->where('token', '=', $request->token)
						->first();
					if (!$this->ExpiredToken($token->token)) {
						Usuario::query()->where('correo', '=', $token->email)->update(array('password' => $new_password));
						Log::channel('password_reset')->info('data => ', ['SuccessResetPassword' => $request->all(), 'IP' => \Request::getClientIp(true)]);

						return response()->json([
							'success' => true,
							'message' => "Contraseña actualizada exitosamente",
						], 201);
					}
					return response()->json([
						'success' => false,
						'message' => "El token para restablecer su contraña ha caducado.",
					], 201);
				}
				return response()->json([
					'success' => false,
					'message' => "El token no es valido, intente enviar el correo de recuperacion nuevamente.",
				], 201);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}

	public function storeLog()
	{
	}
}
