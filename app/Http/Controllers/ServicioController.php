<?php
namespace App\Http\Controllers;
use App\Http\Requests\ServicioStoreRequest;
use App\Http\Requests\ServicioUpdateRequest;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
class ServicioController extends Controller {
	public function index() {
		try {
			$result = Servicio::all();
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
	public function store(ServicioStoreRequest $request) {
		try {
			DB::beginTransaction();
			$user = Servicio::create($request->all());
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'servicio registrado correctamente',
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
			$result = Servicio::where('idServicio', '=', $id)->first();
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
	public function update(ServicioUpdateRequest $request, $id) {
		try {
			$servicio = Servicio::where('idServicio', '=', $id)->update($request->all());
			if ($servicio) {
				return response()->json([
					'success' => true,
					'message' => 'Servicio Actualizado correctamente',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'El Servicio No se pudo actualizar',
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
			$servicio = Servicio::where('idServicio', '=', $id)->delete();
			if ($servicio) {
				return response()->json([
					'success' => true,
					'message' => 'Servicio eliminado correctamente',
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
}
