<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing roles and permissions
        Role::query()->delete();
        Permission::query()->delete();

        // Create permissions
        $permissions = [
            'view-users', 'create-users', 'edit-users', 'delete-users',
            'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
            'view-items', 'create-items', 'edit-items', 'delete-items',
            'view-inventory', 'create-inventory', 'edit-inventory', 'delete-inventory',
            'view-transactions', 'create-transactions', 'edit-transactions', 'delete-transactions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view-users', 'view-roles', 'view-items', 'view-inventory', 'view-transactions',
            'create-items', 'edit-items', 'delete-items',
            'create-inventory', 'edit-inventory', 'delete-inventory',
            'create-transactions', 'edit-transactions', 'delete-transactions',
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view-items', 'view-inventory', 'view-transactions',
        ]);

        // Assign the 'admin' role to the first user
        $user = User::first(); // Assign role to the first user
        $user->assignRole('admin');
    }
}

