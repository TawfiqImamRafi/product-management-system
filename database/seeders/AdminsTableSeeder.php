<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        $role_superadmin = Role::where('name', 'super_admin')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $superAdmin = new Admin();
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 'superadmin@mail.com';
        $superAdmin->username = 'superadmin';
        $superAdmin->mobile = '01500000001';
        $superAdmin->password = bcrypt('password');
        $superAdmin->save();
        $superAdmin->attachRole($role_superadmin);

        $admin = new Admin();
        $admin->name = 'Admin';
        $admin->email = 'admin@mail.com';
        $admin->username = 'admin';
        $admin->mobile = '01500000002';
        $admin->password = bcrypt('password');
        $admin->save();
        $admin->attachRole($role_admin);
    }
}
