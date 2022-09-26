<?php
namespace App\Http\Controllers;
use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsuarioController extends Controller {
	public function __construct() {
		$this->middleware('jwt.auth');
	}
	public function index() {
		try {
			$result = Usuario::select('idUsuario AS usuario_id', DB::raw("CONCAT(IFNULL(paterno,''),' ',IFNULL(materno,''),' ',IFNULL(nombres,'')) AS nombre_completo"), DB::raw("CONCAT(IFNULL(ci,''),' ',IFNULL(ci_ext,'')) AS cedula"), 'cargo', 'telefono', 'direccion', 'correo', 'created_at', 'updated_at')->get();
			if (!$result->isEmpty()) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No existen resultados',
				], 204);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	// Crear usuario
	public function store(UsuarioStoreRequest $request) {
		try {
			DB::beginTransaction();
			$usuario = [
				'paterno'   => $request['paterno'],
				'materno'   => $request['materno'],
				'nombres'   => $request['nombres'],
				'ci'        => $request['ci'],
				'ci_ext'    => $request['ci_ext'],
				'direccion' => $request['direccion'],
				'telefono'  => $request['telefono'],
				'cargo'     => $request['cargo'],
				'correo'    => $request['correo'],
				'foto'      => $request['foto'],
				"username"  => $request['username'],
				"password"  => bcrypt($request['password']),
			];
			$user = Usuario::create($usuario);
			$user->assignRole($request['roles']);
			$user->givePermissionTo($request['permisos']);
			DB::commit();
			return [
				'success' => true,
				'message' => "Usuario registrado correctamente",
			];
		} catch (\Exception $ex) {
			DB::rollback();
			return [
				'success' => false,
				'message' => $ex->getMessage(),
			];
		}
	}
	public function show($id) {
		try {
			$user = Usuario::where('idUsuario', '=', $id)->select('idUsuario AS usuario_id', DB::raw("CONCAT(IFNULL(paterno,''),' ',IFNULL(materno,''),' ',IFNULL(nombres,'')) AS nombre_completo"), DB::raw("CONCAT(IFNULL(ci,''),' ',IFNULL(ci_ext,'')) AS cedula"), 'cargo', 'telefono', 'direccion', 'correo', 'created_at', 'updated_at')->first();
			if ($user) {
				$user->setAttribute('roles', getAllRoles($id));
				$user->setAttribute('permisos', getAllPermissions($id));
				return response()->json([
					'success' => true,
					'data'    => $user,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'Registro no encontrado',
				], 200);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function update(UsuarioUpdateRequest $request, $id) {
		try {
			$user            = Usuario::find($id);
			$user->paterno   = $request['paterno'];
			$user->materno   = $request['materno'];
			$user->nombres   = $request['nombres'];
			$user->ci        = $request['ci'];
			$user->ci_ext    = $request['ci_ext'];
			$user->direccion = $request['direccion'];
			$user->telefono  = $request['telefono'];
			$user->cargo     = $request['cargo'];
			$user->correo    = $request['correo'];
			$user->save();
			$roles = $request['roles'];
			foreach ($roles as $key => $value) {
				if (is_string($value)) {
					$names[] = $value;
				} else {
					$names[] = $value['name'];
				}
			}
			$user->syncRoles($names);
			return response()->json([
				'success' => true,
				'message' => 'Usuario Actualizado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function destroy($id) {
		try {
			$usuario = Usuario::where('idUsuario', '=', $id)->delete();
			if ($usuario) {
				return response()->json([
					'success' => true,
					'message' => 'Usuario eliminado correctamente',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'Registro no encontrado',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	/*---------------------   CUSTOM FUNCTIONS -------------------------*/
	public function verificarCorreo(Request $request) {
		try {
			if (Usuario::where('email', '=', $request['email'])->exists()) {
				return response()->json([
					'success' => true,
					'message' => "El correo ya existe, seleccione otro",
				], 404);
			} else {
				return response()->json([
					'success' => false,
					'message' => "El correo esta disponible",
				], 200);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function CambiarClave(Request $request) {
		try {
			$this->validate($request, [
				'old_password' => 'required',
				'new_password' => 'required',
			]);
			$hashedPassword = Auth::user()->password;
			if (\Hash::check($request->old_password, $hashedPassword)) {
				if (!\Hash::check($request->new_password, $hashedPassword)) {
					$users           = Usuario::find(Auth::user()->idUsuario);
					$users->password = bcrypt($request->new_password);
					Usuario::where('idUsuario', Auth::user()->idUsuario)->update(array('password' => $users->password));
					return response()->json([
						'success' => true,
						'message' => "Contraseña actualizada exitosamente",
					], 201);
				} else {
					return response()->json([
						'success' => false,
						'message' => "¡La nueva contraseña no puede ser la contraseña anterior!",
					], 404);
				}
			} else {
				return response()->json([
					'success' => false,
					'message' => "La contraseña anterior no coincide",
				], 404);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	public function ReiniciarClave(Request $request) {
		try {
			$hashed_random_password = generateStrongPassword(15, false, 'luds');
			Usuario::where('idUsuario', '=', $request['userId'])->update(['password' => Hash::make($hashed_random_password)]);
			return response()->json([
				'success'     => true,
				'message'     => "La contraseña se restablecio",
				'newPassword' => $hashed_random_password,
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	public function SuspenderCuenta(Request $request) {
		try {
			if ($request['status']) {
				$active  = false;
				$mensaje = "Cuenta de usuario desactivada";
			} else {
				$active  = true;
				$mensaje = "Cuenta de usuario activada correctamente";
			}
			Usuario::where('idUsuario', '=', $request['userId'])->update(['activo' => $active]);
			return response()->json([
				'success' => true,
				'message' => $mensaje,
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
}
