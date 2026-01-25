<?php

use App\Http\Controllers\Manager\ManagerTicketController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/widget/ticket', function () {
    return view('widget.ticket');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// create routes for manger to manage tickets
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/tickets', [ManagerTicketController::class, 'index'])->name('manager.tickets.index');
    Route::get('/manager/tickets/{ticket}', [ManagerTicketController::class, 'show'])
        ->name('manager.tickets.show');
});

require __DIR__.'/auth.php';
