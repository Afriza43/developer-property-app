<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\EquipmentsTableSeeder;
use Database\Seeders\MaterialsTableSeeder;
use Database\Seeders\EmployeesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            MaterialsTableSeeder::class,
            JobCategorySeeder::class,
            JobSeeder::class,
            // EquipmentsTableSeeder::class,
            // EmployeesTableSeeder::class,
        ]);
    }
}
