<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perm = new Permission();
        $perm->name = 'manage_category';
        $perm->save();

        $perm = new Permission();
        $perm->name = 'manage_brand';
        $perm->save();

        $perm = new Permission();
        $perm->name = 'manage_product';
        $perm->save();
    }
}
