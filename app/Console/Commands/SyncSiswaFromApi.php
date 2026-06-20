<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Siswa;
use App\Models\Setting;

class SyncSiswaFromApi extends Command
{
    protected $signature = 'sync:siswa';
    protected $description = 'Sync siswa data from API';

    public function handle()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->withCookies([
                    'SWN' => env('API_SWN'),
                ], 'api.daruttaqwa.or.id')
            ->get('https://api.daruttaqwa.or.id/sisda/v1/siswa');

        if ($response->successful()) {
            $rawData = $response->json();

            // Get the actual data array from the response
            $data = $rawData['data'] ?? [];
            $this->info('API returned ' . count($data) . ' records');

            $successCount = 0;
            $errorCount = 0;

            foreach ($data as $item) {
                try {
                    // phone field format: "085808300856 - ayah" or "085755096782 - ibu, 085852888002 - ayah" or null
                    $rawPhone = $item['phone'] ?? null;
                    $phoneData = null;
                    $pemilik = null;

                    if ($rawPhone) {
                        // Split by comma first (for multiple phones)
                        $phoneEntries = array_map('trim', explode(',', $rawPhone));

                        // Take the first entry and parse it
                        $firstEntry = $phoneEntries[0];
                        $parts = array_map('trim', explode(' - ', $firstEntry, 2));
                        $phoneData = $parts[0] ?: null;
                        $pemilik = $parts[1] ?? null; // "ayah" / "ibu" / null
                    }

                    Siswa::updateOrCreate(
                        ['idperson' => $item['idperson'] ?? ''],
                        [
                            'nama' => $item['nama'] ?? '',
                            'no_hp_asli' => $phoneData,
                            'no_hp_aktif' => $phoneData,
                            'no_hp_pemilik' => $pemilik,
                            'unit_formal' => $item['UnitFormal'] ?? null,
                            'kelas_formal' => $item['KelasFormal'] ?? null,
                            'asrama_pondok' => $item['AsramaPondok'] ?? null,
                            'kamar_pondok' => $item['KamarPondok'] ?? null,
                            'tingkat_diniyah' => $item['TingkatDiniyah'] ?? null,
                            'kelas_diniyah' => $item['KelasDiniyah'] ?? null,
                        ]
                    );
                    $successCount++;
                } catch (\Exception $e) {
                    $this->error('Error saving idperson: ' . ($item['idperson'] ?? 'unknown') . ' - ' . $e->getMessage());
                    $errorCount++;
                }
            }

            $this->info('Sync completed: ' . $successCount . ' success, ' . $errorCount . ' errors');
        } else {
            $this->error('Failed to sync data from API');
        }
    }
}
