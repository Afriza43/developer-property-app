<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'kasir',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'teknik',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'site-admin',
            'guard_name' => 'web'
        ]);
    }
}
