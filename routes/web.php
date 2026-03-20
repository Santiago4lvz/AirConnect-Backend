<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Cambio de idioma
Route::get('/language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

require __DIR__ . '/auth.php';
