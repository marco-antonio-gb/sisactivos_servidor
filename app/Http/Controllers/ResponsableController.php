<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Servicio;
use App\Models\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Responsable\ResponsableCollection;
use App\Http\Requests\Responsable\ResponsableStoreRequest;
use App\Http\Requests\Responsable\ResponsableUpdateRequest;
use App\Http\Resources\Responsable\ResponsableOptionsCollection;
use App\Http\Resources\Responsable\UsuariosOptionCollection;
use App\Http\Resources\Responsable\UsuariosOptionResource;

class ResponsableController extends Controller
{
	public function index()
	{
		try {
			// $result = Responsable::with('asignaciones')->with('servicio')->with('usuario')->whereHas('asignaciones')->get();
			$result = Responsable::with('servicio')->with('usuario')->get();
			if ($result->isNotEmpty()) {
				return new ResponsableCollection($result);
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
			$usuario      = auth()->user();
			$responsable = [
				'usuario_id'  => $request->get('usuario_id'),
				'servicio_id' => $request->get('servicio_id'),
			];
			Responsable::create($responsable);
			Log::channel('registro_responsables')->info('data => ', ['responsable' => $responsable, 'user_login' => ['id' => $usuario->idUsuario, 'nombres' => $usuario->nombres], 'IP' => \Request::getClientIp(true)]);
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
			$result = Responsable::with('servicio')->with('usuario')->where('idResponsable', $id)->first();
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
			$responsable = [
				'usuario_id'  => $request->get('usuario_id'),
				'servicio_id' => $request->get('servicio_id'),
			];
			$update = Responsable::where('idResponsable', '=', $id)->update($responsable);
			if ($update) {
				return response()->json([
					'success' => true,
					'message' => 'Responsable Actualizado correctamente',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'El Responsable No se pudo actualizar',
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
			Responsable::where('idResponsable', '=', $id)->delete();
			return response()->json([
				'success' => true,
				'message' => 'Responsable eliminado correctamente',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	/**
	 *
	 *  ------------------
	 *
	 */
	public function ResponsablesOptions()
	{
		try {
			return new ResponsableOptionsCollection(Responsable::with('usuario')->with('servicio')->where('condicion', true)->get());
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function Usuarios()
	{
		try {
			$usuarios = Usuario::query()->where('estado', '=', true)->doesnthave('responsable')->get();
			return new UsuariosOptionCollection($usuarios);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function Servicios()
	{
		try {
			$servicios = Servicio::select('idServicio AS servicio_id', 'nombre')->where('condicion', '=', true)->get();
			return response()->json([
				'success' => true,
				'data'    => $servicios,
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function bajaResponsable($id)
	{
		try {
			$currentStatus = Responsable::find($id);
			$responsable   = Responsable::where('idResponsable', '=', $id)->update(['condicion' => !$currentStatus->condicion]);
			$estado        = $currentStatus->condicion ? 'baja' : 'alta';
			if ($responsable) {
				return response()->json([
					'success' => true,
					'message' => 'El responsable fue dado de ' . $estado . ' correctamente',
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
	public function CambiarServicios(Request $request)
	{
		try {
			$responsable = Responsable::find($request['responsable_id']);
			if ($responsable) {
				$status      = $responsable->condicion;
				if ($status) {
					$responsable->update(['servicio_id' => $request['servicio_id']]);
					return response()->json([
						'success' => true,
						'message' => 'Servicio cambiado  correctamente',
					], 201);
				}
				return response()->json([
					'success' => false,
					'message' => 'El Responsable esta desactivado.',
				], 201);
			}
			return response()->json([
				'success' => false,
				'message' => 'El recurso solicitado no se puedo encontrar.',
			], 201);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
}
