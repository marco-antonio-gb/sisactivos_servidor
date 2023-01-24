<?php

namespace App\Http\Resources\DetalleAsignacion;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetalleAsignacionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
			 $this->collection
		];
    }
}
