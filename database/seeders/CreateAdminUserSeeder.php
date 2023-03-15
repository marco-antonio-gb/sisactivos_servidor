<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Usuario::find(1);
        $role = Role::find(1);
        $permissions = Permission::pluck('id', 'id')->all();
        $user->givePermissionTo($permissions);
        $user->assignRole(1);
        // $roles=[2,3,4];
        // for ($i=2; $i <= 6; $i++) {
        //     $_user = Usuario::find($i);
        //     $_role = Role::find(array_rand($roles));
        //     $_permissions = Permission::pluck('id','id')->all();
        //     $_user->givePermissionTo($_permissions);
        //     $_user->assignRole(array_rand($roles));
        // }
    }
}
