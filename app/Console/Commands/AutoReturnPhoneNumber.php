<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ToggleHistory;
use App\Services\ApiService;
use Carbon\Carbon;

class AutoReturnPhoneNumber extends Command
{
    protected $signature = 'auto:return-phone';
    protected $description = 'Auto return phone numbers to original';

    public function handle()
    {
        $now = Carbon::now();
        $histories = ToggleHistory::with(['siswa'])
            ->whereNull('returned_at')
            ->where('scheduled_return_at', '<=', $now)
            ->get();

        $apiService = new ApiService();

        foreach ($histories as $history) {
            $siswa = $history->siswa;

            try {
                $apiService->updateTelepon($siswa->idperson, 'ibu', $siswa->no_hp_asli);

                $siswa->update(['no_hp_aktif' => $siswa->no_hp_asli]);
                $history->update(['returned_at' => $now]);
                $this->info("Returned phone for: {$siswa->nama}");
            } catch (\Exception $e) {
                $this->error("Failed to return phone for {$siswa->nama}: " . $e->getMessage());
            }
        }

        $this->info('Auto return completed');
    }
}
