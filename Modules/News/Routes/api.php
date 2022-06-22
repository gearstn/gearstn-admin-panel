<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\NewsController;

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
    Route::middleware('auth:sanctum')->group( function () {
        Route::get('/latest-news', [NewsController::class, 'latest_news'] ,['as' => 'frontend']);
        Route::resource('news', 'NewsController' ,['as' => 'frontend']);
    });
});
