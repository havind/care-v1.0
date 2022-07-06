<?php

use App\Http\Controllers\Admin\{AdminController, AdminDepartment\AAccommodationController, Finance\ABudgetLineController, Finance\AFundCodeController, Finance\AProjectController, HumanResource\ADepartmentController, HumanResource\APermissionController, HumanResource\APositionController, HumanResource\AUserController, Risk\AMovementRequestController};
use App\Http\Controllers\Finance\{BudgetLineController, FinanceController, FundCodeController};
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HumanResource\{DepartmentController, HumanResourceController, PositionController, StaffController};
use App\Http\Controllers\User\{MovementController, UserController};
use Illuminate\Support\Facades\Route;

// Controllers

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::redirect('/home', HomeController::class, 200);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/test', [HomeController::class, 'test'])->name('test');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

// Risk
require __DIR__ . '/risk.php';

// Human Resources
Route::prefix('human-resources')->group(function () {
    Route::get('/', HumanResourceController::class)->name('human-resources.index');

    // Staff
    Route::get('/staff/{staff}/delete', [StaffController::class, 'delete'])->name('staff.delete');
    Route::resource('staff', StaffController::class);

    // Department
    Route::get('/departments/{departments}/delete', [DepartmentController::class, 'delete'])->name('departments.delete');
    Route::get('/departments/{departments}/staff', [DepartmentController::class, 'departmentStaff'])->name('departments.staff');
    Route::get('/departments/{departments}/staff/create', [DepartmentController::class, 'departmentNewStaff'])->name('departments.staff.create');
    Route::resource('departments', DepartmentController::class);

    // Position
    Route::get('/departments/{departments}/positions/{positions}/delete', [PositionController::class, 'delete'])->name('departments.positions.delete');
    Route::resource('departments.positions', PositionController::class);
});

// Finance
Route::prefix('finance')->group(function () {
    Route::get('/', FinanceController::class)->name('finance.index');

    // Fund Codes
    Route::get('/fund-codes/{fund_code}/delete', [FundCodeController::class, 'delete'])->name('fund-codes.delete');
    Route::resource('fund-codes', FundCodeController::class);

    // Budget Lines
    Route::get('/budget-lines/{budget-line}/delete', [BudgetLineController::class, 'delete'])->name('budget-lines.delete');
    Route::get('/budget-lines/jsonBudgetLinesByFundCode/{fund_code}', [BudgetLineController::class, 'jsonBudgetLinesByFundCode'])->name('budget-lines.jsonBudgetLines');
    Route::resource('budget-lines', BudgetLineController::class);
});


// Admin
Route::prefix('a')->group(function () {
    // Home
    Route::get('/', AdminController::class)->name('a.index');

    /**
     * Finance
     */
    Route::prefix('finance')->group(function () {
        Route::resource('fund-codes', AFundCodeController::class, ['as' => 'a']);
        Route::resource('budget-lines', ABudgetLineController::class, ['as' => 'a']);
        // Projects
        Route::get('/projects/{project}/delete', [AProjectController::class, 'delete'])->name('a.projects.delete');
        Route::resource('projects', AProjectController::class, ['as' => 'a']);
    });

    /**
     * Human Resources
     */
    Route::prefix('human-resources')->group(function () {
        /**
         * Departments
         */
        Route::get('/departments/{departments}/delete', [ADepartmentController::class, 'delete'])->name('a.human-resources.departments.delete');
        Route::resource('departments', ADepartmentController::class, ['as' => 'a.human-resources']);

        /**
         * Positions
         */

        Route::get('/positions/{positions}/delete', [APositionController::class, 'delete'])->name('a.human-resources.departments.positions.delete');
        Route::resource('departments.positions', APositionController::class, ['as' => 'a.human-resources']);

        /**
         * Users
         */
        Route::get('/users/{users}/delete', [AUserController::class, 'delete'])->name('a.human-resources.users.delete');
        Route::get('/users/{users}/permissions', [APermissionController::class, 'show'])->name('a.human-resources.users.permissions.show');
        Route::put('/users/{users}/permissions', [AUserController::class, 'update'])->name('a.human-resources.users.permissions.update');
        Route::get('/users/{users}/reset-password', [AUserController::class, 'reset_password'])->name('a.human-resources.users.reset-password');
        Route::put('/users/{users}/reset-password', [AUserController::class, 'update_password'])->name('a.human-resources.users.reset-password');
        Route::resource('users', AUserController::class, ['as' => 'a.human-resources']);
    });


    // Risk
    Route::prefix('risk')->group(function () {
        Route::get('/movement-requests/{movement_request}/delete', [AMovementRequestController::class, 'delete'])->name('a.risk.movement-requests.delete');
        Route::resource('movement-requests', AMovementRequestController::class, ['as' => 'a.risk']);
    });


    // Admin Department.
    Route::prefix('admin')->group(function () {
        Route::get('/accommodation/{accommodation}/delete', [AAccommodationController::class, 'delete'])->name('a.admin.accommodation.delete');
        Route::resource('accommodation', AAccommodationController::class, ['as' => 'a.admin']);
    });

});

// User
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'profile'])->name('users.profile');
    Route::get('/reset-password', [UserController::class, 'reset_password'])->name('users.reset-password');
    Route::put('/reset-password', [UserController::class, 'update_password'])->name('users.update-password');
    Route::get('/acting', [UserController::class, 'acting'])->name('users.acting');
    Route::put('/acting', [UserController::class, 'update_acting'])->name('users.update-acting');

    // Position
    Route::get('/movements/{movements}/delete', [MovementController::class, 'delete'])->name('movements.delete');
    Route::resource('movements', MovementController::class);
});
