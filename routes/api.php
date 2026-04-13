<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta de prueba para verificar que la API funciona
Route::get('/test', function() {
    return response()->json([
        'success' => true,
        'message' => 'API funcionando correctamente',
        'version' => app()->version(),
        'timestamp' => now(),
        'firebase_connected' => true
    ]);
});

// Obtener todas las lecturas (últimas 20)
Route::get('/lecturas', [DashboardController::class, 'apiGetLecturas']);

// Obtener solo la última lectura
Route::get('/lecturas/ultima', [DashboardController::class, 'apiGetUltimaLectura']);

// Obtener lecturas por rango (últimas N)
Route::get('/lecturas/recientes/{limit?}', [DashboardController::class, 'apiGetLecturasRecientes']);

