<?php

use App\Http\Controllers\API\Finance\{BudgetLineAPIController, FundCodeAPIController};
use App\Http\Controllers\API\HumanResource\{DepartmentAPIController, PositionAPIController, UserAPIController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});


/**
 * Users
 */
Route::prefix('users')->group(function () {
//    Route::get('/', [APIController::class, 'getAllUsers'])->name('api.users');
//    Route::get('/active', [APIController::class, 'getAllActiveUsers'])->name('api.users.active');
});

/**
 * Finance
 */
Route::prefix('finance')->group(function () {
    /**
     * Projects
     */


    /**
     * Fund Codes
     */
    Route::get('fund-codes/count', [FundCodeAPIController::class, 'count'])->name('api.finance.fund-codes.count');
    Route::get('fund-codes/all', [FundCodeAPIController::class, 'all'])->name('api.finance.fund-codes.all');
    Route::get('fund-codes/allActive', [FundCodeAPIController::class, 'allActive'])->name('api.finance.fund-codes.allActive');
    Route::get('fund-codes/allInactive', [FundCodeAPIController::class, 'allInactive'])->name('api.finance.fund-codes.allInactive');

    /**
     * Budget Lines
     */
    Route::get('budget-lines/count', [BudgetLineAPIController::class, 'count'])->name('api.finance.budget-lines.count');
    Route::get('budget-lines/all', [BudgetLineAPIController::class, 'all'])->name('api.finance.budget-lines.all');
    Route::get('budget-lines/allActive', [BudgetLineAPIController::class, 'allActive'])->name('api.finance.budget-lines.allActive');
    Route::get('budget-lines/allInactive', [BudgetLineAPIController::class, 'allInactive'])->name('api.finance.budget-lines.allInactive');
    Route::get('budget-lines/budgetLinesFilteredByFundCode/{fund_code}', [BudgetLineAPIController::class, 'budgetLinesFilteredByFundCode'])->name('api.finance.budget-lines.budgetLinesFilteredByFundCode');
});

/**
 * Human Resources
 */
Route::prefix('human-resources')->group(function () {
    /**
     * Users
     */
    Route::get('users/count', [UserAPIController::class, 'count'])->name('api.human-resources.users.count');
    Route::get('users/all/{paginate?}', [UserAPIController::class, 'all'])->name('api.human-resources.users.all');
    Route::get('users/allActive', [UserAPIController::class, 'allActive'])->name('api.human-resources.users.allActive');
    Route::get('users/allInactive', [UserAPIController::class, 'allInactive'])->name('api.human-resources.users.allInactive');

    /**
     * Departments
     */
    Route::get('departments/count', [DepartmentAPIController::class, 'count'])->name('api.human-resources.departments.count');
    Route::get('departments/all', [DepartmentAPIController::class, 'all'])->name('api.human-resources.departments.all');
    Route::get('departments/allActive', [DepartmentAPIController::class, 'allActive'])->name('api.human-resources.departments.allActive');
    Route::get('departments/allInactive', [DepartmentAPIController::class, 'allInactive'])->name('api.human-resources.departments.allInactive');

    /**
     * Positions
     */
    Route::get('departments/{department}/positions', [PositionAPIController::class, 'positions'])->name('api.human-resources.departments.positions');
});
/**
 * Risk
 */
Route::prefix('risk')->group(function () {
//    Route::post('/saveNewTrip', [APIController::class, 'saveNewTrip'])->name('api.risk.saveNewTrip');
});
