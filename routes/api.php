<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');

        Route::middleware(['auth:api'])->group(function () {
            Route::get('logout', 'AuthController@logout');
        });
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::get('gif/search', 'GifController@search');
        Route::get('search/history', 'GifController@searchHistory');
        Route::post('gif/favorite', 'GifController@storeFavoriteGif');
        Route::get('gif/favorite', 'GifController@favoriteGifs');
    });
});