<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Models\Articulo;
use App\Models\DetalleBaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Baja\BajaCollection;
use App\Http\Requests\Baja\BajaStoreRequest;

class BajaController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$result = Baja::with('usuario')->with('responsable')->with('detalle_baja')->get();
			if ($result->isNotEmpty()) {
				return new BajaCollection($result);
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(BajaStoreRequest $request) {
		try {
			DB::beginTransaction();

			$baja = [
				'responsable_id' => $request['responsable_id'],
				'usuario_id'     => $request['usuario_id'],
			];
			$last_baja_id = Baja::create($baja)->idBaja;
			$articulos    = $request['articulos'];
			foreach ($articulos as $key => $articulo) {
				$detalle_baja = [
					"baja_id"     => $last_baja_id,
					"articulo_id" => $articulo['articulo_id'],
					"motivo"      => $articulo['motivo'],
					"informebaja" => $articulo['informebaja'],
				];
				DetalleBaja::create($detalle_baja);
				Articulo::where('idArticulo', '=', $articulo['articulo_id'])->update(['condicion' => false, 'estado'=>'Malo']);
			}
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => count($articulos).' '.'Articulos fueron dados de Baja correctamente',
			], 201);
		} catch (\Illuminate\Database\QueryException $ex) {
			DB::rollback();
			return [
				'success' => false,
				'message' => $ex->getMessage(),
			];
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
