<?php
 
namespace App\Http\Controllers;
use App\Models\Rol;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Validator;
class RolController extends Controller {
	public function index() {
		try {
			$result = Role::all();
			if (!$result->isEmpty()) {
				return response()->json([
					'data'        => $result,
					'success'     => true,
					'total'       => count($result),
					'message'     => 'Lista de roles',
					'status_code' => 200,
				]);
			} else {
				return [
					'success'     => false,
					'message'     => 'No existen resultados',
					'status_code' => 201,
				];
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function store(Request $request) {
		$permisos = $request['permisos'];
		try {
			$validator = Validator::make($request->all(), [
				'name'        => 'required|unique:roles,name',
				'guard_name'  => 'required',
				'descripcion' => 'required',
			]);
			if ($validator->fails()) {
				return response()->json([
					'success'     => false,
					'validator'   => $validator->errors()->all(),
					'status_code' => 400,
				]);
			} else {
				$newRole = Role::create(array_merge(
					$validator->validated()
				));
				$newRole->syncPermissions($permisos);
				return response()->json([
					'success'     => true,
					'message'     => 'Rol registrado correctamente',
					'status_code' => 201,
					'datos'       => $request['permisos'],
				], 201);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function show($id) {
		try {
			$roles = Rol::where('id', '=', $id)
				->with(array('permisos' => function ($query) {$query->select('id', 'name', 'descripcion');}))
				->first();
			if ($roles) {
				return response()->json([
					'success' => true,
					'data'    => $roles,
				], 200);
			} else {
				return [
					'success'     => false,
					'message'     => 'No se encontro ningun registro',
					'status_code' => 204,
				];
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function update(Request $request, $id) {
		try {
			$validator = Validator::make($request->all(), [
				'name'        => 'required',
				'descripcion' => 'required',
			]);
			if ($validator->fails()) {
				return response()->json([
					'success'     => false,
					'validator'   => $validator->errors()->all(),
					'status_code' => 400,
				]);
			} else {
				$res_rol = [
					'name'        => $request['name'],
					'descripcion' => $request['descripcion'],
				];
				$role              = Role::find($id);
				$role->name        = $request['name'];
				$role->descripcion = $request['descripcion'];
				$role->save();
					foreach ($request['permisos'] as $value) {
						$data[] = $value['name'];
					}
					$role->syncPermissions($data);
				return response()->json([
					'success' => true,
					'message' => 'Rol Actualizado correctamente',
				], 201);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function destroy($id) {
		try {
			Rol::where('id', '=', $id)->delete();
			return response()->json([
				'success' => true,
				'message' => 'Rol eliminado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
}
