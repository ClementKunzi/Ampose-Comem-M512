<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItineraryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ItineraryTypeController;
use App\Http\Controllers\Api\ItinerarySourceController;
use App\Http\Controllers\API\TagAccessibilityController;
use App\Http\Controllers\API\TagCategorieController;
use App\Http\Controllers\API\ItineraryDifficultyController;
use App\Http\Controllers\API\FavoriteController;
use App\Models\TagAccessibility;
use App\Models\TagCategorie;

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
        Route::post('/add', [ItineraryController::class, 'store']);
        Route::put('/update/{id}', [ItineraryController::class, 'update']);
        Route::delete('/delete/{id}', [ItineraryController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'itinerary-types'], function () {
    Route::get('/', [ItineraryTypeController::class, 'index']);
});

Route::group(['prefix' => 'itinerary-sources'], function () {
    Route::get('/', [ItinerarySourceController::class, 'index']);
});

Route::group(['prefix' => 'itinerary-categories'], function () {
    Route::get('/', [TagCategorieController::class, 'index']);
});

Route::group(['prefix' => 'itinerary-accessibility'], function () {
    Route::get('/', [TagAccessibilityController::class, 'index']);
});

Route::group(['prefix' => 'itinerary-difficulty'], function () {
    Route::get('/', [ItineraryDifficultyController::class, 'index']);
});

Route::group(['prefix' => 'images'], function () {
    Route::get('/', [ImageController::class, 'index']);
    Route::get('{filename}', [ImageController::class, 'show']);
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

Route::group(['prefix' => 'favorites'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [FavoriteController::class, 'store']);
        Route::delete('/{id}', [FavoriteController::class, 'destroy']);
    });
});