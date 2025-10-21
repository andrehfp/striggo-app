<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatisticsController;

// Public routes
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Protected routes (require authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Practice Mode
    Route::get('/pratica', function () {
        return view('practice');
    })->name('practice');

    // Simulated Test
    Route::get('/simulado', function () {
        return view('simulated');
    })->name('simulated');

    // Statistics
    Route::get('/estatisticas', [StatisticsController::class, 'index'])->name('statistics');

    // Achievements (redirect to statistics for now)
    Route::get('/conquistas', function () {
        return redirect()->route('statistics');
    })->name('achievements');

    // Profile routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include Breeze authentication routes
require __DIR__.'/auth.php';
