<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use App\Models\OrgFinanciero;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Articulo\ArticuloResource;
use App\Http\Resources\Articulo\ArticuloCollection;
use App\Http\Requests\Articulo\ArticuloStoreRequest;
use App\Http\Requests\Articulo\ArticuloUpdateRequest;
use App\Http\Resources\Articulo\ArticulosOptionsCollection;

class ArticuloController extends Controller
{
	public function index()
	{
		try {
			return new ArticuloCollection(Articulo::where('baja', '=', false)->with('orgfinanciero')->with('categoria')->with('archivo')->get());
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function store(ArticuloStoreRequest $request)
	{
		try {
			DB::beginTransaction();
			$folder   = 'home/articulos/fotos/';
			$datos    = json_decode($request['data'], true);
			$fileName = storeImage($request['foto'], $folder);
			$usuario      = auth()->user();
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
				Log::channel('registro_articulos')->info('data => ', ['articulo' => $articulo, 'user_login' => ['id' => $usuario->idUsuario, 'nombres' => $usuario->nombres], 'IP' => \Request::getClientIp(true)]);
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
	public function show($id)
	{
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
	public function update(ArticuloUpdateRequest $request, $id)
	{
		try {
			DB::beginTransaction();
			$fileName = "";
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
	public function destroy($id)
	{
		try {
			$folder   = 'home/articulos/fotos/';
			$articulo = Articulo::find($id);
			if ($articulo) {
				#Para borrar la imagen del articulo
				// $archivo = Archivo::where('articulo_id', '=', $id)->first();
				// deleteImage($folder, $archivo->nombre);
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
	public function ArticulosReporte()
	{
		try {
			$time         = date("d-m-Y") . "-" . time();
			$fileName     = "Reporte Articulos" . ' ' . $time . '.pdf';
			$originalPath = '/home/articulos/reportes/';
			$urlFile      = public_path() . $originalPath;
			$articulos = Articulo::where('estado', '!=', 'Malo')->with('orgfinanciero')->with('categoria')->with('archivo')->get();
			if (count($articulos) > 0) {
				$funcionarios = Funcionario::where('documento', '=', 'articulos')->where('estado', '=', true)->limit(4)->get();
				if (count($funcionarios) > 0) {
					foreach ($funcionarios as $key => $funcionario) {
						$funcionarios_data[] = ['fun' . $key + 1 => strtoupper($funcionario['nombres']) . ' ' . strtoupper($funcionario['apellidos'])];
					}
					$pdf = PDF::loadView('articulos.articulo', array('articulos' => $articulos, 'funcionarios' => $funcionarios_data))->setPaper('letter', 'portrait');
					$pdf->save($urlFile . $fileName);
					return $pdf->stream($fileName);
				}
				return response()->json([
					'success' => false,
					'message' => "No existen funcionarios registrados",
				], 404);
			}
			return response()->json([
				'success' => false,
				'message' => 'No existen articulos registrados',
			], 404);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function articulosOptions(Request $request)
	{
		try {
			return new ArticulosOptionsCollection(Articulo::where('asignado', false)->get());
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
}
