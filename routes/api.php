<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

Route::prefix('auth')->name('user.')->group(function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::middleware('jwt.verify')->get('/logout', [AuthController::class, 'logout']);
  Route::middleware('jwt.verify')->get('/current_user', [AuthController::class, 'getUser']);

});

Route::post('/create-user', [UserController::class, 'storeUser']);

Route::middleware('jwt.verify')->prefix('user')->name('user.')->group(function () {
  Route::get('/', [UserController::class, 'index']);
});
