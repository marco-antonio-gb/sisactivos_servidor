<?php
namespace App\Http\Controllers;
use App\Http\Requests\ArticuloStoreRequest;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller {
	public function index() {
		try {
			$result = Articulo::all();
			if ($result->isNotEmpty()) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				], 200);
			}
			return response()->json([
				'success' => true,
				'message' => 'No existen resultados',
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function store(ArticuloStoreRequest $request) {

		try {
			DB::beginTransaction();
			$folder    = "articulos";
			$imageName = "****";
			$datos     = json_decode($request['data'], true);
			$imageName = storeImage($request['imagen'], $folder);
			$articulo  = [
				'codigo'           => $datos['codigo'],
				'unidad'           => $datos['unidad'],
				'descripcion'      => $datos['descripcion'],
				'imagen'           => $imageName,
				'costo'            => $datos['costo'],
				'estado'           => $datos['estado'],
				'nombre'           => $datos['nombre'],
				'categoria_id'     => $datos['categoria_id'],
				'orgfinanciero_id' => $datos['orgfinanciero_id'],
			];
			$user = Articulo::create($articulo);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Articulo registrado correctamente',
			], 201);
		} catch (\Exception $ex) {
			deleteImage('articulos', $imageName);
			DB::rollback();
			return [
				'success' => false,
				'message' => $ex->getMessage(),
			];
		}
	}
	public function show($id) {
		try {
			$result = Articulo::where('idArticulo', '=', $id)->first();
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
	public function update(Request $request, $id) {
		//
	}
	public function destroy($id) {
		try {
			$articulo = Articulo::where('idArticulo', '=', $id)->delete();
			if ($articulo) {
				return response()->json([
					'success' => true,
					'message' => 'Articulo eliminado correctamente',
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
