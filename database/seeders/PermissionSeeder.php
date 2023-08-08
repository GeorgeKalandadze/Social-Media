<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'delete-post',
            'edit-post'
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $creatorRole = Role::create(['name' => 'creator']);

        $adminRole->givePermissionTo('delete-post');
        $creatorRole->givePermissionTo('delete-post');
        $creatorRole->givePermissionTo('edit-post');
    }
}
