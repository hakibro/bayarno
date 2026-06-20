<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::create(['key' => 'return_duration_minutes', 'value' => '15']);
        \App\Models\Setting::create(['key' => 'api_sync_interval_minutes', 'value' => '60']);
        \App\Models\Setting::create(['key' => 'api_cookie', 'value' => 'SWN=034807c08591cc31b7400e762236ca241f4c0ba5']);
    }
}
