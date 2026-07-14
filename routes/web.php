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

// Dashboard Awak Kapal
Route::get('/dashboard/awak', function () {
    return view('awak.dashboard');
})->name('dashboard.awak');

// Tambah Logbook
Route::get('/logbook/create', function () {
    return view('awak.logbook.create');
})->name('logbook.create');
