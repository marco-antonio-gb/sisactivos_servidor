<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model {
	protected $primaryKey = 'idArticulo';
    protected $table = "articulos";
    protected $casts      = ['condicion' => 'boolean'];
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
		return $date->format('Y-m-d H:i:s');
	}

    public function orgfinanciero() {
		return $this->BelongsTo(OrgFinanciero::class, 'orgfinanciero_id', 'idOrgfinanciero');
	}
    public function categoria() {
		return $this->BelongsTo(Categoria::class, 'categoria_id', 'idCategoria');
	}

    // public function archivos(){
    //     return $this->hasMany(Archivo::class,'articulo_id','idArticulo');
    // }
}
