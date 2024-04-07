<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;

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
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
Route::controller(CompanyController::class)->prefix('company')->group(function () {
    Route::get('/', 'index');
    Route::post('/create', 'store');
    Route::get('/show/{id}', 'show');
    Route::put('/update/{id}', 'update');
    Route::post('/update-logo/{id}', 'updateLogo');
    Route::delete('/delete/{id}', 'destroy');
});
Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
    Route::get('/', 'index');
    Route::post('/create', 'store');
    Route::get('/show/{id}', 'show');
    Route::put('/update/{id}', 'update');
    Route::put('/update-profile/{id}', 'updateLogo');
    Route::delete('/delete/{id}', 'destroy');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
