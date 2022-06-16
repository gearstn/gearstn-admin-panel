<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;

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
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('/categories')->group(function () {
            Route::get('all', [CategoryController::class, 'get_all'])->name('frontend.categories.all');
            Route::get('filtered', [CategoryController::class, 'get_categories_filtered'])->name('frontend.categories.filtered');
            Route::get('search', [CategoryController::class, 'search'], ['as' => 'frontend'])->name('frontend.categories.search');
        });
        Route::resource('categories', 'CategoryController', ['as' => 'frontend']);
    });
});
