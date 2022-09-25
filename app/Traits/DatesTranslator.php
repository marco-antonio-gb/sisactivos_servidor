<?php
namespace App\Traits;
use Jenssegers\Date\Date;
trait DatesTranslator
{
    public function getCreatedAtAttribute($created_at)
    {
        return new Date($created_at);
    }
    public function getUpdatedAtAttribute($updated_at)
    {
        return new Date($updated_at);
    }
    public function getFechaInicioAttribute($fecha_inicio)
    {
        return new Date($fecha_inicio);
    }
    public function getFechaFinalAttribute($fecha_final)
    {
        return new Date($fecha_final);
    }
}