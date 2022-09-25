<?php
namespace App\Http\Controllers;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Persona\StorePersona;
use App\Http\Requests\Persona\UpdatePersona;

class PersonaController extends Controller {
 
	public function index() {
		try {
			$resultado = Persona::select('idPersona', DB::raw("CONCAT(IFNULL(paterno,''),' ',IFNULL(materno,''),' ',IFNULL(nombres,'')) AS full_name"), DB::raw("CONCAT(IFNULL(ci,''),' ',IFNULL(ci_ext,'')) AS cedula"), 'celular', 'direccion', 'correo')
			// ->with(array('empresas' => function ($query) {$query->select('idEmpresa', 'razon_social');}))
			// ->with(array('tipo' => function ($query) {$query->select('idTipoPersona', 'nombre');}))
				->get();
			if (!$resultado->isEmpty()) {
				return response()->json([
					'data'    => $resultado,
					'success' => true,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No existen personas registradas',
				], 200);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function store(StorePersona $request) {

        return $request->all();
		try {
			DB::beginTransaction();
			$persona = [
				'nombres'      => $request['nombres'],
				'paterno'      => $request['paterno'],
				'materno'      => $request['materno'],
				'ci'           => $request['ci'],
				'ci_ext'       => $request['ci_ext'],
				'direccion'    => $request['direccion'],
				'celular'      => $request['celular'],
				'estado_civil' => $request['estado_civil'],
				'correo'       => $request['correo'],
				'fec_nac'      => $request['fec_nac'],
				'genero'       => $request['genero'],
				'foto'         => $request['foto'],
			];
			Persona::create($persona);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Persona registrada correctamente',
			], 201);
		} catch (\Exception $ex) {
			DB::rollback();
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function show($id) {
		try {
			$persona = Persona::where('idPersona', '=', $id)->first();
			if ($persona) {
				return response()->json([
					'success' => true,
					'data'    => $persona,
				], 200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No se encontro ningun registro',
				]);
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function update(UpdatePersona $request, $id) {
		try {
			DB::beginTransaction();
			$persona = [
				'nombres'      => $request['nombres'],
				'paterno'      => $request['paterno'],
				'materno'      => $request['materno'],
				'ci'           => $request['ci'],
				'ci_ext'       => $request['ci_ext'],
				'direccion'    => $request['direccion'],
				'celular'      => $request['celular'],
				'estado_civil' => $request['estado_civil'],
				'correo'       => $request['correo'],
				'fec_nac'      => $request['fec_nac'],
				'genero'       => $request['genero'],
				'foto'         => $request['foto'],
			];
			Persona::where('idPersona', '=', $id)->update($persona);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Registrado actualizado correctamente',
			], 201);
		} catch (\Exception $ex) {
			DB::rollback();
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	public function destroy($id) {
		try {
			$persona = Persona::find($id);
			if (empty($persona)) {
				return response()->json([
					'success' => false,
					'message' => 'No se encontro el registro solicitado',
				], 404);
			}
			$deleted = $persona->delete($id);
			if (!$deleted) {
				return response()->json([
					'success' => false,
					'message' => 'No se pudo eliminar el registro',
				], 404);
			}
			return response()->json([
				'success' => true,
				'message' => 'Regsitro eliminado correctamente',
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
     * 
     * 
     * 
     */
 
     public function VerificarCi(Request $request) {
		try {
			$column     = $request['column'];
			$idPersona = $request['idPersona'];
			if ($column === 'ci') {
				$ci       = $request['ci'];
				$exist_ci = $this->check_ci($ci, $idPersona);
				if ($exist_ci) {
					return response()->json([
						'success' => false,
					], 201);
				} else {
					return response()->json([
						'success' => true,
					], 201);
				}
			}
		} catch (\Exception $ex) {
			return response()->json([
				'success' => false,
				'message' => $ex->getMessage(),
			], 404);
		}
	}
	private function check_ci($ci, $idPersona) {
		if (!$idPersona) {
			return Persona::where('ci', 'LIKE BINARY', $ci)->first();
		} else {
			return Persona::where('ci', 'LIKE BINARY', $ci)->whereNotIn('idPersona', [$idPersona])->first();
		}
	}
}
