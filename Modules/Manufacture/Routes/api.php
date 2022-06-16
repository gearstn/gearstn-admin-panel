<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Manufacture\Http\Controllers\ManufactureController;

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
        Route::prefix('manufactures')->group(function () {
            Route::get('all', [ManufactureController::class, 'get_all'])->name('frontend.manufactures.all');
            Route::get('filtered', [ManufactureController::class, 'get_manufactures_filtered'])->name('frontend.manufactures.filtered');
        });
        Route::resource('manufactures', 'ManufactureController' ,['as' => 'frontend']);
    });
});
