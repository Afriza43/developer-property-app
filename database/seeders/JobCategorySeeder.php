<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobCategory::create([
            'category_name' => 'Pekerjaan Persiapan',
            'category_cost' => 250000,
            'house_id' => 1,
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Penyelesaian',
            'category_cost' => 300000,
            'house_id' => 1,
        ]);
    }
}
