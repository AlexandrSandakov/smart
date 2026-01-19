<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\Manager\ManagerTicketController;
use App\Http\Controllers\Api\AuthController;

Route::post('/tickets', [TicketController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login', [AuthController::class, 'login']);

Route::prefix('manager')->middleware(['auth:sanctum','role:manager'])->group(function () {
    Route::get('/tickets', [ManagerTicketController::class, 'index']);
});
