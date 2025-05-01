<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('houses')->insert([
            [
                'name' => 'Mandura',
                'block_number' => '1',
                'type' => '38',
                'total_cost' => '',
                'image' => '',
                'password' => '123',
                'project_id' => 1,
            ],
        ]);
    }
}
