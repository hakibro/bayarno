<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@bayarno.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $petugas = \App\Models\User::create([
            'name' => 'Petugas Demo',
            'email' => 'petugas@bayarno.com',
            'password' => bcrypt('password'),
            'role' => 'petugas'
        ]);

        \App\Models\Petugas::create([
            'user_id' => $petugas->id,
            'nama' => 'Petugas Demo',
            'no_hp' => '081234567890'
        ]);
    }
}
