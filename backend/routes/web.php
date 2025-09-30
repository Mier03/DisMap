<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RequestDataController;
use App\Http\Controllers\DoctorHospitalController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\WelcomeController; // Add this line

use Illuminate\Support\Facades\Route;

// This is the updated route for your welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// PUBLIC ROUTE - Data request form (accessible without auth)
Route::post('/data-requests', [SuperAdminController::class, 'storeDataRequest'])->name('data-requests.store');

// Route::post('/request-data', [RequestDataController::class, 'store'])->name('request-data.store');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/diseaserecords', [DiseaseController::class, 'index'])
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
        // foreach (['accountsettings'] as $page) {
        //     Route::view($page, "admin.$page")->name($page);
        // }

        Route::get('/accountsettings', [DoctorHospitalController::class, 'index'])->name('accountsettings');
        Route::post('/accountsettings', [DoctorHospitalController::class, 'store'])->name('doctor_hospitals.store');

        // Patient management routes
        Route::controller(PatientController::class)->group(function () {
            Route::get('/managepatients', 'index')->name('managepatients');
            Route::post('/patients', 'store')->name('patients.store');
            Route::patch('/patients/{patient}', 'update')->name('patients.update');
            Route::delete('/patients/{patient}', 'destroy')->name('patients.destroy');
            Route::get('/managepatients/{id}', 'viewPatient')->name('view_patients');
        });

        Route::post('patient-records/{id}/recovery', [PatientController::class, 'updateRecovery'])->name('patient_records.update_recovery');
        Route::get('/patient-records/{id}', [PatientController::class, 'show']);
    });

// Superadmin routes
Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        // Admin verification routes
        Route::controller(SuperAdminController::class)->group(function () {
            Route::get('verify', 'verifyAdmins')->name('verify_admins');
            Route::post('approve-admin/{id}', 'approveAdmin')->name('approve_admin');
            Route::post('reject-admin/{id}', 'rejectAdmin')->name('reject_admin');
            Route::delete('delete-admin/{id}', 'deleteAdmin')->name('delete_admin');
            Route::get('view-admin/{id}', 'viewAdmin')->name('view_admin');
            Route::put('update-admin/{id}', 'updateAdmin')->name('update_admin');
            Route::get('datarequest', 'datarequest')->name('datarequest');

            Route::patch('data-requests/{id}', 'updateDataRequestStatus')->name('data-requests.update');
            Route::get('/superadmin/data-requests/{id}', [SuperAdminController::class, 'getDataRequest'])
    ->name('superadmin.data-requests.show');
        });
    });



require __DIR__ . '/auth.php';
