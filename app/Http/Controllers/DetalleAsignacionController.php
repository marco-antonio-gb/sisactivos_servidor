<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleAsignacion;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DetalleAsignacion\DetalleAsignacionCollection;
use App\Http\Requests\DetalleAsignacion\StoreDetalleAsignacionRequest;
use Illuminate\Database\QueryException;

class DetalleAsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
			// return DetalleAsignacion::with('asignacion')->with('articulo')->get();
			return new DetalleAsignacionCollection(DetalleAsignacion::with('asignacion')->with('articulo')->get());
			if ($result->isNotEmpty()) {
				return response()->json([
					'success' => true,
					'data'    => $result,
				], 200);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetalleAsignacionRequest $request)
    {
        try {
			DB::beginTransaction();
            $det_asignacion=[
                "detalle" => $request['detalle'],
                "asignacion_id" => $request['asignacion_id'],
                "articulo_id" => $request['articulo_id']
            ];
			$user = DetalleAsignacion::create($det_asignacion);
			DB::commit();
			return response()->json([
				'success' => true,
				'message' => 'Detalle Asignacion registrado correctamente',
			], 201);
		} catch(QueryException   $ex) {
			DB::rollback();
			return [
				'successsssssss' => false,
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
        //
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
