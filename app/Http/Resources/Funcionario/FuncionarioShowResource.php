<?php

namespace App\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
		return [
			'funcionario_id' => $this->idFuncionario,
			'nombres'        => $this->nombres,
			'apellidos'      => $this->apellidos,
			'ci'             => $this->ci,
			'ci_ext'         => $this->ci_ext,
			'estado'         => $this->estado,
			'cargo'          => $this->cargo,
			'documento'      => $this->documento,
		];
	}
	public function with($request) {
		return [
			'success' => $this->idFuncionario ? true : false,
		];
	}
}
