<?php

namespace Database\Seeders;

use App\Models\OrgFinanciero;
use Illuminate\Database\Seeder;

class OrgFinancierosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrgFinanciero::create([
            'nombre' => 'Tesoro General de la Nacion',
            'descripcion' => 'Descripcion de Tesoro General de la Nacion',
        ]);
        OrgFinanciero::create([
            'nombre' => 'Donaciones HIPC II',
            'descripcion' => 'Descripcion de Donaciones HIPC II',
        ]);
        OrgFinanciero::create([
            'nombre' => 'Regalias',
            'descripcion' => 'Descripcion de Regalias',
        ]);
        OrgFinanciero::create([
            'nombre' => 'Otros recursos especificos',
            'descripcion' => 'Descripcion de Otros recursos especificos',
        ]);
    }
}
