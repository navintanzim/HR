<?php

use App\Modules\Employees\Controllers\EmployeesController;
use Illuminate\Support\Facades\Route;

Route::prefix('attendance')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('/', [EmployeesController::class, 'index'])->name('employees.index');
    });
});
