<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kasir = User::create([
            'name' => 'Nila',
            'username' => 'kasir-nila',
            'password' => bcrypt('12345'),
        ]);

        $kasir->assignRole('keuangan');

        $teknik = User::create([
            'name' => 'Kendarto',
            'username' => 'teknik-kendarto',
            'password' => bcrypt('12345'),
        ]);

        $teknik->assignRole('teknik');

        $siteAdmin = User::create([
            'name' => 'Rahayu',
            'username' => 'siteadmin-1',
            'password' => bcrypt('12345'),
        ]);

        $siteAdmin->assignRole('site-admin');
    }
}
