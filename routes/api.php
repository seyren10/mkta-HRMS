<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DisciplinaryMeasureController;
use App\Http\Controllers\EmployeeController;
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
Route::apiResource('disciplinary-measure', DisciplinaryMeasureController::class);
Route::apiResource('violation-type', ViolationTypeController::class);
