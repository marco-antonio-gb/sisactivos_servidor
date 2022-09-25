<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'=>"Administrador",
            'guard_name'=>"api",
            'descripcion'=>"Descripcion.....",
        ]);

        Role::create([
            'name'=>"Medico",
            'guard_name'=>"api",
            'descripcion'=>"Descripcion.....",
        ]);
        Role::create([
            'name'=>"Asistente",
            'guard_name'=>"api",
            'descripcion'=>"Descripcion.....",
        ]);
        
    }
}
