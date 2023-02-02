<?php

namespace App\Http\Resources\Articulo;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ArticuloResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'articulo_id'      => $this->idArticulo,
			'codigo'           => $this->codigo,
			'unidad'           => $this->unidad,
			'nombre'           => $this->nombre,
			'descripcion'      => $this->descripcion,
			'estado'           => $this->estado,
			'costo'            => $this->costo,
			'condicion'        => $this->condicion,
			'creado'           => $this->created_at,
			'actualizado'      => $this->updated_at,
			'fecha_registro'   => $this->fecha_registro,
			'foto'             => $this->archivo->url,
			'categoria_id'     => $this->categoria_id,
			'orgfinanciero_id' => $this->orgfinanciero_id,
			'orgfinanciero'    => [
				'orgfinanciero_id' => $this->orgfinanciero->idOrgfinanciero,
				'nombre'           => $this->orgfinanciero->nombre,
			],
			'categoria'        => [
				'categoria_id' => $this->categoria->idCategoria,
				'nombre'       => $this->categoria->nombre,
				'vida_util'    => $this->categoria->vida_util,
				'descripcion'  => $this->categoria->descripcion,
			],
		];
	}
	public function with($request) {
		return [
			'success' => $this->idArticulo ? true : false,
		];
	}
}
