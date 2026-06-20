<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Siswa;
use App\Models\ToggleHistory;

class SyncController extends Controller
{
    public function syncSiswa()
    {
        // Check if there are any active toggles (not yet returned)
        $activeToggles = ToggleHistory::whereNull('returned_at')->count();

        if ($activeToggles > 0) {
            return redirect()->back()->with('warning', 'Perhatian! Masih ada ' . $activeToggles . ' siswa dengan toggle aktif (belum dikembalikan). Sync akan menimpa data nomor HP yang sedang di-toggle. Yakin ingin melanjutkan?');
        }

        try {
            Artisan::call('sync:siswa');
            return redirect()->back()->with('success', 'Sinkronisasi data siswa berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sinkronisasi gagal: ' . $e->getMessage());
        }
    }
}
