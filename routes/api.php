<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\FileController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user', [AuthController::class, 'user']);

    Route::prefix('dir')->group(function () {
        Route::get('list', [DirectoryController::class, 'getAllUserDirectories']);
        Route::post('create', [DirectoryController::class, 'createDirectory']);
    });

    Route::prefix('file')->group(function () {
        Route::post('upload', [FileController::class, 'upload']);
    });

});
