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
			'detalleasignacion_id' => $this->idDetalleAsignacion,
			'detalle'        => $this->detalle,
			'fecha_hora'     => Carbon::parse($this->fecha_hora, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
            'asignacion'     => $this->asignacion,
            'articulo'       => $this->articulo
			// 'usuario'        => [
			// 	'usuario_id'      => $this->usuario->idUsuario,
			// 	'nombre_completo' => $this->usuario->nombres . ' ' . $this->usuario->paterno . ' ' . $this->usuario->materno,
			// 	'foto'            => $this->usuario->foto,
			// 	'cedula'          => $this->usuario->ci . ' ' . $this->usuario->ci_ext,
			// 	'cargo'           => $this->usuario->cargo,
			// 	'correo'          => $this->usuario->correo,
			// 	'estado'          => $this->usuario->estado,
			// ],
			// 'responsable'       => [
			// 	'responsable_id' => $this->responsable->idResponsable,
			// 	'nombre_completo' => $this->responsable->usuario->nombres . ' ' . $this->responsable->usuario->paterno . ' ' . $this->responsable->usuario->materno,
			// 	'foto'            => $this->responsable->usuario->foto,
			// 	'cedula'          => $this->responsable->usuario->ci . ' ' . $this->responsable->usuario->ci_ext,
			// 	'cargo'           => $this->responsable->usuario->cargo,
			// 	'correo'          => $this->responsable->usuario->correo,
			// 	'estado'          => $this->responsable->usuario->estado,
			// ],
		];
	}
	public function with($request) {
		return [
			'success' => $this->idAsignacion ? true : false,
		];
	}
}
