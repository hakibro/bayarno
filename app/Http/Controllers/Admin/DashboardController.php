<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\ToggleHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalPetugas = Petugas::count();
        $activeToggles = ToggleHistory::whereNull('returned_at')->count();

        return view('admin.dashboard', compact('totalSiswa', 'totalPetugas', 'activeToggles'));
    }
}
