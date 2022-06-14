<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perm_superadmin = Permission::get();
        $perm_admin = Permission::whereNotIn('name', ['manage_product'])->get();

        $super_admin = new Role();
        $super_admin->name = 'super_admin';
        $super_admin->description = "Super admin";
        $super_admin->save();
        $super_admin->attachPermissions($perm_superadmin);

        $admin = new Role();
        $admin->name = 'admin';
        $admin->save();
        $admin->attachPermissions($perm_admin);
    }
}
