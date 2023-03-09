<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Models\Articulo;
use App\Models\DetalleBaja;
use App\Models\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ArchivosDetalleBaja;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Baja\BajaResource;
use App\Http\Resources\Baja\BajaCollection;
use App\Http\Resources\Baja\BajaArticuloCollection;

class BajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $result = Baja::with('usuario')->with('responsable')->with('detalle_baja')->get();
            if ($result->isNotEmpty()) {
                return new BajaCollection($result);
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
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $usuario      = auth()->user();
            $datos     = json_decode($request['data'], true);
            $folder = 'home/bajas/archivos/';
            $imageName = "";
            if ($request->hasFile('archivo')) {

                $imageName = storageAnotherFile($request['archivo'], $folder);
            }
            $baja       = [
                'responsable_id' => $datos['baja']['responsable_id'],
                'usuario_id'     => $usuario->idUsuario,
            ];
            $last_baja_id = Baja::create($baja)->idBaja;
            $detalle_baja = [
                'baja_id'     => $last_baja_id,
                'articulo_id' => $datos['detalle_baja']['articulo_id'],
                'motivo'      => $datos['detalle_baja']['motivo'],
                'informebaja' => $datos['detalle_baja']['informebaja'],
            ];
            DetalleBaja::create($detalle_baja);
            Articulo::where('idArticulo', '=', $datos['detalle_baja']['articulo_id'])->update(['estado' => 'Malo', 'baja' => true]);
            if ($last_baja_id) {

                ArchivosDetalleBaja::create([
                    'nombre' => $imageName,
                    'url' => $folder . $imageName,
                    'detallebaja_id' => $last_baja_id
                ]);
            }
            DB::commit();
            Log::channel('registro_bajas')->info('data => ', ['baja' => $baja, 'detalle_baja' => $detalle_baja, 'user_login' => ['id' => $usuario->idUsuario, 'nombres' => $usuario->nombres], 'IP' => \Request::getClientIp(true)]);
            return response()->json([
                'success' => true,
                'message' => 'Articulo dado de Baja correctamente',
            ], 201);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            deleteImage($folder, $imageName);
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
            $result = Baja::where('idBaja', $id)->with('usuario')->with('responsable')->with('detalle_baja')->first();

            if ($result) {
                return new BajaResource($result);
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
    public function getArticuloResponsable(Request $request)
    {
        try {
            $articulo      = Articulo::where('idArticulo', $request['idArticulo'])->with('archivo')->first();
            $responsable   = Responsable::with('usuario')->where('idResponsable', $request['idResponsable'])->first();
            $response_data = [
                'articulo_id'           => $articulo->idArticulo,
                'articulo_codigo'       => $articulo->codigo,
                'articulo_nombre'       => $articulo->nombre,
                'articulo_descripcion'  => $articulo->descripcion,
                'articulo_foto'         => $articulo->archivo->url,
                'responsable_id'        => $responsable->idResponsable,
                'responsable_full_name' => $responsable->usuario->nombres . ' ' . $responsable->usuario->paterno . ' ' . $responsable->usuario->materno,
                'responsable_cedula'    => $responsable->usuario->ci . ' ' . $responsable->usuario->ci_ext,
            ];
            return response()->json([
                'success' => true,
                'data'    => $response_data,
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage(),
            ];
        }
    }
    public function ArticulosBaja()
    {
        try {
            $result = Articulo::whereHas('detalle_asignacion')->get();
            if (count($result) > 0) {
                return new BajaArticuloCollection($result);
            }
            return response()->json([
                'success' => false,
                'message' => "No existen registros",
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage(),
            ];
        }
    }
    public function BajaReporte($idBaja)
    {
        try {

            $result = Baja::where('idBaja', $idBaja)->with('usuario')->with('responsable')->with('detalle_baja')->first();
            return $result;
            if ($result) {


                $printData = [
                    'baja' => [
                        'baja_id' => $idBaja,
                        'creado' => Carbon::parse($result->detalle_baja->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
                    ],
                    'articulo' => [
                        'articulo_id' => $result->detalle_baja->articulo->idArticulo,
                        'nombre' => $result->detalle_baja->articulo->nombre,
                        'codigo' => $result->detalle_baja->articulo->codigo,
                        'descripcion' => $result->detalle_baja->articulo->descripcion,
                        'fecha_registro' => Carbon::parse($result->detalle_baja->articulo->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
                        'imagen' => $result->detalle_baja->articulo->archivo->url,
                    ],
                    'detalle_baja' => [
                        'detallebaja_id' => $result->detalle_baja->idDetalleBaja,
                        'motivo' => $result->detalle_baja->motivo,
                        'informebaja' => $result->detalle_baja->informebaja,
                        'fecha_hora' => Carbon::parse($result->detalle_baja->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
                        'archivo_baja' => $result->detalle_baja->archivo_detalle->url

                    ],
                    'usuario'               => [
                        'usuario_id'      => $result->usuario->idUsuario,
                        'nombre_completo' => $result->usuario->paterno . ' ' . $result->usuario->materno . ' ' . $result->usuario->nombres,
                        'cargo'           => $result->usuario->cargo,
                        'estado'          => $result->usuario->estado,
                    ],
                    'responsable'           => [
                        'responsable_id'  => $result->responsable->idResponsable,
                        'nombre_completo' => $result->responsable->usuario->paterno . ' ' . $result->responsable->usuario->materno . ' ' . $result->responsable->usuario->nombres,
                        'cargo'           => $result->responsable->usuario->cargo,
                        'estado'          => $result->responsable->usuario->estado,
                    ],
                ];
                $time         = time();
                $fileName     = 'Reporte baja de Articulo - ' . $time . '-' . slugify($printData['articulo']['nombre']) . '.pdf';
                $pdf          = PDF::loadView('bajas.reporte_baja', array('datos' => $printData))->setPaper('letter', 'landscape');
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
}
