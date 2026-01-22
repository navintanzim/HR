<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/leave/apply', [LeaveController::class, 'create'])
        ->name('leave.apply');

    Route::post('/leave/apply', [LeaveController::class, 'store'])
        ->name('leave.store');
    Route::get('/leave/{id}/process', [LeaveController::class, 'showProcessForm'])
        ->name('leave.process.form');
    Route::post('/leave/{id}/process', [LeaveController::class, 'process'])
        ->name('leave.process');
});



Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

