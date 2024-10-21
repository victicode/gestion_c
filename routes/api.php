<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DepartamentController;
use App\Http\Controllers\Api\TicketController;
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

Route::middleware('jwt.verify')->prefix('departament')->name('departament.')->group(function () {
  Route::get('/get_pendings', [DepartamentController::class, 'getPendings']);
  Route::get('/queue/{id}', [DepartamentController::class, 'getDepartamentQueueById']);

});

Route::prefix('departament')->name('departament.')->group(function () {
  Route::get('/display', [DepartamentController::class, 'getPendings']);

});

Route::middleware('jwt.verify')->prefix('client')->name('client.')->group(function () {
  Route::get('/byCi', [ClientController::class, 'getByCi']);
});

Route::middleware('jwt.verify')->prefix('ticket')->name('ticket.')->group(function () {
  Route::get('/next/{id}', [TicketController::class, 'nextTicket']);
  Route::post('/', [TicketController::class, 'createTicket']);
  Route::post('/delete/{id}', [TicketController::class, 'deleteTicket']);

});
