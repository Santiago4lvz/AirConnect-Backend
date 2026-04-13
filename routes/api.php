<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

// =============================================
// RUTAS PÚBLICAS (sin autenticación)
// =============================================

Route::get('/test', function() {
    return response()->json([
        'success' => true,
        'message' => 'API funcionando correctamente',
        'timestamp' => now()
    ]);
});

// =============================================
// RUTAS DE AUTENTICACIÓN PARA MOBILE
// =============================================

Route::post('/register-mobile', [RegisteredUserController::class, 'mobileRegister']);
Route::post('/login-mobile', [LoginController::class, 'mobileLogin']);

// =============================================
// RUTAS PROTEGIDAS (requieren token)
// =============================================

Route::middleware('auth:api')->group(function () {
    Route::get('/user-profile', [LoginController::class, 'getUserProfile']);
    Route::post('/logout-mobile', [LoginController::class, 'mobileLogout']);
    
    // Tus rutas de lecturas
    Route::get('/lecturas', [DashboardController::class, 'apiGetLecturas']);
    Route::get('/lecturas/ultima', [DashboardController::class, 'apiGetUltimaLectura']);
});

Route::get('/reporte/lecturas', [ReporteController::class, 'reporteLecturas']);
Route::post('/reporte/rango', [ReporteController::class, 'reportePorRango']);