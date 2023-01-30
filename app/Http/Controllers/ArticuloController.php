<?php
namespace App\Http\Controllers;
use App\Http\Requests\Articulo\ArticuloStoreRequest;
use App\Http\Requests\Articulo\ArticuloUpdateRequest;
use App\Http\Resources\Articulo\ArticuloCollection;
use App\Http\Resources\Articulo\ArticuloResource;
use App\Http\Resources\Articulo\ArticulosOptionsCollection;
use App\Models\Archivo;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ArticuloController extends Controller {
	public function index() {
		try {
			return new ArticuloCollection(Articulo::where('condicion', '=', true)->where('estado', '!=', 'Malo')->with('orgfinanciero')->with('categoria')->with('archivo')->get());
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
			$folder   = 'home/articulos/fotos/';
			$datos    = json_decode($request['data'], true);
			$fileName = storeImage($request['foto'], $folder);
			if ($fileName) {
				$articulo = [
					'codigo'           => $datos['codigo'],
					'unidad'           => $datos['unidad'],
					'descripcion'      => $datos['descripcion'],
					'costo'            => $datos['costo'],
					'estado'           => $datos['estado'],
					'nombre'           => $datos['nombre'],
					'categoria_id'     => $datos['categoria_id'],
					'orgfinanciero_id' => $datos['orgfinanciero_id'],
				];
				$last_articulo = Articulo::create($articulo)->idArticulo;
				Archivo::create([
					'nombre'      => $fileName,
					'url'         => $folder . $fileName,
					'articulo_id' => $last_articulo,
				]);
				DB::commit();
				return response()->json([
					'success' => true,
					'message' => 'Articulo registrado correctamente',
				], 201);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'El archivo no es una Imagen valida!',
				], 200);
			}
		} catch (\Exception $ex) {
			if ($fileName) {
				deleteImage('home/articulos/fotos/', $fileName);
			}
			DB::rollback();
			return [
				'success' => false,
				'message' => $ex->getMessage(),
			];
		}
	}
	public function show($id) {
		try {
			$articulo = Articulo::where('idArticulo', '=', intval($id))->with('orgfinanciero')->with('categoria')->with('archivo')->first();
			if ($articulo) {
				return new ArticuloResource($articulo);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'El recurso solicitado no existe',
				], 200);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function update(ArticuloUpdateRequest $request, $id) {
		try {
			DB::beginTransaction();
			$articulo = [
				'codigo'           => $request['codigo'],
				'unidad'           => $request['unidad'],
				'descripcion'      => $request['descripcion'],
				'costo'            => $request['costo'],
				'estado'           => $request['estado'],
				'nombre'           => $request['nombre'],
				'categoria_id'     => $request['categoria_id'],
				'orgfinanciero_id' => $request['orgfinanciero_id'],
			];
			Articulo::where('idArticulo', '=', $id)->update($articulo);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Articulo Actualizado correctamente',
			], 201);
		} catch (\Exception $ex) {
			if ($fileName) {
				deleteImage('home/articulos/fotos/', $fileName);
			}
			DB::rollback();
			return [
				'success' => false,
				'message' => $ex->getMessage(),
			];
		}
	}
	public function destroy($id) {
		try {
			$folder   = 'home/articulos/fotos/';
			$articulo = Articulo::find($id);
			if ($articulo) {
				$archivo = Archivo::where('articulo_id', '=', $id)->first();
				deleteImage($folder, $archivo->nombre);
				$articulo->delete();
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
	public function ArticulosReporte() {
		$ldate     = date('Y-m-d H:i:s');
		$articulos = Articulo::where('condicion', '=', true)->where('estado', '!=', 'Malo')->with('orgfinanciero')->with('categoria')->with('archivo')->get();
		$fileName  = "Reporte Articulos" . ' ' . $ldate;
		$pdf       = PDF::loadView('articulos.articulo', array('articulos' => $articulos))->setPaper('letter', 'portrait');
		return $pdf->stream($fileName);
		//  return view('articulos.articulo',array('articulos' => $articulos));
	}
	public function articulosOptions(Request $request) {
		try {
			// return Responsable::with('usuario')->with('servicio')->get();
			return new ArticulosOptionsCollection(Articulo::where('condicion', true)->get());
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
}
