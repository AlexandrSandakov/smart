<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Manager\ManagerTicketController;
use App\Http\Controllers\Api\Manager\ManagerTicketStatsController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tickets', [TicketController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login', [AuthController::class, 'login']);

Route::prefix('manager')->middleware(['auth:sanctum', 'role:manager'])->group(function () {
    Route::get('/tickets', [ManagerTicketController::class, 'index']);
    Route::get('/tickets/stats', [ManagerTicketStatsController::class, 'show']);
});
