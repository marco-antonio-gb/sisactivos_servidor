<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsuariosTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolSyncPermissionSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(OrgFinancierosSeeder::class);
        $this->call(ServicioSeeder::class);
        $this->call(ArticuloSeeder::class);
        $this->call(FuncionarioSeeder::class);
    }
}
