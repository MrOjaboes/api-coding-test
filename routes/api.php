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


Route::middleware('auth:sanctum')->group(function () {
    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'store');
        Route::get('/show/{id}', 'show');
        Route::post('/update/{id}', 'update');
        Route::post('/update-logo/{id}', 'updateLogo');
        Route::delete('/delete/{id}', 'destroy');
    });

    Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'store');
        Route::get('/show/{id}', 'show');
        Route::post('/update/{id}', 'update');
        Route::post('/update-photo/{id}', 'updatePhoto');
        Route::delete('/delete/{id}', 'destroy');
    });
    Route::prefix('account')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
