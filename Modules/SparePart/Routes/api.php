<?php

use Illuminate\Support\Facades\Route;
use Modules\SparePart\Http\Controllers\SparePartController;

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

//Routes for frontend
Route::group(['middleware' => 'cors'], function () {

    //Auth routes
    Route::middleware('auth:sanctum')->group( function () {
        //Store Update Destroy routes for Machines and Models
        Route::resource('spare-parts', 'SparePartController' ,['as' => 'frontend']);
        Route::get('/user-spare-parts', [SparePartController::class, 'user_spare_parts']);
        //Search for all Entities
        Route::get('/spare-parts-search', [SparePartController::class, 'search_filter']);
        Route::get('/spare-parts-filter-data', [SparePartController::class, 'getMinMaxOfField']);
        Route::get('/related-spare-parts', [SparePartController::class, 'getRelatedSpareParts']);
        Route::get('/spare-part-price', [SparePartController::class, 'get_spare_part_price']);
        Route::get('/latest-spare-parts', [SparePartController::class, 'latest_spare_parts'] ,['as' => 'frontend']);
        Route::get('/spare-part-view', [SparePartController::class, 'add_spare_part_view']);
    });
});
