<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $keuangan = Role::create(['name' => 'keuangan', 'guard_name' => 'web']);
        $teknik = Role::create(['name' => 'teknik', 'guard_name' => 'web']);
        $admin = Role::create(['name' => 'site-admin', 'guard_name' => 'web']);

        // Permissions
        $permissions = [
            'manage-projects' => ['keuangan', 'teknik'],
            'manage-houses' => ['keuangan'],
            'manage-budget-plans' => ['teknik'],
            'manage-access' => ['keuangan'],
            'view-reports' => ['keuangan'],
            'create-reports' => ['site-admin'],
            'manage-house-types' => ['keuangan', 'teknik'],
        ];

        foreach ($permissions as $permission => $roles) {
            $perm = Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);

            foreach ($roles as $role) {
                $roleModel = Role::where('name', $role)->first();
                $roleModel->givePermissionTo($perm);
            }
        }
    }
}
