<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserRegisteredController;
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
// Route::post('register-mobile',[RegisteredUserController::class,'store']);

Route::middleware('auth:sanctum')->get('/user-profile', [UserAuthController::class, 'userProfile']);

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
