<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItineraryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ImageController;

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

Route::group(['prefix' => 'itineraries'], function () {
    Route::get('/', [ItineraryController::class, 'index']);
    Route::get('/{id}', [ItineraryController::class, 'show']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [ItineraryController::class, 'store']);
        Route::put('/{id}', [ItineraryController::class, 'update']);
        Route::delete('/delete/{id}', [ItineraryController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'images'], function () {
    Route::get('/', [ImageController::class, 'index']);
    Route::get('/{id}', [ImageController::class, 'show']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [ImageController::class, 'store']);
        Route::delete('/delete/{id}', [ImageController::class, 'destroy']);
    });
});





Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});
