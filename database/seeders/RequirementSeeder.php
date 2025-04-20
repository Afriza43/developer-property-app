<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipments')->insert([
            [
                'equipment_name' => 'Mixer Beton',
                'description' => 'Untuk mencampur semen',
                'equipment_unit' => 'unit',
                'equipment_cost' => 5000000,
            ],
            [
                'equipment_name' => 'Genset',
                'description' => 'Sumber listrik',
                'equipment_unit' => 'unit',
                'equipment_cost' => 7500000,
            ],
            [
                'equipment_name' => 'Bor',
                'description' => 'Peralatan pengeboran',
                'equipment_unit' => 'unit',
                'equipment_cost' => 1500000,
            ],
            [
                'equipment_name' => 'Crane Mini',
                'description' => 'Mengangkat material berat',
                'equipment_unit' => 'unit',
                'equipment_cost' => 12000000,
            ],
            [
                'equipment_name' => 'Tangga Aluminium',
                'description' => 'Alat bantu naik',
                'equipment_unit' => 'unit',
                'equipment_cost' => 300000,
            ],
        ]);

        DB::table('materials')->insert([
            [
                'material_name' => 'Semen',
                'description' => 'Semen Portland 50kg',
                'material_unit' => 'zak',
                'material_cost' => 60000,
            ],
            [
                'material_name' => 'Pasir',
                'description' => 'Pasir halus 1 m³',
                'material_unit' => 'm3',
                'material_cost' => 150000,
            ],
            [
                'material_name' => 'Batu Split',
                'description' => 'Batu split ukuran 1/2',
                'material_unit' => 'm3',
                'material_cost' => 200000,
            ],
            [
                'material_name' => 'Besi Beton',
                'description' => 'Besi Ø10 mm',
                'material_unit' => 'btg',
                'material_cost' => 50000,
            ],
            [
                'material_name' => 'Kawat Bendrat',
                'description' => 'Pengikat besi',
                'material_unit' => 'kg',
                'material_cost' => 25000,
            ],
        ]);

        DB::table('employees')->insert([
            [
                'position' => 'Mandor',
                'unit' => 'org',
                'wage' => 150000,
            ],
            [
                'position' => 'Tukang',
                'unit' => 'org',
                'wage' => 120000,
            ],
            [
                'position' => 'Kenek',
                'unit' => 'org',
                'wage' => 80000,
            ],
            [
                'position' => 'Teknisi',
                'unit' => 'org',
                'wage' => 130000,
            ],
            [
                'position' => 'Pengawas',
                'unit' => 'org',
                'wage' => 160000,
            ],
        ]);

        DB::table('volume_items')->insert([
            [
                'description' => 'Pengecoran Lantai',
                'amount' => 2,
                'length' => 4.0,
                'width' => 5.0,
                'height' => 0.1,
                'wide' => 20.0,
                'volume_per_unit' => 2.0,
                'job_id' => 1,
            ],
            [
                'description' => 'Pembuatan Dinding Bata',
                'amount' => 3,
                'length' => 3.0,
                'width' => 0.15,
                'height' => 2.5,
                'wide' => 7.5,
                'volume_per_unit' => 1.125,
                'job_id' => 2,
            ],
            [
                'description' => 'Pemasangan Pondasi',
                'amount' => 1,
                'length' => 6.0,
                'width' => 0.5,
                'height' => 1.0,
                'wide' => 3.0,
                'volume_per_unit' => 3.0,
                'job_id' => 3,
            ],
            [
                'description' => 'Pengecoran Kolom',
                'amount' => 4,
                'length' => 0.3,
                'width' => 0.3,
                'height' => 3.0,
                'wide' => 0.9,
                'volume_per_unit' => 1.08,
                'job_id' => 1,
            ],
            [
                'description' => 'Plesteran Dinding',
                'amount' => 2,
                'length' => 5.0,
                'width' => 2.0,
                'height' => 0.02,
                'wide' => 10.0,
                'volume_per_unit' => 0.2,
                'job_id' => 2,
            ],
        ]);
    }
}
