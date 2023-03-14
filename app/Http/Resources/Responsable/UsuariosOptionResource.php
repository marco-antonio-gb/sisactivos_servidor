<?php

namespace App\Http\Resources\Responsable;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuariosOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "usuario_id" => $this->idUsuario,
            "nombre_completo" => $this->nombres . ' ' . $this->paterno . ' ' . $this->materno
        ];
    }
    public function with($request)
    {
        return [
            'success' => $this->idUsuario ? true : false,
        ];
    }
}
