<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

require base_path('app/Modules/Settings/routes.php');
require base_path('app/Modules/Employees/routes.php');
require base_path('app/Modules/Leaves/routes.php');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    Route::post('/checkin', [DashboardController::class, 'Checkin'])
        ->name('checkin');

    Route::get('/admin/attendance/{employee}', [DashboardController::class, 'employeeAttendanceData'])
    ->name('admin.attendance');
});


Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

