<?php

namespace App\Http\Resources\Responsable;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponsableResource extends JsonResource
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
			'responsable' => [
				'responsable_id'     => $this->idResponsable,
				'responsable_estado' => $this->condicion,
				'asignado'           => Carbon::parse($this->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
				'nombre_completo'    => $this->usuario->nombres . ' ' . $this->usuario->paterno . ' ' . $this->usuario->materno,
				'cargo'              => $this->usuario->cargo,
				'usuario_estado'     => $this->usuario->estado,
				'avatar_letter'      => $this->usuario->avatar_letter,
				'avatar_color'       => $this->usuario->avatar_color,
				'cedula'             => $this->usuario->ci . ' ' . $this->usuario->ci_ext,
				'telefono'           => $this->usuario->telefono,
				'foto'               => $this->usuario->foto,
				'correo'             => $this->usuario->correo,
			],
			'servicio'    => [
				'servicio_id' => $this->servicio->idServicio,
				'nombre'      => $this->servicio->nombre,
			],
			'total_asignaciones' => $this->asignaciones->count(),
			'historial_asignaciones' => $this->asignaciones
		];
	}
	public function with($request)
	{
		return [
			'success' => $this->idContacto ? true : false,
		];
	}
}
