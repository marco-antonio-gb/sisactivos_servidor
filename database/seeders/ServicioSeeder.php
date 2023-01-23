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
        Servicio::create([
            'nombre' => 'Administracion',
            'codigo' => 'ADM',
            'observacion' => 'Descripcion categoria Administracion',
        ]);
        Servicio::create([
            'nombre' => 'Direccion',
            'codigo' => 'DIR',
            'observacion' => 'Descripcion categoria Direccion',
        ]);
        Servicio::create([
            'nombre' => 'Sistemas',
            'codigo' => 'SIS',
            'observacion' => 'Descripcion categoria Sistemas',
        ]);
        Servicio::create([
            'nombre' => 'Emergencias',
            'codigo' => 'EMRG',
            'observacion' => 'Descripcion categoria Emergencias',
        ]);
        Servicio::create([
            'nombre' => 'Mantenimiento',
            'codigo' => 'MNTO',
            'observacion' => 'Descripcion categoria Mantenimiento',
        ]);
    }
}
