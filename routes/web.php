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


Route::get('/', function () {
    return "Bienvenido a AirConnect Backend";
});

Route::get('/health', function () {
    try {
        DB::connection()->getPdo(); // Verifica la base de datos
        return response()->json(['status' => 'healthy', 'database' => 'connected'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'unhealthy', 'error' => $e->getMessage()], 500);
    }
});