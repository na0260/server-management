<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServerController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('servers', ServerController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
//    Route::patch('servers/{server}/status', [ServerController::class, 'updateStatus']);
});
