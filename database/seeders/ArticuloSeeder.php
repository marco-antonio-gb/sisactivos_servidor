<?php

namespace Database\Seeders;

use App\Models\Archivo;
use App\Models\Articulo;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$articulos = [
			[
				'codigo'           => 'AM-D-000001-06-001',
				'unidad'           => 'PZA',
				'nombre'           => 'ESTANTE DE MADERA ROBLE',
				'descripcion'      => 'ESTANTE DE MADERA ROBLE DE 123X39X155 CM., 4 DIVISIONES, 2 GAVETAS,2 PUERTAS CON VIDRIO, 3 JALADORES, 1 CHAPA.',
				'imagen'           => 'quqocPGnTWWQW780pFWw.jpg',
				'costo'            => '0',
				'estado'           => 'Bueno',
				// 'asignado'=>'',
				// 'baja'=>'',
				// 'fecha_registro'=>'',
				'categoria_id'     => 1,
				'orgfinanciero_id' => 1,
			],
			[
				'codigo'           => 'AM-D-000002-06-001',
				'unidad'           => 'PZA',
				'nombre'           => 'ROPERO DE TABLERO AGLOMERADO',
				'descripcion'      => 'ROPERO DE TABLERO AGLOMERADO ROBLE DE 140x60x179 cm. CON 2 PUERTAS, 2 JALADORES METALICOS Y 2 CHAPAS',
				'imagen'           => 'Pc62OMAfvGJLGz2YZzlt.jpg',
				'costo'            => '0',
				'estado'           => 'Bueno',
				// 'asignado'=>'',
				// 'baja'=>'',
				// 'fecha_registro'=>'',
				'categoria_id'     => 1,
				'orgfinanciero_id' => 2,
			],
			[
				'codigo'           => 'AM-D-000003-06-001',
				'unidad'           => 'PZA',
				'nombre'           => 'ESTANTE DE TABLERO AGLOMERADO',
				'descripcion'      => 'ESTANTE DE TABLERO AGLOMERADO ROBLE DE 85x43x210 cm. 5 DIVISIONES',
				'imagen'           => '2NzSUha9P9RPd1BB8rYW.jpg',
				'costo'            => '0',
				'estado'           => 'Bueno',
				// 'asignado'=>'',
				// 'baja'=>'',
				// 'fecha_registro'=>'',
				'categoria_id'     => 1,
				'orgfinanciero_id' => 2,
			],
		];
        foreach ($articulos as $key => $articulo) {
            Articulo::create($articulo);
            Archivo::create([
                "nombre"=>$articulo['imagen'],
                "url"=>'home/articulos/fotos/'.$articulo['imagen'],
                "articulo_id"=>$key+1
            ]);
        }
	}
}
