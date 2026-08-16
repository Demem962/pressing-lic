<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/gestion/services', [ServiceController::class, 'indexAll']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::patch('/services/{service}/archiver', [ServiceController::class, 'archive']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    Route::get('/gestion/tickets', [TicketController::class, 'indexAll']);
    Route::patch('/tickets/{ticket}/statut', [TicketController::class, 'updateStatut']);
    Route::patch('/tickets/{ticket}/annuler', [TicketController::class, 'cancel']);
});
