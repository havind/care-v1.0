<?php

use App\Http\Controllers\Risk\Fleet\{ApprovalController, CarController, FleetController};

Route::prefix('risk')->group(function () {
    Route::prefix('fleet')->group(function () {
        Route::get('/', FleetController::class)->name('fleet');
        Route::get('/movements-schedule', [FleetController::class, 'movements_schedule'])->name('fleet.movements-schedule');
        Route::get('/assign-movements', [FleetController::class, 'assign_movements'])->name('fleet.assign-movements');

        Route::get('/cars/{car}/delete', [CarController::class, 'delete'])->name('cars.delete');
        Route::resource('cars', CarController::class);
    });

    // Approval
    Route::resource('approvals', ApprovalController::class)->except(['create', 'store', 'edit', 'destroy']);

    // Movement Request
    Route::get('/movement-requests/{movement_request}/delete', [MovementRequestController::class, 'delete'])->name('movement-requests.delete');
    Route::get('/movement-requests/{movement_request}/print', [MovementRequestController::class, 'print'])->name('movement-requests.print');
    Route::resource('movement-requests', MovementRequestController::class)->except(['create', 'store', 'edit', 'update']);

    // Location
    Route::get('/locations/{location}/delete', [LocationController::class, 'delete'])->name('locations.delete');
    Route::resource('locations', LocationController::class)->except(['show']);
});
