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
                'job_name' => 'Pembersihan Lokasi',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Pemasangan Bouwplank',
                'satuan_volume' => 'm',
            ],
            [
                'job_name' => 'Galian Tanah Pondasi',
                'satuan_volume' => 'm3',
            ],
            [
                'job_name' => 'Urugan Pasir Bawah Pondasi',
                'satuan_volume' => 'm3',
            ],
            [
                'job_name' => 'Pasang Pondasi Batu Kali',
                'satuan_volume' => 'm3',
            ],
            [
                'job_name' => 'Pasang Sloof Beton',
                'satuan_volume' => 'm',
            ],
            [
                'job_name' => 'Pasang Dinding Bata',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Plester Dinding',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Acian Dinding',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Pasang Kusen Pintu dan Jendela',
                'satuan_volume' => 'unit',
            ],
            [
                'job_name' => 'Pasang Daun Pintu',
                'satuan_volume' => 'unit',
            ],
            [
                'job_name' => 'Pasang Rangka Atap Baja Ringan',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Pasang Penutup Atap',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Pasang Plafon Gypsum',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Pasang Keramik Lantai',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Pasang Keramik Dinding Kamar',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Instalasi Listrik',
                'satuan_volume' => 'titik',
            ],
            [
                'job_name' => 'Instalasi Plumbing',
                'satuan_volume' => 'titik',
            ],
            [
                'job_name' => 'Pengecatan Dinding Dalam',
                'satuan_volume' => 'm2',
            ],
            [
                'job_name' => 'Pengecatan Dinding Luar',
                'satuan_volume' => 'm2',
            ],
        ]);
    }
}
