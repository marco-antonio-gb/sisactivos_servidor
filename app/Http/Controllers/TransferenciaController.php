<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transferencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $usuario   = auth()->user();
            $transferencia = [
                "responsable_id" => $request['transferencia']['responsable_id'],
                "usuario_id"     => $usuario->idUsuario,
            ];
            $last_transferencia_id = Transferencia::create($transferencia)->idTransferencia;
            $detalle_transferencia = [
                "transferencia_id" => $last_transferencia_id,
                "detalle"          => $request['detalle_transferencia']['detalle'],
                "articulo_id"      => $request['detalle_transferencia']['articulo_id'],
            ];
            DetalleTransferencia::create($detalle_transferencia);
            DB::commit();
            Log::channel('registro_transferencias')->info('data => ', ['transferencia' => $transferencia, 'detalle_transferencia' => $detalle_transferencia, 'user_login' => ['id' => $usuario->idUsuario, 'nombres' => $usuario->nombres], 'IP' => \Request::getClientIp(true)]);
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
