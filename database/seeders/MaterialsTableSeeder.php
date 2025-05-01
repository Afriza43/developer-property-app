<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('materials')->insert([
            ['material_name' => 'Batu Kali Bulat Utuh', 'description' => 'Batu Kali', 'material_unit' => 'm3'],
            ['material_name' => 'Batu Kali Bulat Belah', 'description' => 'Batu Kali', 'material_unit' => 'm3'],
            ['material_name' => 'Batu Pecah 10/15', 'description' => 'Batu Kali', 'material_unit' => 'm3'],
            ['material_name' => 'Batu Pecah 5/7', 'description' => 'Batu Kali', 'material_unit' => 'm3'],
            ['material_name' => 'Batu Pecah 3/5', 'description' => 'Batu Kali', 'material_unit' => 'm3'],
            ['material_name' => 'Kerikil Beton 0,5/1', 'description' => 'Kerikil', 'material_unit' => 'm3'],
            ['material_name' => 'Kerikil Beton 1/2', 'description' => 'Kerikil', 'material_unit' => 'm3'],
            ['material_name' => 'Kerikil Beton 2/3', 'description' => 'Kerikil', 'material_unit' => 'm3'],
            ['material_name' => 'Koral Beton', 'description' => 'Kerikil', 'material_unit' => 'm3'],
            ['material_name' => 'Batu Bata ex lokal', 'description' => 'Batu Bata', 'material_unit' => 'bh'],
            ['material_name' => 'Batako ex lokal', 'description' => 'Batako', 'material_unit' => 'bh'],
            ['material_name' => 'Bata Ringan 7.5 cm', 'description' => 'Bata Ringan', 'material_unit' => 'bh'],
            ['material_name' => 'Bata Ringan 10 cm', 'description' => 'Bata Ringan', 'material_unit' => 'bh'],
            ['material_name' => 'Pasir Urug', 'description' => 'Pasir', 'material_unit' => 'm3'],
            ['material_name' => 'Pasir Pasang', 'description' => 'Pasir', 'material_unit' => 'm3'],
            ['material_name' => 'Pasir Beton', 'description' => 'Pasir', 'material_unit' => 'm3'],
        ]);
    }
}
