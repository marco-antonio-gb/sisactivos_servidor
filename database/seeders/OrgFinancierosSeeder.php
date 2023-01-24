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
        $orgfinancieros=[
            'Tesoro General de la Nacion',
            'Donacion - HIPC',
            'T.G.N. Impuestos directos a los Hidrocarburos ',
            'Otros organismos financieros del gobierno',
            'Regalias',
            'Otros recursos espcificos',
            'Fondo andino de reserva',
            'Alcaldia municipal de Oruro',
            'Gobierno autonomo departamental de oruro',
            'Recursos propios '
        ];

        foreach ($orgfinancieros as $key => $org) {
            OrgFinanciero::create([
                'nombre' => $org,
                'descripcion' => '',
            ]);
        }

    }
}
