<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\DashboardController;

// Ruta principal
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/checkin', [DashboardController::class, 'checkin'])->name('dashboard.checkin');
    Route::post('/checkout', [DashboardController::class, 'checkout'])->name('dashboard.checkout');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Cambio de idioma
Route::get('/language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

// Rutas de restablecimiento de contraseña (Breeze)
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
         ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
         ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
         ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
         ->name('password.update');
});



Route::get('/api/dashboard/stats', [DashboardController::class, 'apiStats']);

require __DIR__.'/auth.php';