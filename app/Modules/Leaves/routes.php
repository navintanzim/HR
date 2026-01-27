<?php

use App\Modules\Leaves\Controllers\LeavesController;
use Illuminate\Support\Facades\Route;

Route::prefix('leaves')->group(function () {

    Route::middleware('auth')->group(function () {

        Route::get('/', [LeavesController::class, 'index'])->name('employees.index');
        Route::get('/apply', [LeavesController::class, 'create'])
            ->name('leaves.apply');
        Route::post('/apply', [LeavesController::class, 'store'])
            ->name('leaves.store');

        Route::get('/{id}/process', [LeavesController::class, 'showProcessForm'])
            ->name('leaves.process.form');
        Route::get('/{id}/employee', [LeavesController::class, 'employeeData'])
            ->name('leaves.employee');
        Route::post('/{id}/process', [LeavesController::class, 'process'])
            ->name('leaves.process');

        Route::get('/{id}/leave-count', [LeavesController::class, 'leaveCount']);
    });
});
