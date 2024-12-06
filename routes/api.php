<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('games/global', [GameController::class, 'global_history']);
Route::apiResource('games', GameController::class);

Route::get('/users/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login', [AuthController::class, "login"]);

Route::post('/shop', [ShopController::class, 'addNotification']);
Route::get('/shop/{username}', [ShopController::class, 'getNotifications']);