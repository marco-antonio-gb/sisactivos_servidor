<?php
namespace App\Http\Controllers;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Categoria\StoreCategoriaRequest;

class CategoriaController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$result = Categoria::all();
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
	public function store(StoreCategoriaRequest $request) {
		try {
			DB::beginTransaction();
			$categoria = [
				'nombre'      => $request->get('nombre'),
				'vida_util'   => $request->get('vida_util'),
				'descripcion' => $request->get('descripcion'),
				'condicion'   => $request->get('condicion'),
			];
			Categoria::create($categoria);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Categoria registrada correctamente',
			], 201);
		} catch (\Exception $ex) {
			DB::rollback();
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
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
