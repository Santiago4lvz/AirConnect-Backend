<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserRegisteredController;
use App\Http\Controllers\IotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// login en el mobile
Route::post('login-mobile', [UserAuthController::class, 'login']);


// registro en el mobile
Route::post('register-mobile', [UserRegisteredController::class, 'store']);


// reigistro de iot

Route::post('iot-data', [IotController::class, 'store']);


// todos los datos de iot
Route::get('iot-data', [IotController::class, 'index']);
// Route::post('register-mobile',[RegisteredUserController::class,'store']);

Route::middleware('auth:sanctum')->get('/user-profile', [UserAuthController::class, 'userProfile']);




/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
/*Route::get('/sensores', function () {
    return response()->json([
        "temperatura" => 28,
        "humedad" => 65,
        "calidad_aire" => "Buena",
        "pm25" => 12
    ]);
})->middleware('auth:sanctum');
*/