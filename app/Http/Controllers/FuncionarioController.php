<?php
namespace App\Http\Controllers;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\FuncionarioService;
use App\Http\Resources\Funcionario\FuncionarioResource;
use App\Http\Resources\Funcionario\FuncionarioCollection;
use App\Http\Requests\Funcionario\FuncionarioStoreRequest;
use App\Http\Requests\Funcionario\FuncionarioUpdateRequest;
use App\Http\Resources\Funcionario\FuncionarioShowResource;
class FuncionarioController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$result = Funcionario::all();
			if (count($result) > 0) {
				return new FuncionarioCollection($result);
			} else {
				return response()->json([
					'success' => false,
					'message' => "No existen resultados",
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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(FuncionarioStoreRequest $request, FuncionarioService $funcionarioService) {
		try {
			$funcionario=$funcionarioService->createFuncionario($request);
			return response()->json([
				'success' => true,
				'message' => 'Funcionario registrado correctamente',
			], 201);
		} catch (\Exception $ex) {
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
			$result = Funcionario::findOrFail($id);
			return response()->json([
				'success' => true,
				'data'    => new FuncionarioShowResource($result),
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => "El recurso no existe",
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
	public function update(FuncionarioUpdateRequest $request, $id) {
		try {
			DB::beginTransaction();
			$funcionario = [
				'apellidos' => $request->get('apellidos'),
				'nombres'   => $request->get('nombres'),
				'ci'        => $request->get('ci'),
				'ci_ext'    => $request->get('ci_ext'),
				'cargo'     => $request->get('cargo'),
				'documento' => $request->get('documento'),
			];
			Funcionario::where('idFuncionario', '=', $id)->update($funcionario);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Funcionario actualizado correctamente',
			], 201);
		} catch (\Exception $ex) {
			DB::rollback();
			return [
				'success' => false,
				'message' => $ex->getMessage(),
			];
		}
	}
	public function destroy($id) {
		DB::beginTransaction();
        try {
            $funcionario = Funcionario::find($id);
            if(!$funcionario) return response()->json(['message' => 'No se encontro el recurso solicitado','success' => false], 404);
            $funcionario->delete();
            DB::commit();
            return response()->json(['message' => 'Registro eliminado correctamente','success' => true], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage(),'success' => false], 500);
        }
	}
	public function StatusFuncionario(Request $request){
		try {
			$currentStatus  = Funcionario::where('idFuncionario','=',$request['funcionario_id'])->first();
			$currentStatus->update(['estado'=>!$request['status']]);
			return response()->json([
				'success' => true,
				'message' => "El estado del funcionario ha cambiado",
			], 200);
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => "No se puede encontrar al funcionario",
			], 404);
		}
	}
}
