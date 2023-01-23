<?php

namespace App\Http\Resources\Responsable;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ResponsableOptionsResource extends JsonResource
{
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
            'nombre_completo'=>$this->usuario->paterno . ' ' . $this->usuario->materno . ' ' . $this->usuario->nombres,
		];
	}
	public function with($request) {
		return [
			'success' => $this->idResponsable ? true : false,
		];
	}
}
