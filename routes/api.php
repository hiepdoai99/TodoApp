<?php

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


Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\UserController::class, 'store']);

    Route::group(['middleware' => ['auth:api']], function ($router) {

        Route::apiResource('permissions', \App\Http\Controllers\PermissionController::class)->only('index');

        Route::post('/verify-token', [\App\Http\Controllers\AuthController::class, 'verifyToken']);
        Route::get('/status', [\App\Http\Controllers\StatusController::class, 'index']);
        Route::post('/create-status', [\App\Http\Controllers\StatusController::class, 'store']);
        Route::put('/edit-status/{id}', [\App\Http\Controllers\StatusController::class, 'edit']);
        Route::delete('/delete-status/{id}', [\App\Http\Controllers\StatusController::class, 'destroy']);

        Route::get('/todo', [\App\Http\Controllers\TodoController::class, 'index']);
        Route::get('/todo/{id}', [\App\Http\Controllers\TodoController::class, 'show']);
        Route::post('/todo', [\App\Http\Controllers\TodoController::class, 'store']);
        Route::put('/todo/{id}', [\App\Http\Controllers\TodoController::class, 'edit']);
        Route::delete('/todo/{id}', [\App\Http\Controllers\TodoController::class, 'destroy']);

        Route::get('/user', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('/user', [\App\Http\Controllers\UserController::class, 'store']);
        Route::put('/user/{id}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('/user/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
    });
});

