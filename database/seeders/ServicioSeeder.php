<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicios=[
            'Direccion',
            'Administracion',
            'Jefatura de enfermeria',
            'Laboratorio Clinico',
            'Triaje',
            'Emergencia',
            'Recursos Humanos',
            'Contaduria',
            'Tesoreria',
            'Farmacia',
            'Almacen',
            'Activos fijos',
            'Quirofano',
            'Maternidad'
        ];
        foreach ($servicios as $key => $servicio) {
            Servicio::create([
                'nombre' => $servicio,
                'codigo'=>substr(strtoupper($servicio),0,3)
            ]);
        }


    }
}
