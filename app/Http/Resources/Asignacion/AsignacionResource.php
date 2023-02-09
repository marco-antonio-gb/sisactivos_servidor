<?php
namespace App\Http\Resources\Asignacion;
use Illuminate\Http\Resources\Json\JsonResource;

class AsignacionResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request) {
		return [
			'responsable' => [
				'responsable_id'  => $this->idResponsable,
				'nombre_completo' => $this->usuario->nombres . ' ' . $this->usuario->paterno . ' ' . $this->usuario->materno,
				'cargo'           => $this->usuario->cargo,
				'estado'          => $this->usuario->estado,
				'avatar_letter'   => $this->usuario->avatar_letter,
				'avatar_color'    => $this->usuario->avatar_color,
				'cedula'              => $this->usuario->ci .' '.$this->usuario->ci_ext,
				'telefono'        => $this->usuario->telefono,
				'foto'            => $this->usuario->foto,
				'correo'          => $this->usuario->correo,
			],
			'servicio'=> [
				 'servicio_id'=>$this->servicio->idServicio,
				 'nombre'=>$this->servicio->nombre
			],
			'total_asignaciones'=>$this->asignaciones->count(),
			'historial_asignaciones'=>$this->asignaciones
		];
	}
	public function with($request) {
		return [
			'success' => $this->idAsignacion ? true : false,
		];
	}
}
