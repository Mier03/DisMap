<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiPatientRecordController;

// PUBLIC ROUTES
Route::post('/login', [ApiAuthController::class, 'login']);

// get patient records
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/records', [ApiPatientRecordController::class, 'records']);
});