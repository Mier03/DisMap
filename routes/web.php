<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')
    ->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('home', function () { return view('admin.home'); })->name('home');
        Route::get('managepatients', function () { return view('admin.managepatients'); })->name('managepatients');
        Route::get('diseaserecords', function () { return view('admin.diseaserecords'); })->name('diseaserecords');
        Route::get('accountsettings', function () { return view('admin.accountsettings'); })->name('accountsettings');
    });

// Superadmin routes
Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth', 'verified'])
    ->group(function() {
    Route::get('home', function () { return view('superadmin.home'); })->name('home');
    Route::get('datarequest', function () { return view('superadmin.datarequest'); })->name('datarequest');
    Route::get('diseaserecords', function () { return view('superadmin.diseaserecords'); })->name('diseaserecords');
    
    // Admin verification routes - using POST for actions that modify data
    Route::get('verify', [SuperAdminController::class, 'verifyAdmins'])->name('verify_admins');
    Route::post('approve-admin/{id}', [SuperAdminController::class, 'approveAdmin'])->name('approve_admin');
    Route::post('reject-admin/{id}', [SuperAdminController::class, 'rejectAdmin'])->name('reject_admin');
    Route::delete('delete-admin/{id}', [SuperAdminController::class, 'deleteAdmin'])->name('delete_admin');
    Route::get('view-admin/{id}', [SuperAdminController::class, 'viewAdmin'])->name('view_admin');
});

require __DIR__.'/auth.php';
