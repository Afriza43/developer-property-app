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
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $kasir->assignRole('kasir');

        $user = User::create([
            'name' => 'Heru',
            'email' => 'teknik@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('teknik');
    }
}
