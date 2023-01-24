<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$categorias = [
			['nombre' => 'Maquinaria en general', 'vida_util' => 8],
			['nombre' => 'Equipo medico y de laboratorio', 'vida_util' => 8],
			['nombre' => 'equipo de comunicaciones ', 'vida_util' => 8],
			['nombre' => 'Vehiculos Automotores ', 'vida_util' => 5],
			['nombre' => 'Herramientas en general', 'vida_util' => 4],
			['nombre' => 'Equipos de computacion ', 'vida_util' => 4],
			['nombre' => 'Muebles y enseres', 'vida_util' => 10],
			['nombre' => 'Otros activos fijos', 'vida_util' => 0],
			['nombre' => 'Avtivos intangibles ', 'vida_util' => 0],
		];

		foreach ($categorias as $key => $categoria) {
			Categoria::create([
				'nombre'      => $categoria['nombre'],
				'vida_util'   => $categoria['vida_util'],
				'descripcion' => '',
			]);
		}

	}
}
