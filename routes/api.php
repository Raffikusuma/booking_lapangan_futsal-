<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\BookingController;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/lapangan', [LapanganController::class, 'index']);
    Route::post('/lapangan', [LapanganController::class, 'store']);
    Route::get('/lapangan/{id}', [LapanganController::class, 'show']);
    Route::put('/lapangan/{id}', [LapanganController::class, 'update']);
    Route::delete('/lapangan/{id}', [LapanganController::class, 'destroy']);

    Route::get('/booking', [BookingController::class, 'index']);
    Route::post('/booking', [BookingController::class, 'store']);
    Route::get('/booking/{id}', [BookingController::class, 'show']);        
    Route::put('/booking/{id}', [BookingController::class, 'update']);
    Route::delete('/booking/{id}', [BookingController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
