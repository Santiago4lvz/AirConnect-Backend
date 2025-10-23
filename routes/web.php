<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Cambio de idioma
Route::get('/language/{language}', [LanguageController::class, 'switch'])->name('language.switch');


require __DIR__.'/auth.php';
