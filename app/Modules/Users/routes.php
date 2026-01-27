<?php

use App\Modules\Users\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('users.index');
    Route::put('/', [UsersController::class, 'update'])->name('users.update');
});

Route::middleware('auth')->group(function () { 
    Route::get('/register', [UsersController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UsersController::class, 'register']);
});
