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
            'category_name' => 'Pekerjaan Persiapan dan Tanah',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Pondasi',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Dinding',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Konstruksi Beton',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Penutup Atap',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Plafon',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Instalasi Air',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Lantai',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Pintu dan Jendela',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Cat',
        ]);
    }
}
