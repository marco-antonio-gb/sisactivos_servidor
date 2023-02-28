<?php

namespace App\Http\Resources\Baja;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BajaResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		return [
			'baja' => [
				'baja_id' => $this->idBaja,
				'creado' => Carbon::parse($this->detalle_baja->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			],
			'articulo' => [
				'articulo_id' => $this->detalle_baja->articulo->idArticulo,
				'nombre' => $this->detalle_baja->articulo->nombre,
				'codigo' => $this->detalle_baja->articulo->codigo,
				'descripcion' => $this->detalle_baja->articulo->descripcion,
				'fecha_registro' => Carbon::parse($this->detalle_baja->articulo->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
				'imagen' => $this->detalle_baja->articulo->archivo->url,
			],
			'detalle_baja' => [
				'detallebaja_id' => $this->detalle_baja->idDetalleBaja,
				'motivo' => $this->detalle_baja->motivo,
				'informebaja' => $this->detalle_baja->informebaja,
				'fecha_hora' => Carbon::parse($this->detalle_baja->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
				'archivo_baja' => $this->detalle_baja->archivo_detalle->url

			],
			'usuario'               => [
				'usuario_id'      => $this->usuario->idUsuario,
				'nombre_completo' => $this->usuario->paterno . ' ' . $this->usuario->materno . ' ' . $this->usuario->nombres,
				'cargo'           => $this->usuario->cargo,
				'estado'          => $this->usuario->estado,
			],
			'responsable'           => [
				'responsable_id'  => $this->responsable->idResponsable,
				'nombre_completo' => $this->responsable->usuario->paterno . ' ' . $this->responsable->usuario->materno . ' ' . $this->responsable->usuario->nombres,
				'cargo'           => $this->responsable->usuario->cargo,
				'estado'          => $this->responsable->usuario->estado,
			],
			// 'detalle_baja' => $this->detalle_baja,

		];
	}
	public function with($request)
	{
		return [
			'success' => $this->idBaja ? true : false,
		];
	}
}
