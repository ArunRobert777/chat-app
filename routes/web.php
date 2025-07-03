<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/rooms', [RoomController::class, 'index'])->name('room.index');
    Route::post('/create-room', [RoomController::class, 'store'])->name('room.store');
    Route::delete('/delete-room/{room}', [RoomController::class, 'destroy'])->name('room.destroy');

    Route::get('/chat/{room}', [RoomController::class, 'join'])->name('room.join');

    Route::post('/chat/send', [MessageController::class, 'store'])->name('message.send');

    Route::post('/chat/private', [RoomController::class, 'getPrivateRoomMessages'])->name('message.private');
});

require __DIR__ . '/auth.php';
