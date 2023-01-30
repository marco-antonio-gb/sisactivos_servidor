<?php

namespace App\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'funcionario_id'  => $this->idFuncionario,
			'nombre_completo' => $this->apellidos . ' ' . $this->nombres,
			'cedula'          => $this->ci . ' ' . $this->ci_ext,
			'estado'          => $this->estado,
			'cargo'           => $this->cargo,
			'documento'       => $this->documento,
		];
	}
	public function with($request) {
		return [
			'success' => $this->idFuncionario ? true : false,
		];
	}
}
