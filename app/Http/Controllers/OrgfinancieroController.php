<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrgFinanciero;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Orgfinanciero\StoreOrgfinancieroRequest;
use App\Http\Requests\Orgfinanciero\UpdateOrgfinancieroRequest;

class OrgfinancieroController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$result = OrgFinanciero::all();
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreOrgfinancieroRequest $request) {
		try {
			DB::beginTransaction();
			$servicio = [
				'nombre'      => $request->get('nombre'),
				'descripcion' => $request->get('descripcion'),
			];
			OrgFinanciero::create($servicio);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Org. Financiero registrado correctamente',
			], 201);
		} catch (\Exception $ex) {
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
		try {
			$result = OrgFinanciero::where('idOrgFinanciero', '=', $id)->first();
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

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateOrgfinancieroRequest $request, $id) {
		try {
			$orgfinanciero = [
				'nombre'      => $request->get('nombre'),
				'descripcion' => $request->get('descripcion'),
			];
			$update = OrgFinanciero::where('idOrgfinanciero', '=', $id)->update($orgfinanciero);
			if ($update) {
				return response()->json([
					'success' => true,
					'message' => 'OrgFinanciero Actualizado correctamente',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'El OrgFinanciero No se pudo actualizar',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		try {
			$delete = OrgFinanciero::where('idOrgFinanciero', '=', $id)->delete();
			if ($delete) {
				return response()->json([
					'success' => true,
					'message' => 'OrgFinanciero eliminado correctamente',
				], 200);
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
