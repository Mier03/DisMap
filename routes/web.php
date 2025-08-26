<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// example: domainname/admin/xxxx
Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->controller(AdminDashboardController::class)->group(function () {
        Route::get('dashboard', 'homepage')->name('homepage');
        // Route::patch('/', 'update')->name('update');
        // Route::delete('/', 'destroy')->name('destroy');
    });

require __DIR__.'/auth.php';
