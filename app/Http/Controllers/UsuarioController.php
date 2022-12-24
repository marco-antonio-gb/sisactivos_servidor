<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Http\Requests\UsuarioPictureRequest;
class UsuarioController extends Controller {
	// public function __construct() {
	// 	$this->middleware('jwt.auth');
	// }
	public function index() {
		try {
			$result = Usuario::select('nombres', 'idUsuario AS usuario_id', DB::raw("CONCAT(IFNULL(paterno,''),' ',IFNULL(materno,''),' ',IFNULL(nombres,'')) AS nombre_completo"), DB::raw("CONCAT(IFNULL(ci,''),' ',IFNULL(ci_ext,'')) AS cedula"), 'cargo', 'telefono', 'foto', 'estado', 'correo', 'created_at')->get();
			if (!$result->isEmpty()) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No existen resultados',
				], 200);
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
			$folder    = "/home/usuarios/fotos";
			$imageName = "****";
			$datos     = json_decode($request['data'], true);
			$imageName = storeImage($request['foto'], $folder);
			$usuario   = [
				'paterno'   => $datos['paterno'],
				'materno'   => $datos['materno'],
				'nombres'   => $datos['nombres'],
				'ci'        => $datos['ci'],
				'ci_ext'    => $datos['ci_ext'],
				'direccion' => $datos['direccion'],
				'telefono'  => $datos['telefono'],
				'cargo'     => $datos['cargo'],
				'correo'    => $datos['correo'],
				'foto'      => $imageName,
				"password"  => bcrypt($datos['password']),
			];
			$user = Usuario::create($usuario);
			$user->assignRole($datos['roles']);
			$user->givePermissionTo($datos['permisos']);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Usuario registrado correctamente',
			], 201);
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
			$user = Usuario::where('idUsuario', '=', $id)->select('idUsuario as usuario_id','paterno', 'materno', 'nombres', 'ci', 'ci_ext', 'cargo', 'telefono', 'direccion', 'correo', 'created_at', 'updated_at', 'foto', 'estado')->first();
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
	#Para usuario autenticado
	public function ChangePassword(Request $request) {
		try {
			$this->validate($request, [
				'old_password'     => 'required',
				'new_password'     => 'required|min:6',
				'confirm_password' => 'required|same:new_password',
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
						'message' => "Introduzca una contraseña que no sea similar a la contraseña actual.",
					], 404);
				}
			} else {
				return response()->json([
					'success' => false,
					'message' => "Revisa tu antigua contraseña",
				], 404);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	public function VerificarCorreo(Request $request) {
		try {
			$correo = $request['correo'];
			$exist  = Usuario::where('correo', '=', $correo)->exists();
			if (!$exist) {
				return response()->json([
					'success' => true,
					'message' => "El correo electrónico esta disponible",
				], 200);
			}
			return response()->json([
				'success' => false,
				'message' => "El correo electrónico ya existe, seleccione otro.",
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function SuspendAccount(Request $request) {
		try {
			$usuario_id = $request['usuario_id'];
			$usuario    = Usuario::find($usuario_id);
			if ($usuario) {
				$estado = $usuario->estado;
				if (!$estado) {
					return response()->json([
						'success' => true,
						'message' => "La cuenta del usuario ya esta suspendida.",
					], 201);
				}
				Usuario::where('idUsuario', $usuario_id)->update(['estado' => !$estado]);
				return response()->json([
					'success' => true,
					'message' => "La cuenta del usuario fue suspendida correctamente.",
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => "No se encontro el registro.",
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	public function ActivateAccount(Request $request) {
		try {
			$usuario_id = $request['usuario_id'];
			$usuario    = Usuario::find($usuario_id);
			if ($usuario) {
				$estado = $usuario->estado;
				if ($estado) {
					return response()->json([
						'success' => true,
						'message' => "La cuenta del usuario ya esta Activa.",
					], 201);
				}
				Usuario::where('idUsuario', $usuario_id)->update(['estado' => !$estado]);
				return response()->json([
					'success' => true,
					'message' => "La cuenta del usuario fue Activada correctamente.",
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => "No se encontro el registro.",
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'error'   => $ex->getMessage(),
			], 404);
		}
	}
	# Cambiar imagen actual del usuario o establecer una nueva imagen
	public function ChangeUserPicture(UsuarioPictureRequest $request) {
		try {
			DB::beginTransaction();
			$usuario_id   = $request->usuario_id;
			$folder       = "/home/usuarios/fotos";
			$old_filename = Usuario::find($usuario_id)->foto;
			$new_filename = storeImage($request['foto'], $folder);
			if ($new_filename) {
				$update_result = Usuario::where('idUsuario', '=', $usuario_id)->update(['foto' => $new_filename]);
				deleteImage($folder, $old_filename);
				DB::commit();
				return response()->json([
					'success' => true,
					'message' => "Image actualizada correctamente",
				], 200);
			}
		} catch (\Exception $ex) {
			DB::rollback();
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function DeleteImageUser($id) {
		try {
			$old_filename = Usuario::find($id)->foto;
			if ($old_filename) {
				$delete = deleteImage("usuarios", $old_filename);
				Usuario::where('idUsuario', $id)->update(['foto' => ""]);
				return response()->json([
					'success' => true,
					'message' => "Imagen eliminada correctamente",
				], 201);
			} else {
				return response()->json([
					'success' => false,
					'message' => "No se pudo encontrar la imagen",
				], 404);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}

}
