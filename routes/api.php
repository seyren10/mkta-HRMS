<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DisciplinaryActionController;
use App\Http\Controllers\DisciplinaryMeasureController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeViolationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PendingViolationController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\ViolationTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('department', DepartmentController::class);
Route::apiResource('employee', EmployeeController::class);
Route::apiResource('employee-violation', EmployeeViolationController::class);
Route::apiResource('pending-violation', PendingViolationController::class)->except('destroy');
Route::delete('pending-violation/{ids}', [PendingViolationController::class, 'destroy']);
Route::apiResource('disciplinary-measure', DisciplinaryMeasureController::class);
Route::apiResource('disciplinary-action', DisciplinaryActionController::class);
Route::apiResource('violation-type', ViolationTypeController::class);
Route::apiResource('violation', ViolationController::class);

Route::controller(NotificationController::class)->group(function () {
    Route::get('notification', 'index');
    Route::put('notification/{notificationId}', 'markAsRead');
    Route::put('notification', 'markAllAsRead');
});
