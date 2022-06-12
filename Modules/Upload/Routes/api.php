<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Upload\Http\Controllers\UploadController;

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
Route::group(['prefix' => '/','middleware' => 'cors'], function () {
    //Auth routes
    Route::middleware('auth:sanctum')->group( function () {

        Route::resource('uploads', 'UploadController' );
        Route::delete('uploads', [UploadController::class , 'destroy']);
        Route::post('/upload-video', [ UploadController::class , 'upload_video' ] ,['as' => 'frontend']);
    });
});
