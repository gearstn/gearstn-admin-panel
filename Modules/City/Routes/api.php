<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\City\Http\Controllers\CityController;

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
Route::group(['middleware' => 'cors'], function () {
    //Auth routes
    Route::middleware('auth:sanctum')->group( function () {
        Route::prefix('/cities')->group(function () {
            Route::get('search', [CityController::class, 'search'], ['as' => 'frontend'])->name('frontend.cities.search');
        });
        Route::resource('cities', 'CityController' ,['as' => 'frontend']);
    });
});

