<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->insert([
            ['position' => 'Pekerja', 'wage' => 80000, 'unit' => 'Hr'],
            ['position' => 'Mandor', 'wage' => 110000, 'unit' => 'Hr'],
            ['position' => 'Tukang Listrik', 'wage' => 90000, 'unit' => 'Hr'],
            ['position' => 'Tukang Kayu', 'wage' => 90000, 'unit' => 'Hr'],
            ['position' => 'Kep. TUK Kayu', 'wage' => 100000, 'unit' => 'Hr'],
            ['position' => 'Tukang Batu', 'wage' => 90000, 'unit' => 'Hr'],
            ['position' => 'Kep. TUK Batu', 'wage' => 100000, 'unit' => 'Hr'],
            ['position' => 'Tukang Besi', 'wage' => 90000, 'unit' => 'Hr'],
        ]);
    }
}
