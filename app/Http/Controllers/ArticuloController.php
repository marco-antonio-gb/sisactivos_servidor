<?php
namespace App\Http\Controllers;
use App\Models\Archivo;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Http\Requests\ArticuloStoreRequest;
class ArticuloController extends Controller {
	public function index() {
		try {
			$result = Articulo::with('orgfinanciero')->with('categoria')->get();
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
            $folder = 'home/articulos/fotos/';
			$datos     = json_decode($request['data'], true);
            $fileName = storeImage($request['imagen'], $folder);
			$articulo  = [
				'codigo'           => $datos['codigo'],
				'unidad'           => $datos['unidad'],
				'descripcion'      => $datos['descripcion'],
				'imagen'           => $fileName,
				'costo'            => $datos['costo'],
				'estado'           => $datos['estado'],
				'nombre'           => $datos['nombre'],
				'categoria_id'     => $datos['categoria_id'],
				'orgfinanciero_id' => $datos['orgfinanciero_id'],
			];
			Articulo::create($articulo);
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
            $folder = 'home/articulos/fotos/';

			$articulo = Articulo::find($id);
			if ($articulo) {
                deleteImage($folder, $articulo->imagen);
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

    public function ArticulosReporte(){
        $articulos=Articulo::all();
        $fileName="Reporte Articulos";
        $pdf          = PDF::loadView('articulos.articulo', array('articulos' => $articulos))->setPaper('letter', 'portrait');
        return $pdf->stream($fileName);
        //  return view('articulos.articulo',array('articulos' => $articulos));
    }
}
