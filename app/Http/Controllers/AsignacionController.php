<?php

namespace App\Http\Controllers;

use Request;
use App\Models\Articulo;
use App\Models\Asignacion;
use App\Models\Funcionario;
use App\Models\Responsable;
use Illuminate\Support\Carbon;
use App\Models\DetalleAsignacion;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Asignacion\AsignacionCollection;
use App\Http\Resources\Responsable\ResponsableResource;
use App\Http\Requests\Asignacion\AsignacionStoreRequest;
use App\Http\Requests\Asignacion\AsignacionUpdateRequest;
use App\Http\Resources\DetalleAsignacion\DetalleAsignacionResource;



class AsignacionController extends Controller
{
	public function index()
	{
		try {
			$result = Asignacion::with('responsable')->with('usuario')->with('detalle_asignacion')->first();
			if ($result->isNotEmpty()) {
				return new AsignacionCollection($result);
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
	public function store(AsignacionStoreRequest $request)
	{
		try {
			DB::beginTransaction();
			$usuario      = auth()->user();
			if ($request['asignacion_id']) {
				$asigacion_id = $request['asignacion_id'];
			} else {
				$asignacion = [
					'responsable_id' => $request['responsable_id'],
					'usuario_id'     => $request['usuario_id'],
				];
				$asigacion_id = Asignacion::create($asignacion)->idAsignacion;
			}
			$articulos = $request['articulos'];
			foreach ($articulos as $key => $articulo) {
				$detalle_asignacion = [
					"asignacion_id" => $asigacion_id,
					"articulo_id"   => $articulo['articulo_id'],
					"detalle"       => $articulo['detalle'],
				];
				DetalleAsignacion::create($detalle_asignacion);
				Articulo::where('idArticulo', '=', $articulo['articulo_id'])->update(['asignado' => true]);
				Log::channel('registro_asignaciones')->info('data => ', ['asignacion' => $asignacion, 'detalle_asignacion' => $detalle_asignacion, 'user_login' => ['id' => $usuario->idUsuario, 'nombres' => $usuario->nombres], 'IP' => Request::getClientIp(true)]);
			}
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Asignacion registrado correctamente',
			], 201);
		} catch (\Illuminate\Database\QueryException $ex) {
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
			$result = new DetalleAsignacionResource(Asignacion::with('responsable')->with('usuario')->with('detalle_asignacion')->where('idAsignacion', '=', $id)->first());
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
	public function update(AsignacionUpdateRequest $request, $id)
	{
		try {
			$asignacion = Asignacion::where('idAsignacion', '=', $id)->update($request->all());
			if ($asignacion) {
				return response()->json([
					'success' => true,
					'message' => 'Asignacion Actualizado correctamente',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'La asignacion No se pudo actualizar',
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
		try {
			$detalleAsignaciones = DetalleAsignacion::where('asignacion_id', '=', $id)->get();
			foreach ($detalleAsignaciones as $key => $articulo) {
				Articulo::where('idArticulo', '=', $articulo->articulo_id)->update(['asignado' => true]);
			}
			$asignacion = Asignacion::where('idAsignacion', '=', $id)->delete();
			if ($asignacion) {
				return response()->json([
					'success' => true,
					'message' => 'Servicio eliminado correctamente',
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
	public function AsignacionReporte($idAsignacion)
	{
		try {
			// $asignacion  = new DetalleAsignacionResource(Asignacion::with('responsable')->with('detalle_asignacion')->with('usuario')->where('idAsignacion', '=', $request['asignacion_id'])->first());
			$asignacion = Asignacion::with('responsable')->with('detalle_asignacion')->with('usuario')->where('idAsignacion', '=', $idAsignacion)->first();
			if ($asignacion) {

				$funcionario = Funcionario::where('estado', '=', true)->where('documento', '=', 'asignacion')->first();
				if (!$funcionario) {
					return response()->json([
						'success' => false,
						'message' => "No existe un funcionario seleccionado",
					], 404);
				}
				$printData = [
					'asignacion_id'       => $asignacion->idAsignacion,
					'estado'              => $asignacion->estado,
					'creado'              => Carbon::parse($asignacion->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
					'actualizado'         => Carbon::parse($asignacion->updated_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
					'unidad'              => strtoupper($asignacion->responsable->servicio->nombre),
					'responsable'         => [
						'nombre_completo' => strtoupper($asignacion->responsable->usuario->paterno . ' ' . $asignacion->responsable->usuario->materno . ' ' . $asignacion->responsable->usuario->nombres),
						'cargo'           => strtoupper($asignacion->responsable->usuario->cargo),
						'cedula'          => $asignacion->responsable->usuario->ci . ' ' . $asignacion->responsable->usuario->ci_ext,
						'servicio'        => strtoupper($asignacion->responsable->servicio->nombre),
					],
					'detalle_asignacion'  => $asignacion->detalle_asignacion,
					'responsable_activos' => strtoupper($asignacion->usuario->paterno . ' ' . $asignacion->usuario->materno . ' ' . $asignacion->usuario->nombres),
					'funcionario'         => strtoupper($funcionario->apellidos . ' ' . $funcionario->nombres),
				];
				$time         = time();
				$fileName     = 'Asignacion Individual - ' . $time . '-' . slugify($printData['responsable']['nombre_completo']) . '.pdf';
				$pdf          = PDF::loadView('asignacion.asignacion', array('datos' => $printData))->setPaper('letter', 'landscape');
				$originalPath = '/home/asignaciones/reportes/';
				$urlFile      = public_path() . $originalPath;
				$pdf->save($urlFile . $fileName);
				return $pdf->stream($fileName);
			}
			return response()->json([
				'success' => false,
				'message' => "No se encontro la asignacion",
			], 404);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function HistorialAsignaciones($idResponsable)
	{
		$asignacion     = Responsable::with('asignaciones')->with('servicio')->with('usuario')->whereHas('asignaciones')->where('idResponsable', $idResponsable)->first();
		$historial_data = [
			'asignacion_id'       => $asignacion->idAsignacion,
			'estado'              => $asignacion->estado,
			'creado'              => Carbon::parse($asignacion->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			'actualizado'         => Carbon::parse($asignacion->updated_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			'unidad'              => strtoupper($asignacion->servicio->nombre),
			'responsable'         => [
				'nombre_completo' => strtoupper($asignacion->usuario->paterno . ' ' . $asignacion->usuario->materno . ' ' . $asignacion->usuario->nombres),
				'cargo'           => strtoupper($asignacion->usuario->cargo),
				'cedula'          => $asignacion->usuario->ci . ' ' . $asignacion->usuario->ci_ext,
				'servicio'        => strtoupper($asignacion->servicio->nombre),
			],
			'detalle_asignacion'  => $asignacion->asignaciones,
			'responsable_activos' => strtoupper($asignacion->usuario->paterno . ' ' . $asignacion->usuario->materno . ' ' . $asignacion->usuario->nombres),
		];
		// return $historial_data;
		$time         = time();
		$fileName     = 'Historial Asignaciones - ' . $time . '-' . slugify($historial_data['responsable']['nombre_completo']) . '.pdf';
		$pdf          = PDF::loadView('asignacion.historial_asignaciones', array('datos' => $historial_data))->setPaper('letter', 'landscape');
		$originalPath = '/home/asignaciones/reportes/';
		$urlFile      = public_path() . $originalPath;
		$pdf->save($urlFile . $fileName);
		return $pdf->stream($fileName);
	}
	public function AsignacionesResponsables()
	{
		try {
			$result = Responsable::with('asignaciones')->with('servicio')->with('usuario')->whereHas('asignaciones')->get();
			if ($result->isNotEmpty()) {
				return new AsignacionCollection($result);
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
	public function AsignacionesResponsable($idResponsable)
	{
		try {
			$result = Responsable::with('asignaciones')->with('servicio')->with('usuario')->whereHas('asignaciones')->where('idResponsable', $idResponsable)->first();
			// return $result;
			if ($result) {
				return new ResponsableResource($result);
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
}
