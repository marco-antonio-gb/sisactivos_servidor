<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ArchivosDetalleBaja extends Model
{
    protected $table = 'archivos_detalle_baja';
    protected $primaryKaye = 'idArchivoDetallebaja';
    protected $fillable = [
        'nombre',
        'url',
        'detallebaja_id'
    ];
}
