<?php

use App\Http\Controllers\Api\Auth\RegisterController;
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
    Route::get('/verify-email/{token}', [RegisterController::class, 'verifyAccount'])->name('verification.verify');
    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->name('logout');
    Route::post('/register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
    Route::get('/send-mail', [App\Http\Controllers\MailController::class, 'index']);


    Route::group(['middleware' => ['auth:api']], function ($router) {

        Route::apiResource('permissions', \App\Http\Controllers\Api\V1\PermissionController::class)->only('index');
        Route::post('permissions/refresh', [\App\Http\Controllers\Api\V1\PermissionController::class, 'refresh'])->name('permissions.refresh');

        Route::post('/verify-token', [\App\Http\Controllers\Api\Auth\AuthController::class, 'verifyToken']);

        Route::apiResource('status', \App\Http\Controllers\Api\V1\StatusController::class);
        Route::apiResource('user', \App\Http\Controllers\Api\V1\UserController::class);
        Route::apiResource('team', \App\Http\Controllers\Api\V1\TeamController::class);
        Route::apiResource('project', \App\Http\Controllers\Api\V1\ProjectController::class);
        Route::apiResource('task', \App\Http\Controllers\Api\V1\TaskController::class)->middleware( 'is_verify_email');;
        Route::apiResource('comments', \App\Http\Controllers\Api\V1\CommentController::class);
        Route::apiResource('roles', \App\Http\Controllers\Api\V1\RoleController::class);


        Route::post('/image', [\App\Http\Controllers\Api\V1\ImageController::class, 'store']);

        Route::get('/dashboard',[\App\Http\Controllers\Api\V1\UserController::class, 'dashboard']);
        Route::get('/sameTeam',[\App\Http\Controllers\Api\V1\UserController::class, 'sameTeam']);
        Route::get('/noTeam',[\App\Http\Controllers\Api\V1\UserController::class, 'noTeam']);
        Route::get('/show',[\App\Http\Controllers\Api\V1\UserController::class, 'showUser']);
        Route::post('/invite', [\App\Http\Controllers\Api\V1\InviteTeamController::class, 'invite']);
        Route::get('/get-team', [\App\Http\Controllers\Api\V1\InviteTeamController::class, 'getTeam']);
        Route::get('/verify-invite/{id}/{token}', [\App\Http\Controllers\Api\V1\InviteTeamController::class, 'verify']);
        Route::get('/get-project', [\App\Http\Controllers\Api\V1\ProjectController::class, 'getProject']);
        Route::post('/remove-user-team', [\App\Http\Controllers\Api\V1\TeamController::class, 'removeUserTeam']);
        Route::get('/get-all-user-team', [\App\Http\Controllers\Api\V1\UserController::class, 'getAllUserTeam']);



//        Route::get('/user', [\App\Http\Controllers\Api\V1\UserController::class, 'index']);
//        Route::post('/user', [\App\Http\Controllers\Api\V1\UserContrsksller::class, 'store']);
//        Route::put('/user/{id}', [\App\Http\Controllers\Api\V1\UserController::class, 'update']);
//        Route::delete('/user/{id}', [\App\Http\Controllers\Api\V1\UserController::class, 'destroy']);
    });
});

