<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PertaminaController;
use App\Http\Controllers\AwakController;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Pertamina Group
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/pertamina', [PertaminaController::class, 'dashboard'])->name('dashboard.pertamina');
    Route::get('/dashboard/pertamina/monitoring', [PertaminaController::class, 'monitoring'])->name('pertamina.monitoring');
    Route::get('/dashboard/pertamina/laporan', [PertaminaController::class, 'laporan'])->name('pertamina.laporan');
    Route::get('/dashboard/pertamina/profil', [PertaminaController::class, 'profil'])->name('pertamina.profil');

    // Kapal Management
    Route::get('/dashboard/pertamina/kapal', [PertaminaController::class, 'kapal'])->name('pertamina.kapal');
    Route::post('/dashboard/pertamina/kapal/tambah', [PertaminaController::class, 'storeKapal'])->name('pertamina.kapal.store');

    // Perusahaan Management
    Route::get('/dashboard/pertamina/perusahaan', [PertaminaController::class, 'perusahaan'])->name('pertamina.perusahaan');
    Route::post('/dashboard/pertamina/perusahaan/tambah', [PertaminaController::class, 'storePerusahaan'])->name('pertamina.perusahaan.store');

    // FTIT Management
    Route::get('/dashboard/pertamina/ftit', [PertaminaController::class, 'ftit'])->name('pertamina.ftit');
    Route::post('/dashboard/pertamina/ftit/tambah', [PertaminaController::class, 'storeFtit'])->name('pertamina.ftit.store');

    // User Management
    Route::get('/dashboard/pertamina/user', [PertaminaController::class, 'user'])->name('pertamina.user');
    Route::post('/dashboard/pertamina/user/tambah', [PertaminaController::class, 'storeUser'])->name('pertamina.user.store');

    // PDF Logbook viewing/downloading for Pertamina
    Route::get('/dashboard/pertamina/dokumen-pdf', [PertaminaController::class, 'indexPdf'])->name('pertamina.dokumen-pdf');
    Route::get('/dashboard/pertamina/dokumen-pdf/download/{id}', [PertaminaController::class, 'downloadPdf'])->name('pertamina.dokumen-pdf.download');
});

// Dashboard Awak Kapal Group
Route::middleware(['auth', 'role:awak_kapal'])->group(function () {
    Route::get('/dashboard/awak', [AwakController::class, 'dashboard'])->name('dashboard.awak');
    Route::get('/logbook/create', [AwakController::class, 'createLogbook'])->name('logbook.create');
    Route::post('/logbook/create', [AwakController::class, 'storeLogbook'])->name('logbook.store');
    Route::post('/logbook/edit/{id}', [AwakController::class, 'updateLogbook'])->name('logbook.update');
    Route::post('/logbook/delete/{id}', [AwakController::class, 'deleteLogbook'])->name('logbook.delete');
    Route::get('/dashboard/awak/riwayat', [AwakController::class, 'riwayat'])->name('awak.riwayat');
    Route::get('/dashboard/awak/profil', [AwakController::class, 'profil'])->name('awak.profil');

    // PDF Logbook Uploading for Awak Kapal
    Route::get('/dashboard/awak/upload-pdf', [AwakController::class, 'indexPdf'])->name('awak.upload-pdf');
    Route::post('/dashboard/awak/upload-pdf', [AwakController::class, 'storePdf'])->name('awak.upload-pdf.store');
    Route::post('/dashboard/awak/upload-pdf/delete/{id}', [AwakController::class, 'deletePdf'])->name('awak.upload-pdf.delete');
});

// Profile Settings
Route::middleware(['auth'])->post('/profile/update-password', [AuthController::class, 'updatePassword'])->name('profile.update-password');
