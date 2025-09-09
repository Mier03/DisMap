<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/home', function () {
//     return redirect()->route('dashboard');
// })->name('home');

// Route::get('/verify', function () {
//     return view('superadmin.verify_admins');
// })->middleware(['auth', 'verified'])->name('verify_admins');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('home', function () { return view('admin.home'); })->name('home');
    Route::get('managepatients', function () { return view('admin.managepatients'); })->name('managepatients');
    Route::get('diseaserecords', function () { return view('admin.diseaserecords'); })->name('diseaserecords');
    Route::get('accountsettings', function () { return view('admin.accountsettings'); })->name('accountsettings');
});

// Superadmin routes
Route::prefix('superadmin')->name('superadmin.')->group(function() {
    Route::get('home', function () { return view('superadmin.home'); })->name('home');
    Route::get('datarequest', function () { return view('superadmin.datarequest'); })->name('datarequest');
    Route::get('diseaserecords', function () { return view('superadmin.diseaserecords'); })->name('diseaserecords');
    Route::get('verify', function () { return view('superadmin.verify_admins'); })->name('verify_admins');
});

require __DIR__.'/auth.php';
