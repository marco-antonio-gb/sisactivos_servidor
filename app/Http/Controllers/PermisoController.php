<?php

namespace App\Http\Controllers;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class PermisoController extends Controller {

	public function __construct() {
		$this->middleware(['role:Administrador'])->except(['permission:permiso-list|permiso-create']);
	}

	public function index() {
		try {
			$result = Permiso::all();
			if (!$result->isEmpty()) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				]);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No existen resultados',
				]);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function store(Request $request) {
		try {
			$validator = Validator::make($request->all(), [
				'name'        => 'required|unique:permissions',
				'descripcion' => 'required',
			]);
			if ($validator->fails()) {
				return response()->json([
					'success'   => false,
					'validator' => $validator->errors()->all(),
				], 400);
			} else {
				Permiso::create(array_merge(
					$validator->validated()
				));
				return response()->json([
					'success' => true,
					'message' => 'Permiso registrado correctamente',
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
			$result = Permiso::find($id);
			if ($result) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				]);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No se encontro ningun registro',
				]);
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
				$res_rol = [
					'name'        => $request['name'],
					'guard_name'  => $request['guard_name'],
					'descripcion' => $request['descripcion'],
				];
				Permiso::where('id', '=', $id)->update($res_rol);
				return response()->json([
					'success' => true,
					'message' => 'Permiso Actualizado correctamente',
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
			$permiso = Permiso::find($id);
			if (empty($permiso)) {
				return response()->json([
					'success' => false,
					'message' => 'No se encontro el registro solicitado',
				], 404);
			}
			$deleted = $permiso->delete($id);
			if (!$deleted) {
				return response()->json([
					'success' => false,
					'message' => 'No se pudo eliminar el registro',
				], 404);
			}
			return response()->json([
				'success' => true,
				'message' => 'Regsitro eliminado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
}
