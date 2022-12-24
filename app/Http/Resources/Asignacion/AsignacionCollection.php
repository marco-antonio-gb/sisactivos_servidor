<?php

namespace App\Http\Resources\Asignacion;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AsignacionCollection extends ResourceCollection
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
			'data'  => $this->collection,
            'success' => count($this->collection)>0?true:false
		];
    }
}
