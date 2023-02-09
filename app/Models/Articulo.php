<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model {
	protected $primaryKey = 'idArticulo';

    protected $table = "articulos";
    protected $casts      = ['condicion' => 'boolean', 'idArticulo'=>'integer'];
	protected $fillable   = [
		'codigo',
		'unidad',
		'nombre',
		'descripcion',
		'imagen',
		'costo',
		'estado',
		'condicion',
		'fecha_registro',


		'categoria_id',
		'orgfinanciero_id',
	];

	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function getFechaRegistroAttribute($date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('j \d\e F \d\e\l Y ');
	}

    public function orgfinanciero() {
		return $this->BelongsTo(OrgFinanciero::class, 'orgfinanciero_id', 'idOrgfinanciero');
	}
    public function categoria() {
		return $this->BelongsTo(Categoria::class, 'categoria_id', 'idCategoria');
	}

    public function archivo(){
        return $this->HasOne(Archivo::class,'articulo_id','idArticulo');
    }
}
