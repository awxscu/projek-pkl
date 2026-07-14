<?php

use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Dashboard Pertamina
Route::get('/dashboard/pertamina', function () {
    return view('pertamina.dashboard');
})->name('dashboard.pertamina');

Route::get('/dashboard/pertamina/monitoring', function () {
    return view('pertamina.monitoring');
})->name('pertamina.monitoring');

Route::get('/dashboard/pertamina/verifikasi', function () {
    return view('pertamina.verifikasi');
})->name('pertamina.verifikasi');

Route::get('/dashboard/pertamina/kapal', function () {
    return view('pertamina.kapal');
})->name('pertamina.kapal');

Route::get('/dashboard/pertamina/perjalanan', function () {
    return view('pertamina.perjalanan');
})->name('pertamina.perjalanan');

Route::get('/dashboard/pertamina/laporan', function () {
    return view('pertamina.laporan');
})->name('pertamina.laporan');

Route::get('/dashboard/pertamina/profil', function () {
    return view('pertamina.profil');
})->name('pertamina.profil');

// Dashboard Awak Kapal
Route::get('/dashboard/awak', function () {
    return view('awak.dashboard');
})->name('dashboard.awak');

Route::get('/logbook/create', function () {
    return view('awak.logbook.create');
})->name('logbook.create');

Route::get('/dashboard/awak/riwayat', function () {
    return view('awak.riwayat');
})->name('awak.riwayat');

Route::get('/dashboard/awak/perjalanan', function () {
    return view('awak.perjalanan');
})->name('awak.perjalanan');

Route::get('/dashboard/awak/profil', function () {
    return view('awak.profil');
})->name('awak.profil');
