<?php

namespace App\Http\Resources\DetalleAsignacion;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class DetalleAsignacionResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'asignacion_id'       => $this->idAsignacion,
			'estado'              => $this->estado,
			'creado'              => Carbon::parse($this->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			'actualizado'         => Carbon::parse($this->updated_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			'unidad'              => strtoupper($this->responsable->servicio->nombre),
			'responsable'         => [
				'nombre_completo' => strtoupper($this->responsable->usuario->paterno . ' ' . $this->responsable->usuario->materno . ' ' . $this->responsable->usuario->nombres),
				'cargo'           => strtoupper($this->responsable->usuario->cargo),
				'cedula'          => $this->responsable->usuario->ci . ' ' . $this->responsable->usuario->ci_ext,
				'servicio'        => strtoupper($this->responsable->servicio->nombre),
			],
			'detalle_asignacion'  => $this->detalle_asignacion,
			'responsable_activos' => strtoupper($this->usuario->paterno . ' ' . $this->usuario->materno . ' ' . $this->usuario->nombres),

		];
	}

}
