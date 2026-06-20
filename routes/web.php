<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Petugas\DashboardController;
use App\Http\Controllers\Petugas\ToggleController;
use App\Http\Controllers\Petugas\HistoryController;
use App\Http\Controllers\Petugas\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\HistoryController as AdminHistoryController;
use App\Http\Controllers\Admin\SyncController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        if (auth()->user()->role === 'admin') {
            return redirect('/admin/siswa');
        }
        return redirect('/petugas/dashboard');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('siswa', SiswaController::class)->names('admin.siswa');
        Route::resource('petugas', PetugasController::class)->names('admin.petugas');
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::get('/history', [AdminHistoryController::class, 'index'])->name('admin.history');
        Route::post('/sync-siswa', [SyncController::class, 'syncSiswa'])->name('admin.sync.siswa');
        Route::post('/siswa/{id}/toggle', [SiswaController::class, 'toggle'])->name('admin.siswa.toggle');
        Route::put('/siswa/{id}/update-phone', [SiswaController::class, 'updatePhone'])->name('admin.siswa.updatePhone');
    });

    // Petugas routes
    Route::middleware('role:petugas')->prefix('petugas')->group(function () {
        Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('petugas.dashboard');
        Route::post('/toggle/{siswa}', [ToggleController::class, 'toggle'])->name('petugas.toggle');
        Route::post('/restore/{siswa}', [ToggleController::class, 'restore'])->name('petugas.restore');
        Route::get('/history', [HistoryController::class, 'index'])->name('petugas.history');
        Route::get('/profil', [ProfileController::class, 'edit'])->name('petugas.profil.edit');
        Route::put('/profil', [ProfileController::class, 'update'])->name('petugas.profil.update');

        // Cascading dropdown endpoints
        Route::get('/get-kelas-by-unit', [DashboardController::class, 'getKelasByUnit'])->name('petugas.getKelasByUnit');
        Route::get('/get-kamar-by-asrama', [DashboardController::class, 'getKamarByAsrama'])->name('petugas.getKamarByAsrama');
        Route::get('/get-kelas-by-tingkat', [DashboardController::class, 'getKelasByTingkat'])->name('petugas.getKelasByTingkat');
    });
});
