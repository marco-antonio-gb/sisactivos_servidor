<?php
namespace Database\Seeders;
use App\Models\Archivo;
use App\Models\Articulo;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
class ArticuloSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function generarCodigo($cantidad=10){
		$b      = '0';
		$c      = '00';
		$d      = '000';
		$e      = '0000';
		$imagenes = [
			'2NzSUha9P9RPd1BB8rYW.jpg',
			'2NzSUha9P9RPd1BB8rYW.jpg',
			'52323c68-3d0d-41fd-a1cd-094b8a620baf.jpg',
			'Pc62OMAfvGJLGz2YZzlt.jpg',
			'quqocPGnTWWQW780pFWw.jpg',
			'foto_articulo (1).jpg',
			'foto_articulo (2).jpg',
			'foto_articulo (3).jpg',
			'foto_articulo (4).jpg',
			'foto_articulo (5).jpg',
			'foto_articulo (6).jpg',
			'foto_articulo (7).jpg',
			'foto_articulo (8).jpg',
			'foto_articulo (9).jpg',
			'foto_articulo (10).jpg'
		];
		for ($i = 1; $i < $cantidad + 1; $i++) {
			$cod = 0 + $i;
			if ($cod <= 10) {
				$cod = 'AM-D-' . $e . $i.'-06-001';
			} 
			$articulo  = [
				'codigo'           => $cod,
				'unidad'           => 'PZA',
				'nombre'           => 'NOMBRE DE ARTICULO '. $i,
				'descripcion'      => 'NOMBRE DE ARTICULO '.$i.'  DE 123X39X155 CM., 4 DIVISIONES, 2 GAVETAS,2 PUERTAS CON VIDRIO, 3 JALADORES, 1 CHAPA.',
				'imagen'           => $imagenes[$i],
				'costo'            => '0',
				'estado'           => 'Bueno',
				'categoria_id'     => rand(1,9),
				'orgfinanciero_id' => rand(1,10),
			];
			$articulo_id = Articulo::create($articulo)->idArticulo;
            Archivo::create([
                "nombre"=>$articulo['imagen'],
                "url"=>'home/articulos/fotos/'.$articulo['imagen'],
                "articulo_id"=>$articulo_id
            ]);
		}
	}	
	public function run() {
		$this->generarCodigo();
		// $articulos = [
		// 	[
		// 		'codigo'           => 'AM-D-000001-06-001',
		// 		'unidad'           => 'PZA',
		// 		'nombre'           => 'ESTANTE DE MADERA ROBLE',
		// 		'descripcion'      => 'ESTANTE DE MADERA ROBLE DE 123X39X155 CM., 4 DIVISIONES, 2 GAVETAS,2 PUERTAS CON VIDRIO, 3 JALADORES, 1 CHAPA.',
		// 		'imagen'           => 'quqocPGnTWWQW780pFWw.jpg',
		// 		'costo'            => '0',
		// 		'estado'           => 'Bueno',
		// 		// 'asignado'=>'',
		// 		// 'baja'=>'',
		// 		// 'fecha_registro'=>'',
		// 		'categoria_id'     => 1,
		// 		'orgfinanciero_id' => 1,
		// 	],
		// 	[
		// 		'codigo'           => 'AM-D-000002-06-001',
		// 		'unidad'           => 'PZA',
		// 		'nombre'           => 'ROPERO DE TABLERO AGLOMERADO',
		// 		'descripcion'      => 'ROPERO DE TABLERO AGLOMERADO ROBLE DE 140x60x179 cm. CON 2 PUERTAS, 2 JALADORES METALICOS Y 2 CHAPAS',
		// 		'imagen'           => 'Pc62OMAfvGJLGz2YZzlt.jpg',
		// 		'costo'            => '0',
		// 		'estado'           => 'Bueno',
		// 		// 'asignado'=>'',
		// 		// 'baja'=>'',
		// 		// 'fecha_registro'=>'',
		// 		'categoria_id'     => 1,
		// 		'orgfinanciero_id' => 2,
		// 	],
		// 	[
		// 		'codigo'           => 'AM-D-000003-06-001',
		// 		'unidad'           => 'PZA',
		// 		'nombre'           => 'ESTANTE DE TABLERO AGLOMERADO',
		// 		'descripcion'      => 'ESTANTE DE TABLERO AGLOMERADO ROBLE DE 85x43x210 cm. 5 DIVISIONES',
		// 		'imagen'           => '2NzSUha9P9RPd1BB8rYW.jpg',
		// 		'costo'            => '0',
		// 		'estado'           => 'Bueno',
		// 		'categoria_id'     => 1,
		// 		'orgfinanciero_id' => 2,
		// 	],
		// 	[
		// 		'codigo'           => 'AM-D-000003-06-001',
		// 		'unidad'           => 'PZA',
		// 		'nombre'           => 'ESTANTE DE TABLERO AGLOMERADO',
		// 		'descripcion'      => 'ESTANTE DE TABLERO AGLOMERADO ROBLE DE 85x43x210 cm. 5 DIVISIONES',
		// 		'imagen'           => '2NzSUha9P9RPd1BB8rYW.jpg',
		// 		'costo'            => '0',
		// 		'estado'           => 'Bueno',
		// 		'categoria_id'     => 1,
		// 		'orgfinanciero_id' => 2,
		// 	],
		// ];
        // foreach ($articulos as $key => $articulo) {
        //     Articulo::create($articulo);
        //     Archivo::create([
        //         "nombre"=>$articulo['imagen'],
        //         "url"=>'home/articulos/fotos/'.$articulo['imagen'],
        //         "articulo_id"=>$key+1
        //     ]);
        // }
	}
}
