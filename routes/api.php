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

    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\V1\UserController::class, 'store']);

    Route::group(['middleware' => ['auth:api']], function ($router) {

        Route::apiResource('permissions', \App\Http\Controllers\Api\V1\PermissionController::class)->only('index');

        Route::post('/verify-token', [\App\Http\Controllers\Api\Auth\AuthController::class, 'verifyToken']);

        Route::apiResource('status', \App\Http\Controllers\Api\V1\StatusController::class);
        Route::apiResource('user', \App\Http\Controllers\Api\V1\UserController::class);
        Route::apiResource('team', \App\Http\Controllers\Api\V1\TeamController::class);
        Route::apiResource('project', \App\Http\Controllers\Api\V1\ProjectController::class);
        Route::apiResource('task', \App\Http\Controllers\Api\V1\TaskController::class);
        Route::apiResource('comments', \App\Http\Controllers\Api\V1\CommentController::class);

        Route::post('/image', [\App\Http\Controllers\Api\V1\ImageController::class, 'store']);



//        Route::get('/user', [\App\Http\Controllers\Api\V1\UserController::class, 'index']);
//        Route::post('/user', [\App\Http\Controllers\Api\V1\UserContrsksller::class, 'store']);
//        Route::put('/user/{id}', [\App\Http\Controllers\Api\V1\UserController::class, 'update']);
//        Route::delete('/user/{id}', [\App\Http\Controllers\Api\V1\UserController::class, 'destroy']);
    });
});

