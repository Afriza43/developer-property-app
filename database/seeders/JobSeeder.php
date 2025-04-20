<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jobs')->insert([
            [
                'job_name' => 'Buat Lantai',
                'total_cost' => 250000,
                'total_volume' => 2,
                'satuan_volume' => 'm3',
                'category_id' => 2,
            ],
            [
                'job_name' => 'Buat Taman',
                'total_cost' => 300000,
                'total_volume' => 3,
                'satuan_volume' => 'm3',
                'category_id' => 2,
            ],
        ]);
    }
}
