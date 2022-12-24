<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AsignacionStoreRequest;
use App\Http\Requests\AsignacionUpdateRequest;
use App\Http\Resources\Asignacion\AsignacionCollection;

class AsignacionController extends Controller {

	public function index() {
		try {
			// return Asignacion::with('usuario')->with('responsable')->get();
			return new AsignacionCollection(Asignacion::with('usuario')->with('responsable')->get());

			if ($result->isNotEmpty()) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				], 200);
			}
			return response()->json([
				'success' => false,
				'message' => 'No existen resultados',
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}

	public function store(AsignacionStoreRequest $request) {
		try {
			DB::beginTransaction();
			$user = Asignacion::create($request->all());
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Asignacion registrado correctamente',
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
			$result = Asignacion::with('responsable')->with('usuario')->where('idAsignacion', '=', $id)->first();

			if ($result) {
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

	public function update(AsignacionUpdateRequest $request, $id) {
		try {
			$asignacion = Asignacion::where('idAsignacion', '=', $id)->update($request->all());
			if ($asignacion) {
				return response()->json([
					'success' => true,
					'message' => 'Asignacion Actualizado correctamente',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'La asignacion No se pudo actualizar',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}

	public function destroy($id) {
		//
	}
}
