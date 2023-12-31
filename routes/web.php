<?php

use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Authentication End points */

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);


Route::get('/', function () {
    return view('app');
});
Route::fallback(function () {
    return view('app');
});


//* Document Generation end-points
Route::prefix('/generate')->group(function () {
    Route::get('/tardiness', [TemplateController::class, 'tardiness']);
});
