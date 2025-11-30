<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiPatientRecordController;
use App\Http\Controllers\Api\ApiUserController;

// PUBLIC ROUTES
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/forgot-password-request', [ApiAuthController::class, 'forgotPasswordRequest']);
Route::post('/reset-password', [ApiAuthController::class, 'resetPassword']);

// get patient records and profile
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/records', [ApiPatientRecordController::class, 'records']);
    Route::get('/records/export-pdf', [ApiPatientRecordController::class, 'exportPdf']);
    Route::get('/user/profile', [ApiUserController::class, 'profile']);
    Route::post('/user/update-password', [ApiUserController::class, 'updatePassword']);
});