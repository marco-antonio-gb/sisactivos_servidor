<?php

namespace App\Http\Resources\Articulo;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticulosOptionsResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'articulo_id' => $this->idArticulo,
			'asignado'      => $this->asignado,
			'foto'        => $this->archivo->url,
			'descripcion' => $this->descripcion,
			'nombre'      => $this->nombre,
			'codigo'      => $this->codigo,
		];
	}
	public function with($request) {
		return [
			'success' => $this->idResponsable ? true : false,
		];
	}
}
