<?php

use Illuminate\Support\Facades\Route;
use Modules\MachineModel\Http\Controllers\MachineModelController;

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
        Route::resource('machine-models', 'MachineModelController' ,['as' => 'frontend']);
        Route::get('/filter_models', [ MachineModelController::class , 'filter_models' ])->name('machine-models.filter_models');
    });
});
