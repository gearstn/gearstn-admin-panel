<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\SubCategory\Http\Controllers\SubCategoryController;

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
    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('sub-categories', 'SubCategoryController', ['as' => 'frontend']);
        Route::prefix('sub-categories')->group(function () {
            Route::get('all', [SubCategoryController::class, 'get_all'])->name('frontend.sub-categories.all');
            Route::get('filtered', [SubCategoryController::class, 'get_subcategories_filtered'])->name('frontend.sub-categories.filtered');
        });
    });
});
