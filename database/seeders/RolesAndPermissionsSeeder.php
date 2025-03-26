<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for users
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        // Create permissions for roles
        Permission::create(['name' => 'view-roles']);
        Permission::create(['name' => 'create-roles']);
        Permission::create(['name' => 'edit-roles']);
        Permission::create(['name' => 'delete-roles']);

        // Create permissions for items
        Permission::create(['name' => 'view-items']);
        Permission::create(['name' => 'create-items']);
        Permission::create(['name' => 'edit-items']);
        Permission::create(['name' => 'delete-items']);

        // Create permissions for inventory
        Permission::create(['name' => 'view-inventory']);
        Permission::create(['name' => 'create-inventory']);
        Permission::create(['name' => 'edit-inventory']);
        Permission::create(['name' => 'delete-inventory']);

        // Create permissions for transactions
        Permission::create(['name' => 'view-transactions']);
        Permission::create(['name' => 'create-transactions']);
        Permission::create(['name' => 'edit-transactions']);
        Permission::create(['name' => 'delete-transactions']);

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view-users', 'create-users', 'edit-users',
            'view-roles', 'create-roles', 'edit-roles',
            'view-items', 'create-items', 'edit-items', 'delete-items',
            'view-inventory', 'create-inventory', 'edit-inventory', 'delete-inventory',
            'view-transactions', 'create-transactions', 'edit-transactions', 'delete-transactions'
        ]);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view-users',
            'view-items', 'create-items', 'edit-items',
            'view-inventory', 'create-inventory', 'edit-inventory',
            'view-transactions', 'create-transactions', 'edit-transactions'
        ]);

        $operator = Role::create(['name' => 'operator']);
        $operator->givePermissionTo([
            'view-items',
            'view-inventory',
            'view-transactions', 'create-transactions'
        ]);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'view-items',
            'view-inventory',
            'view-transactions'
        ]);
    }
} 