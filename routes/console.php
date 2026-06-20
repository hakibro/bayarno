<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Setting;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto return phone numbers every minute
Schedule::command('auto:return-phone')->everyMinute();

// Sync siswa from API based on settings
Schedule::call(function () {
    $interval = Setting::get('api_sync_interval_minutes', 60);
    Artisan::call('sync:siswa');
})->cron('*/' . (Setting::get('api_sync_interval_minutes', 60)) . ' * * * *');
