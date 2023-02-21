<?php

namespace App\Http\Resources\Baja;

use Illuminate\Http\Resources\Json\JsonResource;

class BajaArticuloResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
		return [
			 'articulo_id'=>$this->idArticulo,
             'articulo_nombre'=>$this->nombre,
             'articulo_descripcion'=>$this->descripcion,
             'articulo_asignado'=>$this->asignado,
             'articulo_baja'=>$this->baja,
             'articulo_codigo'=>$this->codigo,
             'articulo_estado'=>$this->estado,
             'articulo_foto'=>$this->archivo->url,
             'asignacion_id'=>$this->detalle_asignacion->asignacion_id,
             'responsable_id'=>$this->detalle_asignacion->asignacion->responsable->idResponsable,
             'responsable_nombre'=>$this->detalle_asignacion->asignacion->responsable->usuario->nombres.' '.             $this->detalle_asignacion->asignacion->responsable->usuario->paterno.' '.
             $this->detalle_asignacion->asignacion->responsable->usuario->materno
		];
	}
	public function with($request) {
		return [
			'success' => $this->idArticulo ? true : false,
		];
	}
}
