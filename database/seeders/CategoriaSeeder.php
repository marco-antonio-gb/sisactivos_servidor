<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'Edificios',
            'vida_util' => 20,
            'descripcion' => 'Descripcion categoria Edificios',
        ]);
        Categoria::create([
            'nombre' => 'Bienes Inmuebles',
            'vida_util' => 5,
            'descripcion' => 'Descripcion categoria Bienes Inmuebles',
        ]);
    }
}
