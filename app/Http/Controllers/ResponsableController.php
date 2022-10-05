<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ResponsableStoreRequest;
use App\Http\Requests\ResponsableUpdateRequest;

class ResponsableController extends Controller
{

    public function index()
    {
        try {
			$result = Responsable::all();
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


    public function store(ResponsableStoreRequest $request)
    {
        try {
			DB::beginTransaction();
			$user = Responsable::create($request->all());
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

    public function show($id)
    {
        try {
			$result = Responsable::with('usuario')->with('servicio')->where('idResponsable', '=', $id)->first();

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

    public function update(ResponsableUpdateRequest $request, $id)
    {
        try {
			$responsable = Responsable::where('idResponsable', '=', $id)->update($request->all());
			if ($responsable) {
				return response()->json([
					'success' => true,
					'message' => 'Responsable Actualizado correctamente',
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
    public function bajaResponsable($id){
        try {
            $currentStatus = Responsable::find($id);
			$responsable = Responsable::where('idResponsable', '=', $id)->update(['condicion'=>!$currentStatus->condicion]);
            $estado = $currentStatus->condicion?'baja':'alta';
			if ($responsable) {
				return response()->json([
					'success' => true,
					'message' => 'El responsable fue dado de '. $estado .' correctamente',
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
    public function destroy($id)
    {

    }
}
