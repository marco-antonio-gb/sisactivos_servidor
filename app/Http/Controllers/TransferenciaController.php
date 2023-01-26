<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transferencia;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleTransferencia;
use App\Http\Resources\Transferencia\TransferenciaResource;
use App\Http\Resources\Transferencia\TransferenciaCollection;
use App\Http\Requests\Transferencia\TransferenciaStoreRequest;

class TransferenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new TransferenciaCollection(Transferencia::with('responsable')->with('detalle_transferencia')->get());
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
    public function store(TransferenciaStoreRequest $request)
    {
        try {
			DB::beginTransaction();
            $transferencia=[
                "responsable_id"=>$request['responsable_id'],
                "usuario_id"=>$request['usuario_id'],
            ];
            $last_transferencia_id= Transferencia::create($transferencia)->idTransferencia;
            $detalle_transferencia=[
                "detalle"=>$request['detalle'],
                "transferencia_id"=>$last_transferencia_id,
                "articulo_id"=>$request['articulo_id']
            ];
            DetalleTransferencia::create($detalle_transferencia);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Transferencia registrado correctamente',
			], 201);
		} catch (\Exception $ex) {
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
    public function show($id)
    {
        try {
			$result = Transferencia::with('responsable')->where('idTransferencia', '=', $id)->first();
			if ($result) {
                return new TransferenciaResource($result);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
