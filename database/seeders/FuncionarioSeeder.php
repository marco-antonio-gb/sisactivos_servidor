<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $funcionarios = [
            [
                'apellidos'=>'Vargas Flores',
                'nombres'=>'Edwin Boris',
                'cargo'=>'Direccion',
                'documento'=>'Articulos'
            ],
            [
                'apellidos'=>'Lopez Dennis',
                'nombres'=>'Juan Carlos',
                'cargo'=>'Invetariador(a) G.A.M.O.',
                'documento'=>'Articulos'
            ],
            [
                'apellidos'=>'Quispe Flores',
                'nombres'=>'Julia Lopez',
                'cargo'=>'Invetariador(a) G.A.M.O.',
                'documento'=>'Articulos'
            ],
            [
                'apellidos'=>'Vargas Gonzales',
                'nombres'=>'Marcelo',
                'cargo'=>'Operador(a) G.A.M.O.',
                'documento'=>'Articulos'
            ],
            [
                'apellidos'=>'Herberth',
                'nombres'=>'Chugar Mamani',
                'cargo'=>'Administrador',
                'documento'=>'Asignacion'
            ],
            [
                'apellidos'=>'Triveño Torrico',
                'nombres'=>'Victor Hugo',
                'cargo'=>'Auditor Interno',
                'documento'=>'Asignacion'
            ],
        ];
        foreach ($funcionarios as $key => $funcionario) {
            Funcionario::create($funcionario);
        }
    }
}
