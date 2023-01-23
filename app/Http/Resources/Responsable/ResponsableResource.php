<?php

namespace App\Http\Resources\Responsable;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ResponsableResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'responsable_id' => $this->idResponsable,
			'estado'         => $this->condicion,
			'asignado'       => Carbon::parse($this->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			'usuario'        => [
				'usuario_id'      => $this->usuario->idUsuario,
				'nombre_completo' => $this->usuario->paterno . ' ' . $this->usuario->materno . ' ' . $this->usuario->nombres,
				'foto'            => $this->usuario->foto,
				'cedula'          => $this->usuario->ci . ' ' . $this->usuario->ci_ext,
				'cargo'           => $this->usuario->cargo,
				'correo'          => $this->usuario->correo,
				'estado'          => $this->usuario->estado,
			],
			'servicio'       => [
				'servicio_id' => $this->servicio->idServicio,
				'nombre'      => $this->servicio->nombre,
			],
		];
	}
	public function with($request) {
		return [
			'success' => $this->idContacto ? true : false,
		];
	}
}
