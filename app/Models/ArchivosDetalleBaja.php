<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ArchivosDetalleBaja extends Model
{
    protected $table = 'acrhivos_detalle_baja';
    protected $primaryKaye = 'idArchivoDetallebaja';
    protected $fillable = [
        'nombre',
        'url',
        'detallebaja_id'
    ];
}
