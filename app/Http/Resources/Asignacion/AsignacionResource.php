<?php
namespace App\Http\Resources\Asignacion;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
class AsignacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
		return [
			'asignacion_id' => $this->idAsignacion,
			'estado'         => $this->estado,
			'asignado'       => Carbon::parse($this->created_at, 'America/La_Paz')->translatedFormat('l, j \d\e F \d\e\l Y, H:i:s'),
			'usuario'        => [
				'usuario_id'      => $this->usuario->idUsuario,
				'nombre_completo' => $this->usuario->paterno . ' ' . $this->usuario->materno . ' ' . $this->usuario->nombres,
				'cargo'           => $this->usuario->cargo,
				'estado'          => $this->usuario->estado,
			],
			'responsable'       => [
				'responsable_id' => $this->responsable->idResponsable,
				'nombre_completo' => $this->responsable->usuario->paterno . ' ' . $this->responsable->usuario->materno . ' ' . $this->responsable->usuario->nombres,
				'cargo'           => $this->responsable->usuario->cargo,
				'estado'          => $this->responsable->usuario->estado,
			],
			'detalle_asignancion_count'=>$this->detalle_asignacion->count()
		];
	}
	public function with($request) {
		return [
			'success' => $this->idAsignacion ? true : false,
		];
	}
}
