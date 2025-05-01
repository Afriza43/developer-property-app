<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipments')->insert([
            ['equipment_name' => 'Dump Truck 3 ton', 'equipment_cost' => 95000, 'equipment_unit' => 'Jam', 'description' => '3 ton'],
            ['equipment_name' => 'Dump Truck 9 ton', 'equipment_cost' => 125000, 'equipment_unit' => 'Jam', 'description' => '9 ton'],
            ['equipment_name' => 'Truk Bak Terbuka', 'equipment_cost' => 135000, 'equipment_unit' => 'Jam', 'description' => 'Bak Terbuka'],
            ['equipment_name' => 'Truk Tanki Air', 'equipment_cost' => 280000, 'equipment_unit' => 'Jam', 'description' => 'Tanki Air'],
            ['equipment_name' => 'Bulldozer 100-150 hp', 'equipment_cost' => 750000, 'equipment_unit' => 'Jam', 'description' => '100 - 150 hp'],
        ]);
    }
}
