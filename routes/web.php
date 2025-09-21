<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/diseaserecords', [DashboardController::class, 'diseaseRecords'])
    ->middleware(['auth', 'verified'])
    ->name('diseaserecords');

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
    ->group(function () {

        // Other static admin pages that don't require controller data
        foreach (['accountsettings'] as $page) {
            Route::view($page, "admin.$page")->name($page);
        }

        // Patient management routes
        Route::controller(PatientController::class)->group(function () {
            Route::get('/managepatients', 'index')->name('managepatients');
            Route::post('/patients', 'store')->name('patients.store');
            Route::patch('/patients/{patient}', 'update')->name('patients.update');
            Route::delete('/patients/{patient}', 'destroy')->name('patients.destroy');
            Route::get('/managepatients/{id}', 'viewPatient')->name('view_patients');
        });
    });

// Superadmin routes
Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        // Static views that don't need controller data
        foreach (['datarequest'] as $page) {
            Route::view($page, "superadmin.$page")->name($page);
        }

        // Admin verification routes
        Route::controller(SuperAdminController::class)->group(function () {
            Route::get('verify', 'verifyAdmins')->name('verify_admins');
            Route::post('approve-admin/{id}', 'approveAdmin')->name('approve_admin');
            Route::post('reject-admin/{id}', 'rejectAdmin')->name('reject_admin');
            Route::delete('delete-admin/{id}', 'deleteAdmin')->name('delete_admin');
            Route::get('view-admin/{id}', 'viewAdmin')->name('view_admin');
            Route::put('update-admin/{id}', 'updateAdmin')->name('update_admin');
        });
    });

require __DIR__ . '/auth.php';
