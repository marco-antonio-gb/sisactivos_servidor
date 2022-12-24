<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table      = 'archivos';
	protected $primaryKey = 'idArchivo';
	protected $hidden     = array('pivot');


	protected $fillable = [
		"nombre",
        "url",
        "articulo_id"
	];

	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
}
