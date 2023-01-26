<?php
namespace App\Http\Resources\Baja;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
class BajaResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'baja_id'               => $this->idBaja,
			'estado'                => $this->estado,
			'usuario'               => [
				'usuario_id'      => $this->usuario->idUsuario,
				'nombre_completo' => $this->usuario->paterno . ' ' . $this->usuario->materno . ' ' . $this->usuario->nombres,
				'cargo'           => $this->usuario->cargo,
				'estado'          => $this->usuario->estado,
			],
			'responsable'           => [
				'responsable_id'  => $this->responsable->idResponsable,
				'nombre_completo' => $this->responsable->usuario->paterno . ' ' . $this->responsable->usuario->materno . ' ' . $this->responsable->usuario->nombres,
				'cargo'           => $this->responsable->usuario->cargo,
				'estado'          => $this->responsable->usuario->estado,
			],
			'detalle_baja' => $this->detalle_baja,
		];
	}
	public function with($request) {
		return [
			'success' => $this->idBaja ? true : false,
		];
	}
}
