<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\ToggleHistory;
use App\Models\Setting;
use App\Services\ApiService;
use Carbon\Carbon;

class ToggleController extends Controller
{
    public function toggle(Request $request, $siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $petugas = auth()->user()->petugas;

        if (!$petugas) {
            return back()->with('error', 'Anda tidak memiliki akses sebagai petugas');
        }

        $durationMinutes = (int) Setting::get('return_duration_minutes', 15);
        $scheduledReturn = Carbon::now()->addMinutes($durationMinutes);

        // Call API to update phone
        try {
            $apiService = new ApiService();
            $apiService->updateTelepon($siswa->idperson, $siswa->no_hp_pemilik ?? 'ibu', $petugas->no_hp);
            $siswa->update(['no_hp_aktif' => $petugas->no_hp]);

            ToggleHistory::create([
                'siswa_id' => $siswa->id,
                'petugas_id' => $petugas->id,
                'action' => 'toggle_on',
                'no_hp_temporary' => $petugas->no_hp,
                'scheduled_return_at' => $scheduledReturn
            ]);

            return back()->with('success', 'Nomor HP berhasil diubah');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            // Check for duplicate phone number error
            if (str_contains($errorMessage, 'Duplicate entry') || str_contains($errorMessage, '1062')) {
                return back()->with('error', 'Gagal toggle: Nomor HP Anda sudah terdaftar untuk siswa ini sebagai nomor orang tua. Gunakan nomor HP lain.');
            }

            return back()->with('error', 'Gagal mengubah nomor HP: ' . $errorMessage);
        }
    }

    public function restore(Request $request, $siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $petugas = auth()->user()->petugas;

        if (!$petugas) {
            return back()->with('error', 'Anda tidak memiliki akses sebagai petugas');
        }

        // Check if number is currently toggled
        if ($siswa->no_hp_aktif === $siswa->no_hp_asli) {
            return back()->with('info', 'Nomor HP sudah dalam keadaan asli');
        }

        try {
            // Restore to original number via API
            $apiService = new ApiService();
            $apiService->updateTelepon($siswa->idperson, $siswa->no_hp_pemilik ?? 'ibu', $siswa->no_hp_asli);
            $siswa->update(['no_hp_aktif' => $siswa->no_hp_asli]);

            // Update toggle history
            $latestHistory = ToggleHistory::where('siswa_id', $siswa->id)
                ->whereNull('returned_at')
                ->latest()
                ->first();

            if ($latestHistory) {
                $latestHistory->update([
                    'returned_at' => Carbon::now(),
                    'action' => 'manual_return'
                ]);
            }

            return back()->with('success', 'Nomor HP berhasil dikembalikan ke nomor asli');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengembalikan nomor HP: ' . $e->getMessage());
        }
    }
}
