<?php
namespace App\Http\Controllers;
use App\Http\Requests\Baja\BajaStoreRequest;
use App\Http\Resources\Baja\BajaCollection;
use App\Models\Articulo;
use App\Models\Baja;
use App\Models\DetalleBaja;
use App\Models\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
		} catch (\Exception$ex) {
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
		/**
		 * TODO: Validar Articulo y responsable
		 * TODO: Actualizar estado de Articulo { condicion = false }
		 */
		try {
			DB::beginTransaction();
			$usuario_id = auth()->user()->idUsuario;
			$baja       = [
				'responsable_id' => $request['responsable_id'],
				'usuario_id'     => $usuario_id,
			];
			$last_baja_id = Baja::create($baja)->idBaja;
			$detalle_baja = [
				'baja_id'       => $last_baja_id,
				'articulo_id'  => $request['articulo_id'],
				'motivo'       => $request['motivo'],
				'informebaja' => $request['informe_baja'],
			];
			DetalleBaja::create($detalle_baja);
			Articulo::where('idArticulo', '=', $request['articulo_id'])->update(['condicion' => false, 'estado' => 'Malo']);

			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Articulos fueron dados de Baja correctamente',
			], 201);
		} catch (\Illuminate\Database\QueryException$ex) {
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
	public function getArticuloResponsable(Request $request) {
		try {
			$articulo      = Articulo::where('idArticulo', $request['idArticulo'])->with('archivo')->first();
			$responsable   = Responsable::with('usuario')->where('idResponsable', $request['idResponsable'])->first();
			$response_data = [
				'articulo_id'           => $articulo->idArticulo,
				'articulo_codigo'       => $articulo->codigo,
				'articulo_nombre'       => $articulo->nombre,
				'articulo_descripcion'  => $articulo->descripcion,
				'articulo_foto'         => $articulo->archivo->url,
				'responsable_id'        => $responsable->idResponsable,
				'responsable_full_name' => $responsable->usuario->nombres . ' ' . $responsable->usuario->paterno . ' ' . $responsable->usuario->materno,
				'responsable_cedula'    => $responsable->usuario->ci . ' ' . $responsable->usuario->ci_ext,
			];
			return response()->json([
				'success' => true,
				'data'    => $response_data,
			], 200);
		} catch (\Illuminate\Database\QueryException$ex) {
			return [
				'success' => false,
				'message' => $ex->getMessage(),
			];
		}
	}
}
