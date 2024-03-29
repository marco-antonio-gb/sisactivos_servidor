<?php

namespace App\Http\Resources\Transferencia;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferenciaResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'transferencia_id' => $this->idTransferencia,
			'estado'           => $this->estado,
			'fecha_hora'       => Carbon::parse($this->fecha_hora, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			'usuario'        => [
                'usuario_id'      => $this->usuario->idUsuario,
                'nombre_completo' => $this->usuario->paterno . ' ' . $this->usuario->materno . ' ' . $this->usuario->nombres,
                // 'foto'            => $this->usuario->foto,
                // 'cedula'          => $this->usuario->ci . ' ' . $this->usuario->ci_ext,
                'cargo'           => $this->usuario->cargo,
                // 'correo'          => $this->usuario->correo,
                'estado'          => $this->usuario->estado,
            ],
            'responsable'       => [
                'responsable_id' => $this->responsable->idResponsable,
                'nombre_completo' => $this->responsable->usuario->paterno . ' ' . $this->responsable->usuario->materno . ' ' . $this->responsable->usuario->nombres,
                // 'foto'            => $this->responsable->usuario->foto,
                // 'cedula'          => $this->responsable->usuario->ci . ' ' . $this->responsable->usuario->ci_ext,
                'cargo'           => $this->responsable->usuario->cargo,
                // 'correo'          => $this->responsable->usuario->correo,
                'estado'          => $this->responsable->usuario->estado,
            ],
			'detalle_transferencia'=>$this->detalle_transferencia,

		];
	}
	public function with($request) {
		return [
			'success' => $this->idTransferencia ? true : false,
		];
	}
}
