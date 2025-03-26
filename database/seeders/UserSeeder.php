<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'department' => 'Administration',
            'employee_id' => 'ADM001'
        ]);

        $superAdmin->assignRole('super-admin');

        // Create a regular admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => 'password',
            'department' => 'Administration',
            'employee_id' => 'ADM002'
        ]);

        $admin->assignRole('admin');

        // Create a manager user
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => 'password',
            'department' => 'Management',
            'employee_id' => 'MGR001'
        ]);

        $manager->assignRole('manager');

        // Create an operator user
        $operator = User::create([
            'name' => 'Operator User',
            'email' => 'operator@example.com',
            'password' => 'password',
            'department' => 'Operations',
            'employee_id' => 'OPR001'
        ]);

        $operator->assignRole('operator');

        // Create a regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => 'password',
            'department' => 'General',
            'employee_id' => 'USR001'
        ]);

        $user->assignRole('user');
    }
} 