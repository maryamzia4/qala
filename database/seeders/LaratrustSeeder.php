<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;


class LaratrustSeeder extends Seeder
{
    public function run()
    {
        // Clear previous roles and permissions
        Role::query()->delete();
        Permission::query()->delete();
        \DB::table('role_user')->delete();
        \DB::table('permission_user')->delete();
        \DB::table('permission_role')->delete();


        // Create roles
        $customer = Role::create(['name' => 'customer']);
        $artist = Role::create(['name' => 'artist']);
        $admin = Role::create(['name' => 'admin']);

        // Create permissions
        $viewProducts = Permission::create(['name' => 'view-products']);
        $manageOwnProducts = Permission::create(['name' => 'manage-own-products']);
        $manageProfiles = Permission::create(['name' => 'manage-profiles']);
        $editProducts = Permission::create(['name' => 'edit-products']);

        // Assign permissions to roles
        $customer->permissions()->attach($viewProducts);

        $artist->permissions()->attach([$viewProducts->id, $manageOwnProducts->id, $manageProfiles->id]);

        $admin->permissions()->attach([$viewProducts->id, $editProducts->id]);
    }
}

