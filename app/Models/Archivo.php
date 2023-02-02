<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Carbon;
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
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}

    public function articulo(){
        return $this->HasOne(Articulo::class,'idArticulo','articulo_id');
    }
}
