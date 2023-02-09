<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Servicio;
use App\Models\Responsable;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Responsable\ResponsableCollection;
use App\Http\Requests\Responsable\ResponsableStoreRequest;
use App\Http\Requests\Responsable\ResponsableUpdateRequest;
use App\Http\Resources\Responsable\ResponsableOptionsCollection;

class ResponsableController extends Controller {

	public function index() {
		try {
			$result = Responsable::with('asignaciones')->with('servicio')->with('usuario')->whereHas('asignaciones')->get();
			if ($result->isNotEmpty()) {
				return new ResponsableCollection($result);
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

	public function store(ResponsableStoreRequest $request) {
		try {
			DB::beginTransaction();
            $responsable = [
                'usuario_id'=>$request->get('usuario_id'),
                'servicio_id'=>$request->get('servicio_id')
            ];
			Responsable::create($responsable);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Responsable registrado correctamente',
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
 
			$result = Responsable::with('asignaciones')->with('servicio')->with('usuario')->whereHas('asignaciones')->where('idResponsable',$id)->get();
			return $result;
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

	public function update(ResponsableUpdateRequest $request, $id) {
		try {
			$responsable = [
                'usuario_id'=>$request->get('usuario_id'),
                'servicio_id'=>$request->get('servicio_id')
            ];
            $update= Responsable::where('idResponsable', '=', $id)->update($responsable);
			if ($update) {
				return response()->json([
					'success' => true,
					'message' => 'Responsable Actualizado correctamente',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'El Responsable No se pudo actualizar',
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
			Responsable::where('idResponsable', '=', $id)->delete();
			return response()->json([
				'success' => true,
				'message' => 'Responsable eliminado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	/**
	 *
	 *  ------------------
	 *
	 */
	public function ResponsablesOptions() {
		try {
			return new ResponsableOptionsCollection(Responsable::with('usuario')->with('servicio')->where('condicion',true)->get());
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function Usuarios() {
		try {
			$usuarios = Usuario::select('idUsuario AS usuario_id', DB::raw("CONCAT(IFNULL(paterno,''),' ',IFNULL(materno,''),' ',IFNULL(nombres,'')) AS nombre_completo"))->where('estado', '=', true)->get();
			return response()->json([
				'success' => true,
				'data'    => $usuarios,
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function Servicios() {
		try {
			$servicios = Servicio::select('idServicio AS servicio_id', 'nombre')->where('condicion', '=', true)->get();
			return response()->json([
				'success' => true,
				'data'    => $servicios,
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function bajaResponsable($id) {
		try {
			$currentStatus = Responsable::find($id);
			$responsable   = Responsable::where('idResponsable', '=', $id)->update(['condicion' => !$currentStatus->condicion]);
			$estado        = $currentStatus->condicion ? 'baja' : 'alta';
			if ($responsable) {
				return response()->json([
					'success' => true,
					'message' => 'El responsable fue dado de ' . $estado . ' correctamente',
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
