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
            'classification' => 'Konstruksi',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Pondasi',
            'classification' => 'Konstruksi',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Dinding',
            'classification' => 'Konstruksi',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Konstruksi Beton',
            'classification' => 'Konstruksi',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Penutup Atap',
            'classification' => 'Konstruksi',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Plafon',
            'classification' => 'Konstruksi',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Instalasi Air',
            'classification' => 'Konstruksi',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Lantai',
            'classification' => 'Konstruksi',
        ]);

        JobCategory::create([
            'category_name' => 'Pekerjaan Pintu dan Jendela',
            'classification' => 'Konstruksi',
        ]);
        JobCategory::create([
            'category_name' => 'Pekerjaan Cat',
            'classification' => 'Konstruksi',
        ]);
        JobCategory::create([
            'category_name' => 'Jaringan Listrik',
            'classification' => 'Sarana',
        ]);
        JobCategory::create([
            'category_name' => 'Sambungan Listrik',
            'classification' => 'Sarana',
        ]);
        JobCategory::create([
            'category_name' => 'Sambungan Air',
            'classification' => 'Sarana',
        ]);
        JobCategory::create([
            'category_name' => 'Perlengkapan Rumah',
            'classification' => 'Sarana',
        ]);
        JobCategory::create([
            'category_name' => 'Jalan Lingkungan',
            'classification' => 'Prasarana',
        ]);
        JobCategory::create([
            'category_name' => 'Saluran Lingkungan',
            'classification' => 'Prasarana',
        ]);
        JobCategory::create([
            'category_name' => 'Jalan Utama',
            'classification' => 'Prasarana',
        ]);
        JobCategory::create([
            'category_name' => 'Gapura',
            'classification' => 'Prasarana',
        ]);
    }
}
