<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

// Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated (sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin only
    Route::middleware('admin')->group(function () {
        Route::resource('peminjam', PeminjamController::class);
        Route::resource('peralatan', PeralatanController::class);
    });

    // All users
    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembali');

    // Export (CSV dan HTML untuk print PDF)
    Route::get('/export/peminjaman/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/peminjaman/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
});