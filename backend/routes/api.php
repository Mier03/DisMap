<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiPatientRecordController;
use App\Http\Controllers\Api\ApiUserController;

// PUBLIC ROUTES
Route::post('/login', [ApiAuthController::class, 'login']);

// get patient records and profile
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/records', [ApiPatientRecordController::class, 'records']);
    Route::get('/user/profile', [ApiUserController::class, 'profile']);
});